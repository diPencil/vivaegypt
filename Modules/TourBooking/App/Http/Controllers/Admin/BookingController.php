<?php

declare(strict_types=1);

namespace Modules\TourBooking\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\TourBooking\App\Models\ExtraCharge;

final class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $bookings = $this->getUnifiedBookingsList($request);

        return view('tourbooking::admin.bookings.index', compact('bookings'));
    }

    private function getUnifiedBookingsList(Request $request, ?string $status = null)
    {
        $search = $request->query('search');

        // 1. TourBooking bookings
        $tourQuery = Booking::with(['service', 'user']);
        if ($status) {
            $tourQuery->where('booking_status', $status);
        }
        if ($search) {
            $tourQuery->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        $tourBookings = $tourQuery->get();

        // 2. SPA Bookings
        $spaQuery = \Modules\SpecialBooking\App\Models\SpaBooking::with(['user', 'spaService']);
        if ($status) {
            $spaQuery->where('status', $status);
        }
        if ($search) {
            $spaQuery->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $spaBookings = $spaQuery->get();

        // 3. Flight Requests
        $flightQuery = \Modules\SpecialBooking\App\Models\FlightRequest::with(['user']);
        if ($status) {
            $flightQuery->where('status', $status);
        }
        if ($search) {
            $flightQuery->where(function($q) use ($search) {
                $q->where('request_reference', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $flightRequests = $flightQuery->get();

        // 4. Transfer Requests
        $transferQuery = \Modules\SpecialBooking\App\Models\TransferRequest::with(['user']);
        if ($status) {
            $transferQuery->where('status', $status);
        }
        if ($search) {
            $transferQuery->where(function($q) use ($search) {
                $q->where('request_reference', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $transferRequests = $transferQuery->get();

        // 5. Nile Cruise Requests
        $nileQuery = \Modules\SpecialBooking\App\Models\NileCruiseRequest::with(['user']);
        if ($status) {
            $nileQuery->where('status', $status);
        }
        if ($search) {
            $nileQuery->where(function($q) use ($search) {
                $q->where('request_reference', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $nileRequests = $nileQuery->get();

        $unified = collect();

        foreach ($tourBookings as $b) {
            $unified->push((object)[
                'id' => $b->id,
                'type' => 'Tour Booking',
                'reference' => '#' . ($b->booking_code ?? 'N/A'),
                'customer_name' => $b->customer_name,
                'customer_email' => $b->customer_email,
                'customer_phone' => $b->customer_phone,
                'date' => $b->check_in_date ?? $b->created_at,
                'created_at' => $b->created_at,
                'service' => $b->service->title ?? 'N/A',
                'location' => $b->service->location ?? 'N/A',
                'status' => $b->booking_status,
                'payment_status' => $b->payment_status ?? 'N/A',
                'amount' => $b->total,
                'view_url' => dashboard_route('admin.tourbooking.bookings.show', [$b->id]),
                'delete_url' => !\Illuminate\Support\Facades\Auth::guard('web')->user()?->isStaff() ? route('admin.tourbooking.bookings.destroy', $b->id) : null,
                'is_tour' => true,
            ]);
        }

        foreach ($spaBookings as $b) {
            $unified->push((object)[
                'id' => $b->id,
                'type' => 'SPA Booking',
                'reference' => $b->booking_reference ?? 'SPA-N/A',
                'customer_name' => $b->full_name,
                'customer_email' => $b->email,
                'customer_phone' => $b->phone,
                'date' => $b->preferred_date ? $b->preferred_date->format('Y-m-d') : ($b->created_at ? $b->created_at->format('Y-m-d') : 'N/A'),
                'created_at' => $b->created_at,
                'service' => $b->spaService->title ?? 'SPA service',
                'location' => 'N/A',
                'status' => $b->status,
                'payment_status' => $b->payment_status ?? 'N/A',
                'amount' => $b->quoted_price ?? 0,
                'view_url' => route('admin.special-booking.spa-bookings.show', $b->id),
                'delete_url' => null,
                'is_tour' => false,
            ]);
        }

        foreach ($flightRequests as $b) {
            $unified->push((object)[
                'id' => $b->id,
                'type' => 'Flight Request',
                'reference' => $b->request_reference ?? 'FLT-N/A',
                'customer_name' => $b->full_name,
                'customer_email' => $b->email,
                'customer_phone' => $b->phone,
                'date' => $b->departure_date ? $b->departure_date->format('Y-m-d') : ($b->created_at ? $b->created_at->format('Y-m-d') : 'N/A'),
                'created_at' => $b->created_at,
                'service' => 'Flights By Request',
                'location' => 'N/A',
                'status' => $b->status,
                'payment_status' => $b->payment_status ?? 'N/A',
                'amount' => $b->quoted_price ?? 0,
                'view_url' => route('admin.special-booking.flight-requests.show', $b->id),
                'delete_url' => null,
                'is_tour' => false,
            ]);
        }

        foreach ($transferRequests as $b) {
            $unified->push((object)[
                'id' => $b->id,
                'type' => 'Transfer Request',
                'reference' => $b->request_reference ?? 'TRF-N/A',
                'customer_name' => $b->full_name,
                'customer_email' => $b->email,
                'customer_phone' => $b->phone,
                'date' => $b->pickup_date ? $b->pickup_date->format('Y-m-d') : ($b->created_at ? $b->created_at->format('Y-m-d') : 'N/A'),
                'created_at' => $b->created_at,
                'service' => $b->vehicle_type ?? 'Transfer',
                'location' => 'N/A',
                'status' => $b->status,
                'payment_status' => $b->payment_status ?? 'N/A',
                'amount' => $b->quoted_price ?? 0,
                'view_url' => route('admin.special-booking.transfer-requests.show', $b->id),
                'delete_url' => null,
                'is_tour' => false,
            ]);
        }

        foreach ($nileRequests as $b) {
            $unified->push((object)[
                'id' => $b->id,
                'type' => 'Nile Cruise Request',
                'reference' => $b->request_reference ?? 'NCR-N/A',
                'customer_name' => $b->full_name,
                'customer_email' => $b->email,
                'customer_phone' => $b->phone,
                'date' => $b->checkin_date ? $b->checkin_date->format('Y-m-d') : ($b->created_at ? $b->created_at->format('Y-m-d') : 'N/A'),
                'created_at' => $b->created_at,
                'service' => $b->route ?? 'Nile Cruise',
                'location' => 'N/A',
                'status' => $b->status,
                'payment_status' => $b->payment_status ?? 'N/A',
                'amount' => $b->quoted_price ?? 0,
                'view_url' => route('admin.special-booking.nile-cruise-requests.show', $b->id),
                'delete_url' => null,
                'is_tour' => false,
            ]);
        }

        $sorted = $unified->sortByDesc('created_at');

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->all();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );
    }

    /**
     * Display bookings filtered by status.
     */
    public function getByStatus(Request $request, string $status): View
    {
        $bookings = $this->getUnifiedBookingsList($request, $status);

        return view('tourbooking::admin.bookings.index', compact('bookings'))
            ->with('statusFilter', $status);
    }

    /**
     * Display pending bookings.
     */
    public function pending(Request $request): View
    {
        return $this->getByStatus($request, 'pending');
    }

    /**
     * Display confirmed bookings.
     */
    public function confirmed(Request $request): View
    {
        return $this->getByStatus($request, 'confirmed');
    }

    /**
     * Display completed bookings.
     */
    public function completed(Request $request): View
    {
        return $this->getByStatus($request, 'completed');
    }

    /**
     * Display cancelled bookings.
     */
    public function cancelled(Request $request): View
    {
        return $this->getByStatus($request, 'cancelled');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $services = Service::where('status', true)->get();

        return view('tourbooking::admin.bookings.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'check_in_time' => 'nullable',
            'check_out_time' => 'nullable',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'service_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'extra_charges' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,completed',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Generate booking code
        $validated['booking_code'] = Booking::generateBookingCode();

        // Calculate due amount
        $validated['due_amount'] = $validated['total'] - ($validated['paid_amount'] ?? 0);

        $booking = Booking::create($validated);

        return redirect(dashboard_route('admin.tourbooking.bookings.show', $booking))
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): View
    {

        $booking->load(['service', 'user']);

        $extra_services = ExtraCharge::whereIn('id', $booking?->extra_services ?? [])
            ->where('status', true)
            ->get();

        return view('tourbooking::admin.bookings.details', compact('booking', 'extra_services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking): View
    {
        $booking->load(['service', 'user']);
        $services = Service::where('status', true)->get();

        return view('tourbooking::admin.bookings.edit', compact('booking', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'check_in_time' => 'nullable',
            'check_out_time' => 'nullable',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'service_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'extra_charges' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:pending,completed',
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Calculate due amount
        $validated['due_amount'] = $validated['total'] - ($validated['paid_amount'] ?? 0);

        // Set timestamps for status changes
        if ($booking->booking_status !== $validated['booking_status']) {
            switch ($validated['booking_status']) {
                case 'confirmed':
                    $validated['confirmed_at'] = now();
                    break;
                case 'cancelled':
                    $validated['cancelled_at'] = now();
                    break;
                case 'completed':
                    $validated['completed_at'] = now();
                    break;
            }
        }

        $booking->update($validated);

        return redirect(dashboard_route('admin.tourbooking.bookings.show', $booking))
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        $notify_message = trans('translate.Booking deleted successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect(dashboard_route('admin.tourbooking.bookings.index'))->with($notify_message);
    }



    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string',
        ]);

        // Set timestamps for status changes
        if ($booking->booking_status !== $validated['booking_status']) {
            switch ($validated['booking_status']) {
                case 'confirmed':
                    $validated['confirmed_at'] = now();
                    break;
                case 'cancelled':
                    $validated['cancelled_at'] = now();
                    break;
                case 'completed':
                    $validated['completed_at'] = now();
                    break;
            }
        }

        $booking->update($validated);

        // Notification logic can be added here

        return back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,completed,confirmed,cancelled'
        ]);

        $booking->update($validated);

        return back()->with('success', 'Payment status updated successfully.');
    }

    /**
     * Generate an invoice for the booking.
     */
    public function invoice(Booking $booking): View
    {
        $booking->load(['service', 'user', 'service.serviceType']);

        return view('tourbooking::admin.bookings.invoice', compact('booking'));
    }

    /**
     * Generate a PDF invoice for the booking.
     */
    public function downloadInvoicePdf(Booking $booking)
    {
        $booking->load(['service', 'user', 'service.serviceType']);

        // Set paper size and orientation
        $pdf = PDF::loadView('tourbooking::admin.bookings.invoice', compact('booking'))
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

    public function bookingConfirm(Request $request)
    {

        $bookingId = $request->input('id');

        $booking = Booking::find($bookingId);

        $booking->update([
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
            'admin_notes' => $request->input('confirmation_message') ?? null,
        ]);

        $notify_message = trans('translate.Booking Confirmed Successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    public function bookingCancel(Request $request)
    {
        $bookingId = $request->input('id');

        $booking = Booking::find($bookingId);

        $booking->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->input('cancellation_reason') ?? null,
        ]);

        $notify_message = trans('translate.Booking Cancelled Successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }
}
