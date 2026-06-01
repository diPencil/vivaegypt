<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\TourBooking\App\Models\Booking;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $dashboardMode = match (true) {
            $admin?->isStaffAccountant() => 'accountant',
            $admin?->isSalesAgent() => 'sales',
            $admin?->isTravelAgent(), $admin?->isBookingAgent() => 'operations',
            $admin?->isStaffDataEntry() => 'data_entry',
            default => 'default',
        };

        $showFinancialCards = in_array($dashboardMode, ['accountant', 'sales', 'default'], true);
        $showOperationsCards = in_array($dashboardMode, ['sales', 'operations', 'data_entry', 'default'], true);

        $spa_income = \Modules\SpecialBooking\App\Models\SpaBooking::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
        $flight_income = \Modules\SpecialBooking\App\Models\FlightRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
        $transfer_income = \Modules\SpecialBooking\App\Models\TransferRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
        $nile_income = \Modules\SpecialBooking\App\Models\NileCruiseRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');

        $total_income = Booking::where('payment_status', 'success')->sum('total') + $spa_income + $flight_income + $transfer_income + $nile_income;

        $spa_paid_count = \Modules\SpecialBooking\App\Models\SpaBooking::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->count();
        $flight_paid_count = \Modules\SpecialBooking\App\Models\FlightRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->count();
        $transfer_paid_count = \Modules\SpecialBooking\App\Models\TransferRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->count();
        $nile_paid_count = \Modules\SpecialBooking\App\Models\NileCruiseRequest::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->count();

        $total_booking = Booking::where('payment_status', 'success')->count() + $spa_paid_count + $flight_paid_count + $transfer_paid_count + $nile_paid_count;

        $commission_type = GlobalSetting::where('key', 'commission_type')->value('value');
        $commission_per_sale = GlobalSetting::where('key', 'commission_per_sale')->value('value');

        $total_commission = 0.00;
        $net_income = $total_income ?? 0;
        if ($commission_type == 'commission') {
            $total_commission = ($commission_per_sale / 100) * ($total_income ?? 0);
            $net_income = ($total_income ?? 0) - $total_commission;
        }

        $lable = array();
        $data = array();
        $start = new Carbon('first day of this month');
        $last = new Carbon('last day of this month');
        $first_date = $start->format('Y-m-d');
        $last_date = $last->format('Y-m-d');
        $today = date('Y-m-d');
        $length = date('d') - $start->format('d');

        for ($i = 1; $i <= $length + 1; $i++) {

            $date = '';
            if ($i == 1) {
                $date = $first_date;
            } else {
                $date = $start->addDays(1)->format('Y-m-d');
            };

            $sum_tour = Booking::whereDate('created_at', $date)->where('payment_status', 'success')->sum('total');
            $sum_spa = \Modules\SpecialBooking\App\Models\SpaBooking::whereDate('created_at', $date)->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
            $sum_flight = \Modules\SpecialBooking\App\Models\FlightRequest::whereDate('created_at', $date)->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
            $sum_transfer = \Modules\SpecialBooking\App\Models\TransferRequest::whereDate('created_at', $date)->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');
            $sum_nile = \Modules\SpecialBooking\App\Models\NileCruiseRequest::whereDate('created_at', $date)->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(payment_status)'), ['paid', 'success'])->sum('quoted_price');

            $sum = $sum_tour + $sum_spa + $sum_flight + $sum_transfer + $sum_nile;
            $data[] = $sum ?? 0;
            $lable[] = $i;
        }

        $data = json_encode($data);
        $lable = json_encode($lable);

        $bookings = Booking::with(['service', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $total_bookings_count = \Modules\TourBooking\App\Models\Booking::count() +
            \Modules\SpecialBooking\App\Models\SpaBooking::count() +
            \Modules\SpecialBooking\App\Models\FlightRequest::count() +
            \Modules\SpecialBooking\App\Models\TransferRequest::count() +
            \Modules\SpecialBooking\App\Models\NileCruiseRequest::count();

        $pending_bookings_count = \Modules\TourBooking\App\Models\Booking::where('booking_status', 'pending')->count() +
            \Modules\SpecialBooking\App\Models\SpaBooking::where('status', 'pending')->count() +
            \Modules\SpecialBooking\App\Models\FlightRequest::where('status', 'pending')->count() +
            \Modules\SpecialBooking\App\Models\TransferRequest::where('status', 'pending')->count() +
            \Modules\SpecialBooking\App\Models\NileCruiseRequest::where('status', 'pending')->count();

        $total_customers_count = \App\Models\User::where('is_staff', '0')->where('is_seller', '0')->count();
        $live_chat_count = \App\Models\LiveChat::where('status', 'open')->count();

        return view('admin.dashboard', [
            'lable' => $lable,
            'data' => $data,
            'bookings' => $bookings ?? [],
            'total_income' => $total_income ?? 0,
            'total_commission' => $total_commission,
            'net_income' => $net_income,
            'total_sold' => $total_booking ?? 0,
            'dashboardMode' => $dashboardMode,
            'showFinancialCards' => $showFinancialCards,
            'showOperationsCards' => $showOperationsCards,
            'total_bookings_count' => $total_bookings_count,
            'pending_bookings_count' => $pending_bookings_count,
            'total_customers_count' => $total_customers_count,
            'live_chat_count' => $live_chat_count,
        ]);
    }
}
