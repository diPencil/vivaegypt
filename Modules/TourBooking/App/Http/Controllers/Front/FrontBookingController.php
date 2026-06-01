<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\TourBooking\App\Models\Availability;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Coupon;
use Modules\TourBooking\App\Models\ExtraCharge;
use Modules\TourBooking\App\Models\Review;
use Modules\TourBooking\App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Modules\Currency\App\Models\Currency;
use Modules\PaymentGateway\App\Models\PaymentGateway;

final class FrontBookingController extends Controller
{
    /**
     * Display the booking form for a service.
     */
    public function bookingCheckoutView(Request $request)
    {
        $payment_data = PaymentGateway::all();

        foreach ($payment_data as $data_item) {
            $payment_setting[$data_item->key] = $data_item->value;
        }

        $payment_setting = (object) $payment_setting;

        $razorpay_currency = Currency::findOrFail($payment_setting->razorpay_currency_id);
        $flutterwave_currency = Currency::findOrFail($payment_setting->flutterwave_currency_id);
        $paystack_currency = Currency::findOrFail($payment_setting->paystack_currency_id);

        $auth_user = Auth::guard('web')->user();

        $service = Service::where('id', $request->service_id)
            ->where('status', true)
            ->firstOrFail();

        // Check if an availability_id was provided and verify spots
        if ($request->has('availability_id')) {
            $availability = Availability::find($request->availability_id);

            if ($availability) {
                // Calculate total guests
                $totalGuests = $request->person + $request->children;

                // Check if there are enough spots available
                if ($availability->available_spots !== null && $totalGuests > $availability->available_spots) {
                    $notify_message = trans('translate.Not enough available spots for the selected date');
                    return redirect()->back()->with(['message' => $notify_message, 'alert-type' => 'error']);
                }
            }
        }

        if ($service->is_per_person) {
            $extraCharges = ExtraCharge::select('id', 'name', 'price', 'price_type')->with('translations')->whereIn('id', $request->extras ?? [])
                ->where('status', true)
                ->get();

            $totalExtraCharge = 0;
            foreach ($extraCharges as $extraCharge) {
                $totalExtraCharge += $extraCharge->price;
            }

            $personPrice = $request->person * $service->price_per_person;
            $childPrice = $request->children * $service->child_price;

            $total = $personPrice + $childPrice + $totalExtraCharge;

            $data = [
                'personCount' => $request->person,
                'childCount' => $request->children,
                'extras' => $extraCharges ?? [],
                'service' => $service,
                'personPrice' => $personPrice,
                'childPrice' => $childPrice,
                'total' => $total,
            ];

            session()->forget('payment_cart');

            session()->put('payment_cart', [
                'service_id' => $request->service_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'check_in_time' => $request->check_in_time == 'on' ? $request->check_in_time_hidden : null,
                'check_out_time' => $request->check_out_time == 'on' ? $request->check_out_time_hidden : null,
                'person_count' => $request->person,
                'child_count' => $request->children,
                'total' => $total,
                'extra_charges' => $totalExtraCharge ?? 0,
                'extra_services' => $request->extras ?? [],
                'availability_id' => $request->availability_id ?? null,
            ]);
        } else {
            $data = [
                'service' => $service,
                'total' => $service->discount_price ?? $service->full_price,
            ];

            $total = $service->discount_price ?? $service->full_price;

            session()->forget('payment_cart');

            session()->put('payment_cart', [
                'service_id' => $request->service_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => null,
                'check_in_time' => null,
                'check_out_time' => null,
                'person_count' => 0,
                'child_count' => 0,
                'total' => $total,
                'extra_charges' => 0,
                'extra_services' => [],
                'availability_id' => null,
            ]);
        }

        return view('tourbooking::front.bookings.checkout-view', [
            'service' => $service,
            'data' => $data,
            'payment_setting' => $payment_setting,
            'razorpay_currency' => $razorpay_currency,
            'flutterwave_currency' => $flutterwave_currency,
            'paystack_currency' => $paystack_currency,
            'user' => $auth_user
        ]);
    }

    /**
     * Process a new booking.
     */
    public function processBooking(Request $request, string $slug): RedirectResponse
    {
        $service = Service::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'extra_services' => 'nullable|array',
            'coupon_code' => 'nullable|string',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'customer_notes' => 'nullable|string',
            'payment_method' => 'required|string|in:paypal,stripe,bank_transfer',
        ]);

        // Verify availability
        $this->verifyServiceAvailability($service, $validated['check_in_date'], $validated['check_out_date'] ?? null);

        // Calculate prices
        $priceDetails = $this->calculateBookingPrice(
            $service,
            (int) $validated['adults'],
            (int) ($validated['children'] ?? 0),
            (int) ($validated['infants'] ?? 0),
            $validated['extra_services'] ?? [],
            $validated['coupon_code'] ?? null
        );

        // Create booking data
        $bookingData = [
            'service_id' => $service->id,
            'booking_code' => Booking::generateBookingCode(),
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'infants' => $validated['infants'] ?? 0,
            'service_price' => $service->discounted_price,
            'child_price' => $service->child_price,
            'infant_price' => $service->infant_price,
            'extra_charges' => $priceDetails['extra_charges'],
            'discount_amount' => $priceDetails['discount_amount'],
            'tax_amount' => $priceDetails['tax_amount'],
            'subtotal' => $priceDetails['subtotal'],
            'total' => $priceDetails['total'],
            'paid_amount' => 0,
            'due_amount' => $priceDetails['total'],
            'extra_services' => $validated['extra_services'] ?? [],
            'coupon_code' => $validated['coupon_code'] ?? null,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'booking_status' => 'pending',
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'customer_notes' => $validated['customer_notes'] ?? null,
        ];

        // Associate with user if logged in
        if (Auth::check()) {
            $bookingData['user_id'] = Auth::id();
        }

        $booking = Booking::create($bookingData);

        // Process payment based on the selected method
        switch ($validated['payment_method']) {
            case 'paypal':
                return redirect()->route('front.tourbooking.payment.paypal', $booking->booking_code);
            case 'stripe':
                return redirect()->route('front.tourbooking.payment.stripe', $booking->booking_code);
            case 'bank_transfer':
            default:
                return redirect()->route('front.tourbooking.confirm-booking', $booking->booking_code);
        }
    }

    /**
     * Display the booking confirmation page.
     */
    public function confirmBooking(string $code): View
    {
        $booking = Booking::where('booking_code', $code)
            ->with(['service', 'service.media', 'user'])
            ->firstOrFail();

        return view('tourbooking::front.bookings.confirm', compact('booking'));
    }

    /**
     * Display the booking success page.
     */
    public function bookingSuccess(string $code): View
    {
        $booking = Booking::where('booking_code', $code)
            ->with(['service', 'user'])
            ->firstOrFail();

        return view('tourbooking::front.bookings.success', compact('booking'));
    }

    /**
     * Display the booking cancel page.
     */
    public function bookingCancel(string $code): View
    {
        $booking = Booking::where('booking_code', $code)
            ->with(['service', 'user'])
            ->firstOrFail();

        return view('tourbooking::front.bookings.cancel', compact('booking'));
    }

    /**
     * Check availability for a service.
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        try {
            $this->verifyServiceAvailability($service, $validated['check_in_date'], $validated['check_out_date'] ?? null);

            // Calculate pricing
            $priceDetails = $this->calculateBookingPrice(
                $service,
                (int) $validated['adults'],
                (int) ($validated['children'] ?? 0),
                (int) ($validated['infants'] ?? 0)
            );

            return response()->json([
                'available' => true,
                'message' => 'Service is available for the selected dates.',
                'pricing' => $priceDetails,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Validate a coupon code.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'coupon_code' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'check_in_date' => 'required|date',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $validated['coupon_code'])
            ->where('status', true)
            ->where(function ($query) {
                $query->where('expires_at', '>=', now())
                    ->orWhereNull('expires_at');
            })
            ->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or expired coupon code.',
            ], 422);
        }

        // Check if coupon is valid for this service
        if ($coupon->service_id && $coupon->service_id != $validated['service_id']) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon is not valid for the selected service.',
            ], 422);
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon has reached its usage limit.',
            ], 422);
        }

        // Calculate discount
        $subtotal = (float) $validated['subtotal'];
        $discountAmount = 0;

        if ($coupon->discount_type == 'percentage') {
            $discountAmount = $subtotal * ($coupon->discount_value / 100);

            // Apply max discount if set
            if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                $discountAmount = $coupon->max_discount_amount;
            }
        } else {
            $discountAmount = $coupon->discount_value;

            // Discount cannot be greater than subtotal
            if ($discountAmount > $subtotal) {
                $discountAmount = $subtotal;
            }
        }

        return response()->json([
            'valid' => true,
            'message' => 'Coupon applied successfully.',
            'discount_amount' => $discountAmount,
            'coupon_data' => $coupon,
        ]);
    }

    /**
     * Display user's bookings.
     */
    public function myBookings(): View
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['service', 'service.thumbnail'])
            ->latest()
            ->paginate(10);

        return view('tourbooking::front.bookings.my-bookings', compact('bookings'));
    }

    /**
     * Display a specific booking's details.
     */
    public function bookingDetails(string $code): View
    {
        $booking = Booking::where('booking_code', $code)
            ->where('user_id', Auth::id())
            ->with(['service', 'service.media', 'review'])
            ->firstOrFail();

        return view('tourbooking::front.bookings.details', compact('booking'));
    }

    /**
     * Display an invoice for the booking.
     */
    public function invoice(string $code): View
    {
        $booking = Booking::where('booking_code', $code)
            ->where('user_id', Auth::id())
            ->with(['service', 'service.serviceType'])
            ->firstOrFail();

        return view('tourbooking::front.bookings.invoice', compact('booking'));
    }

    /**
     * Generate a PDF invoice for the booking.
     */
    public function downloadInvoicePdf(string $code)
    {
        $booking = Booking::where('booking_code', $code)
            ->where('user_id', Auth::id())
            ->with(['service', 'service.serviceType'])
            ->firstOrFail();

        // Set paper size and orientation
        $pdf = PDF::loadView('tourbooking::front.bookings.invoice', compact('booking'))
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);

        // Generate a filename for the PDF
        $filename = 'invoice-' . $booking->booking_code . '.pdf';

        // Return the PDF as a download
        return $pdf->download($filename);
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Request $request, string $code): RedirectResponse
    {
        $booking = Booking::where('booking_code', $code)
            ->where('user_id', Auth::id())
            ->where('booking_status', '!=', 'cancelled')
            ->where('booking_status', '!=', 'completed')
            ->firstOrFail();

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $validated['cancellation_reason'],
        ]);

        // Notification logic can be added here

        return redirect()->route('front.tourbooking.my-bookings')
            ->with('success', 'Your booking has been cancelled.');
    }

    /**
     * Submit a review for a completed booking.
     */
    public function leaveReview(Request $request, string $code): RedirectResponse
    {
        $booking = Booking::where('booking_code', $code)
            ->where('user_id', Auth::id())
            ->where('booking_status', 'completed')
            ->where('is_reviewed', false)
            ->firstOrFail();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10|max:1000',
            'title' => 'required|string|max:100',
        ]);

        $review = Review::create([
            'service_id' => $booking->service_id,
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'content' => $validated['review_text'],
            'status' => false, // Pending approval
        ]);

        $booking->update(['is_reviewed' => true]);

        return redirect()->route('front.tourbooking.my-bookings')
            ->with('success', 'Your review has been submitted and is pending approval.');
    }

    /**
     * Verify service availability for the selected date.
     */
    private function verifyServiceAvailability(Service $service, string $checkInDate, ?string $checkOutDate = null): bool
    {
        $checkInDate = \Carbon\Carbon::parse($checkInDate);
        $checkOutDate = $checkOutDate ? \Carbon\Carbon::parse($checkOutDate) : $checkInDate;

        // Check if service has specific availabilities
        $hasAvailabilityRecords = $service->availabilities()->exists();

        if ($hasAvailabilityRecords) {
            // Check if the specific date is available
            $availability = $service->availabilities()
                ->where('date', $checkInDate->format('Y-m-d'))
                ->where('is_available', true)
                ->first();

            if (!$availability) {
                throw new \Exception('The service is not available for the selected date.');
            }

            // Check if there are enough spots available
            if ($availability->available_spots !== null) {
                // Get number of existing bookings for this date
                $existingBookingsCount = Booking::where('service_id', $service->id)
                    ->where('booking_status', '!=', 'cancelled')
                    ->whereDate('check_in_date', $checkInDate)
                    ->sum('adults') + Booking::where('service_id', $service->id)
                    ->where('booking_status', '!=', 'cancelled')
                    ->whereDate('check_in_date', $checkInDate)
                    ->sum('children');

                if ($existingBookingsCount >= $availability->available_spots) {
                    throw new \Exception('Not enough spots available for the selected date.');
                }
            }
        }

        // Check existing bookings to avoid conflicts
        $conflictingBookings = Booking::where('service_id', $service->id)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<=', $checkInDate)
                            ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->exists();

        if ($conflictingBookings) {
            throw new \Exception('The service is already booked for the selected dates.');
        }

        return true;
    }

    /**
     * Calculate booking price details.
     */
    private function calculateBookingPrice(
        Service $service,
        int $adults,
        int $children = 0,
        int $infants = 0,
        array $extraServices = [],
        ?string $couponCode = null
    ): array {
        // Base price calculation
        $basePrice = 0;

        if ($service->price_per_person) {
            $basePrice = ($adults * $service->discounted_price)
                + ($children * ($service->child_price ?? 0))
                + ($infants * ($service->infant_price ?? 0));
        } else {
            $basePrice = $service->discounted_price;
        }

        // Extra charges
        $extraChargesAmount = 0;

        if (!empty($extraServices)) {
            $extraChargesIds = array_keys($extraServices);
            $extraCharges = ExtraCharge::whereIn('id', $extraChargesIds)
                ->where('service_id', $service->id)
                ->get();

            foreach ($extraCharges as $charge) {
                $quantity = $extraServices[$charge->id] ?? 1;
                $extraChargesAmount += $charge->price * $quantity;
            }
        }

        $subtotal = $basePrice + $extraChargesAmount;

        // Apply coupon if provided
        $discountAmount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('status', true)
                ->where(function ($query) {
                    $query->where('expires_at', '>=', now())
                        ->orWhereNull('expires_at');
                })
                ->first();

            if ($coupon && (!$coupon->service_id || $coupon->service_id == $service->id)) {
                if ($coupon->discount_type == 'percentage') {
                    $discountAmount = $subtotal * ($coupon->discount_value / 100);

                    // Apply max discount if set
                    if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                        $discountAmount = $coupon->max_discount_amount;
                    }
                } else {
                    $discountAmount = $coupon->discount_value;

                    // Discount cannot be greater than subtotal
                    if ($discountAmount > $subtotal) {
                        $discountAmount = $subtotal;
                    }
                }
            }
        }

        // Calculate tax (if applicable)
        $taxAmount = 0;
        $taxPercentage = config('tourbooking.tax_percentage', 0);

        if ($taxPercentage > 0) {
            $taxAmount = ($subtotal - $discountAmount) * ($taxPercentage / 100);
        }

        // Calculate total
        $total = $subtotal - $discountAmount + $taxAmount;

        return [
            'base_price' => $basePrice,
            'extra_charges' => $extraChargesAmount,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ];
    }
}
