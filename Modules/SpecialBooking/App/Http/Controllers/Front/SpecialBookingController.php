<?php

namespace Modules\SpecialBooking\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\SpecialBooking\App\Models\SpaService;
use Modules\SpecialBooking\App\Models\SpaBooking;
use Modules\SpecialBooking\App\Models\Airline;
use Modules\SpecialBooking\App\Models\TransferVehicle;
use Modules\SpecialBooking\App\Models\NileCruiseRoute;
use Modules\SpecialBooking\App\Models\NileCruiseCabin;
use Modules\SpecialBooking\App\Models\BookingFeature;
use Modules\SpecialBooking\App\Models\FlightRequest;
use Modules\SpecialBooking\App\Models\TransferRequest;
use Modules\SpecialBooking\App\Models\NileCruiseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpecialBookingController extends Controller
{
    public function index()
    {
        return view('specialbooking::front.index');
    }

    public function spa()
    {
        $services = SpaService::where('status', 1)->with('translations')->orderBy('sort_order')->latest()->get();
        return view('specialbooking::front.spa', compact('services'));
    }

    public function storeSpaBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'spa_service_id' => 'required|exists:spa_services,id',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
            'guests_count' => 'required|integer|min:1',
            'gender_type' => 'required|in:both,male,female',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = SpaService::find($request->spa_service_id);
        if (!$service || !$service->status) {
            return back()->with('error', __('translate.Service not available'))->withInput();
        }

        $data = $request->all();
        $data['booking_reference'] = $this->generateReference('SPA', SpaBooking::class, 'booking_reference');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        SpaBooking::create($data);

        return back()->with('success', __('translate.Your request has been submitted successfully') . '. ' . __('translate.Your booking reference is') . ': ' . $data['booking_reference']);
    }

    public function flights()
    {
        $airlines = Airline::active()->with('translations')->orderBy('sort_order')->latest()->get();
        $whyBookFeatures = BookingFeature::active()
            ->with('translations')
            ->where('context', 'flights_why_book')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('specialbooking::front.flights', compact('airlines', 'whyBookFeatures'));
    }

    public function storeFlightRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_type' => 'required|in:one_way,round_trip,multi_city',
            'from_city' => 'required|string|max:255',
            'to_city' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required_if:trip_type,round_trip|nullable|date|after_or_equal:departure_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'travel_class' => 'required|in:economy,premium_economy,business,first',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['request_reference'] = $this->generateReference('FLT', FlightRequest::class, 'request_reference');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        FlightRequest::create($data);

        return back()->with('success', __('translate.Your request has been submitted successfully') . '. ' . __('translate.Your request reference is') . ': ' . $data['request_reference']);
    }

    public function transfers()
    {
        $vehicles = TransferVehicle::active()->with('translations')->orderBy('sort_order')->latest()->get();
        $whyBookFeatures = BookingFeature::active()
            ->with('translations')
            ->where('context', 'transfers_why_book')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('specialbooking::front.transfers', compact('vehicles', 'whyBookFeatures'));
    }

    public function storeTransferRequest(Request $request)
    {
        $activeVehicleSlugs = TransferVehicle::active()->pluck('slug')->filter()->values()->all();

        $validator = Validator::make($request->all(), [
            'vehicle_type' => ['required', 'string', 'max:255', Rule::in($activeVehicleSlugs)],
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required',
            'passengers_count' => 'required|integer|min:1',
            'transfer_type' => 'required|in:one_way,round_trip',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['request_reference'] = $this->generateReference('TRF', TransferRequest::class, 'request_reference');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        TransferRequest::create($data);

        return back()->with('success', __('translate.Your request has been submitted successfully') . '. ' . __('translate.Your request reference is') . ': ' . $data['request_reference']);
    }

    public function nileCruises()
    {
        $routes = NileCruiseRoute::active()->with('translations')->orderBy('sort_order')->latest()->get();
        $cabins = NileCruiseCabin::active()->with('translations')->orderBy('sort_order')->latest()->get();
        $inclusionFeatures = BookingFeature::active()
            ->with('translations')
            ->where('context', 'nile_inclusions')
            ->orderBy('sort_order')
            ->latest()
            ->get();
        $whyBookFeatures = BookingFeature::active()
            ->with('translations')
            ->where('context', 'nile_why_book')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('specialbooking::front.nile_cruises', compact('routes', 'cabins', 'inclusionFeatures', 'whyBookFeatures'));
    }

    public function storeNileCruiseRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route' => 'required|string|max:255',
            'checkin_date' => 'required|date|after_or_equal:today',
            'nights_count' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'cabins_count' => 'required|integer|min:1',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['request_reference'] = $this->generateReference('NCR', NileCruiseRequest::class, 'request_reference');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        NileCruiseRequest::create($data);

        return back()->with('success', __('translate.Your request has been submitted successfully') . '. ' . __('translate.Your request reference is') . ': ' . $data['request_reference']);
    }

    private function generateReference($prefix, $modelClass, $fieldName)
    {
        $year = date('Y');
        $latest = $modelClass::where($fieldName, 'LIKE', "$prefix-$year-%")
            ->orderBy($fieldName, 'desc')
            ->first();

        if ($latest) {
            $lastRef = $latest->$fieldName;
            $parts = explode('-', $lastRef);
            $lastNumber = (int) end($parts);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return "$prefix-$year-$newNumber";
    }
}
