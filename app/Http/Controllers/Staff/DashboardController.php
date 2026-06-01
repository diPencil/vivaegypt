<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\App\Models\Blog;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Category\Entities\Category;
use Modules\Ecommerce\Entities\Product;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Modules\TourBooking\App\Models\Amenity;
use Modules\TourBooking\App\Models\Booking;
use Modules\TourBooking\App\Models\Destination;
use Modules\TourBooking\App\Models\Service;
use Modules\TourBooking\App\Models\ServiceType;
use Modules\PaymentWithdraw\App\Models\SellerWithdraw;
use App\Models\LiveChat;
use App\Models\User;
use Modules\Ecommerce\Entities\Order;
use Modules\SupportTicket\App\Models\SupportTicket;
use Modules\ContactMessage\App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('web')->user();

        $dashboardMode = match (true) {
            $user?->isStaffAccountant() => 'accountant',
            $user?->isSalesAgent() => 'sales',
            $user?->isTravelAgent(), $user?->isBookingAgent() => 'operations',
            $user?->isStaffDataEntry() => 'data_entry',
            default => 'default',
        };

        $showFinancialCards = in_array($dashboardMode, ['accountant', 'default'], true) || $user?->canSeeStaffSection('finance');
        $showOperationsCards = in_array($dashboardMode, ['sales', 'operations', 'data_entry', 'default'], true) || $user?->canSeeStaffSection('bookings');
        $showContentCards = in_array($dashboardMode, ['operations', 'data_entry', 'default'], true) || $user?->canSeeStaffSection('booking_services');
        $showAccountantCards = $user?->isStaffAccountant() || $user?->canSeeStaffSection('finance');

        $successfulBookings = Booking::query()->where('payment_status', 'success');
        $totalIncome = (float) $successfulBookings->sum('total');
        $totalSold = Booking::query()->where('payment_status', 'success')->count();

        $commissionType = GlobalSetting::where('key', 'commission_type')->value('value');
        $commissionPerSale = (float) GlobalSetting::where('key', 'commission_per_sale')->value('value');
        $totalCommission = 0.0;
        $netIncome = $totalIncome;

        if ($commissionType === 'commission') {
            $totalCommission = ($commissionPerSale / 100) * $totalIncome;
            $netIncome = $totalIncome - $totalCommission;
        }

        $chartStart = Carbon::now()->startOfMonth();
        $chartEndDay = (int) Carbon::now()->format('d');
        $chartLabels = [];
        $chartData = [];

        for ($day = 1; $day <= $chartEndDay; $day++) {
            $date = $chartStart->copy()->day($day)->format('Y-m-d');
            $chartLabels[] = (string) $day;
            
            $sum = Booking::query()
                ->whereDate('created_at', $date)
                ->where('payment_status', 'success')
                ->sum('total');
                
            $chartData[] = $sum ?? 0;
        }

        $latestBookings = Booking::with(['service', 'user'])
            ->latest()
            ->take(8)
            ->get();

        $quickActions = array_values(array_filter([
            [
                'route_name' => 'staff.tourbooking.services.create',
                'route' => route('staff.tourbooking.services.create'),
                'label' => 'Create Service',
                'description' => 'Add a new booking service',
            ],
            [
                'route_name' => 'staff.tourbooking.destinations.create',
                'route' => route('staff.tourbooking.destinations.create'),
                'label' => 'Create Destination',
                'description' => 'Publish a destination entry',
            ],
            [
                'route_name' => 'staff.product.create',
                'route' => route('staff.product.create'),
                'label' => 'Create Product',
                'description' => 'Add a storefront product',
            ],
            [
                'route_name' => 'staff.blog.create',
                'route' => route('staff.blog.create'),
                'label' => 'Create Explore',
                'description' => 'Write a new explore post',
            ],
            [
                'route_name' => 'staff.front-end.frontend-section',
                'route' => route('staff.front-end.frontend-section'),
                'label' => 'Frontend Section',
                'description' => 'Manage homepage content blocks',
            ],
            [
                'route_name' => 'staff.seo-setting',
                'route' => route('staff.seo-setting'),
                'label' => 'SEO Setup',
                'description' => 'Review metadata and indexing settings',
            ],
            [
                'route_name' => 'staff.withdraw-list.index',
                'route' => route('staff.withdraw-list.index'),
                'label' => 'Manage Withdrawals',
                'description' => 'Process seller withdrawal requests',
            ],
        ], function (array $action) use ($user): bool {
            return $user?->canAccessStaffRoute($action['route_name']) ?? false;
        }));

        $dashboardCards = array_values(array_filter([
            // Row 1: Sales & Earnings
            [
                'group' => 'Sales & Earnings',
                'section' => 'finance',
                'label' => 'Total Sales',
                'value' => currency($totalIncome),
                'route' => route('staff.tourbooking.bookings.index'),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sale',
                'accent' => 'success',
            ],
            [
                'group' => 'Sales & Earnings',
                'section' => 'finance',
                'label' => 'Net Earnings',
                'value' => currency($netIncome),
                'route' => route('staff.tourbooking.bookings.index'),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.net_earning',
                'accent' => 'primary',
            ],
            [
                'group' => 'Sales & Earnings',
                'section' => 'finance',
                'label' => 'Admin Commissions',
                'value' => currency($totalCommission),
                'route' => route('staff.tourbooking.bookings.index'),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.seller_earning',
                'accent' => 'info',
            ],
            [
                'group' => 'Sales & Earnings',
                'section' => 'bookings',
                'label' => 'Total Bookings',
                'value' => Booking::query()->count(),
                'route' => route('staff.tourbooking.bookings.index'),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sold',
                'accent' => 'primary',
            ],

            // Row 2: Booking Status
            [
                'group' => 'Booking Status',
                'section' => 'bookings',
                'label' => 'Confirmed Bookings',
                'value' => Booking::query()->where('booking_status', 'confirmed')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['status' => 'confirmed']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sold',
                'accent' => 'success',
            ],
            [
                'group' => 'Booking Status',
                'section' => 'bookings',
                'label' => 'Pending Bookings',
                'value' => Booking::query()->where('booking_status', 'pending')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['status' => 'pending']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sold',
                'accent' => 'warning',
            ],
            [
                'group' => 'Booking Status',
                'section' => 'bookings',
                'label' => 'Completed Bookings',
                'value' => Booking::query()->where('booking_status', 'completed')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['status' => 'completed']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sold',
                'accent' => 'info',
            ],
            [
                'group' => 'Booking Status',
                'section' => 'bookings',
                'label' => 'Cancelled Bookings',
                'value' => Booking::query()->where('booking_status', 'cancelled')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['status' => 'cancelled']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sold',
                'accent' => 'danger',
            ],

            // Row 3: Payments & Withdrawals
            [
                'group' => 'Payments & Withdrawals',
                'section' => 'finance',
                'label' => 'Pending Payments',
                'value' => Booking::query()->where('payment_status', 'pending')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['payment_status' => 'pending']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.net_earning',
                'accent' => 'warning',
            ],
            [
                'group' => 'Payments & Withdrawals',
                'section' => 'finance',
                'label' => 'Confirmed Payments',
                'value' => Booking::query()->where('payment_status', 'success')->count(),
                'route' => route('staff.tourbooking.bookings.index', ['payment_status' => 'success']),
                'route_name' => 'staff.tourbooking.bookings.index',
                'icon' => 'svg.total_sale',
                'accent' => 'success',
            ],
            [
                'group' => 'Payments & Withdrawals',
                'section' => 'finance',
                'label' => 'Total Withdrawals',
                'value' => SellerWithdraw::query()->count(),
                'route' => route('staff.withdraw-list.index'),
                'route_name' => 'staff.withdraw-list.index',
                'icon' => 'svg.seller_earning',
                'accent' => 'primary',
            ],
            [
                'group' => 'Payments & Withdrawals',
                'section' => 'finance',
                'label' => 'Pending Withdrawals',
                'value' => SellerWithdraw::query()->where('status', 'pending')->count(),
                'route' => route('staff.withdraw-list.index', ['status' => 'pending']),
                'route_name' => 'staff.withdraw-list.index',
                'icon' => 'svg.seller_earning',
                'accent' => 'warning',
            ],

            // Row 4: Support & Customers
            [
                'group' => 'Support',
                'section' => 'support',
                'label' => 'Support Tickets',
                'value' => SupportTicket::query()->count(),
                'route' => route('staff.support-tickets'),
                'route_name' => 'staff.support-tickets',
                'icon' => 'svg.total_sold',
                'accent' => 'info',
            ],
            [
                'group' => 'Support',
                'section' => 'support',
                'label' => 'Contact Messages',
                'value' => ContactMessage::query()->count(),
                'route' => route('staff.contact-message'),
                'route_name' => 'staff.contact-message',
                'icon' => 'svg.net_earning',
                'accent' => 'primary',
            ],
            [
                'group' => 'Support',
                'section' => 'support',
                'label' => 'Live Chat',
                'value' => LiveChat::query()->where('status', 'open')->count(),
                'route' => route('staff.live-chat.index'),
                'route_name' => 'staff.live-chat.index',
                'icon' => 'svg.net_earning',
                'accent' => 'info',
            ],
            [
                'group' => 'Support',
                'section' => 'users',
                'label' => 'Total Customers',
                'value' => User::query()->where('is_staff', '0')->where('is_seller', '0')->count(),
                'route' => 'javascript:void(0)',
                'route_name' => 'staff.dashboard',
                'icon' => 'svg.total_sale',
                'accent' => 'success',
            ],
        ], function (array $card) use ($user): bool {
            // Role-based visibility
            $isRoleAllowed = match ($card['section']) {
                'finance' => $user?->isStaffAccountant(),
                'bookings' => $user?->isStaffAccountant() || $user?->isBookingAgent(),
                'support' => $user?->isStaffAccountant() || $user?->isTravelAgent(),
                'booking_services', 'destinations', 'explores' => $user?->isStaffDataEntry() || $user?->isTravelAgent(),
                'products' => $user?->isStaffDataEntry() || $user?->isSalesAgent() || $user?->isStaffAccountant(),
                'users' => $user?->isStaffAccountant() || $user?->isTravelAgent(),
                default => false,
            };

            // Permission-based visibility (overrides or supplements role)
            $isPermissionAllowed = $user?->canSeeStaffSection($card['section']) ?? false;

            // Final check: Must have role/permission AND route access
            return ($isRoleAllowed || $isPermissionAllowed)
                && ($user?->canAccessStaffRoute($card['route_name']) ?? false);
        }));

        $serviceTypeLinks = ServiceType::query()
            ->with('translation')
            ->active()
            ->orderBy('ordering')
            ->take(6)
            ->get()
            ->map(static fn (ServiceType $serviceType): array => [
                'label' => $serviceType->localized_name,
                'route' => route('staff.tourbooking.services.by-type', ['type' => $serviceType->slug]),
            ])
            ->all();

        $bookingSummary = [
            'pending' => Booking::query()->where('booking_status', 'pending')->count(),
            'confirmed' => Booking::query()->where('booking_status', 'confirmed')->count(),
            'completed' => Booking::query()->where('booking_status', 'completed')->count(),
            'cancelled' => Booking::query()->where('booking_status', 'cancelled')->count(),
        ];

        $financialData = [
            'payments' => [
                'success' => Booking::query()->where('payment_status', 'success')->count(),
                'pending' => Booking::query()->where('payment_status', 'pending')->count(),
                'total' => Booking::query()->count(),
            ],
            'withdrawals' => [
                'total' => SellerWithdraw::query()->count(),
                'pending' => SellerWithdraw::query()->where('status', 'pending')->count(),
                'approved' => SellerWithdraw::query()->where('status', 'success')->count(),
                'rejected' => SellerWithdraw::query()->where('status', 'rejected')->count(),
            ],
            'revenue' => [
                'total_sales' => $totalIncome,
                'admin_commission' => $totalCommission,
                'net_earnings' => $netIncome,
                'agent_earnings' => $netIncome, // Based on netIncome calculation in this controller
            ],
            'actions' => array_filter([
                [
                    'label' => 'Manage Orders',
                    'route' => route('staff.order.index'),
                    'route_name' => 'staff.order.index',
                    'icon' => 'fas fa-shopping-cart',
                ],
                [
                    'label' => 'Manage Withdrawals',
                    'route' => route('staff.withdraw-list.index'),
                    'route_name' => 'staff.withdraw-list.index',
                    'icon' => 'fas fa-wallet',
                ],
                [
                    'label' => 'Support Tickets',
                    'route' => route('staff.support-tickets'),
                    'route_name' => 'staff.support-tickets',
                    'icon' => 'fas fa-ticket-alt',
                ],
                [
                    'label' => 'Contact Messages',
                    'route' => route('staff.contact-message'),
                    'route_name' => 'staff.contact-message',
                    'icon' => 'fas fa-envelope',
                ],
                [
                    'label' => 'Live Chat',
                    'route' => route('staff.live-chat.index'),
                    'route_name' => 'staff.live-chat.index',
                    'icon' => 'fas fa-comments',
                ],
            ], function($action) use ($user) {
                return $user?->canAccessStaffRoute($action['route_name']) ?? false;
            }),
        ];

        return view('staff.dashboard', [
            'user' => $user,
            'dashboardMode' => $dashboardMode,
            'showFinancialCards' => $showFinancialCards,
            'showOperationsCards' => $showOperationsCards,
            'showContentCards' => $showContentCards,
            'showAccountantCards' => $showAccountantCards,
            'totalIncome' => $totalIncome,
            'totalCommission' => $totalCommission,
            'netIncome' => $netIncome,
            'totalSold' => $totalSold,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($chartData),
            'latestBookings' => $latestBookings,
            'quickActions' => $quickActions,
            'dashboardCards' => $dashboardCards,
            'serviceTypeLinks' => $serviceTypeLinks,
            'bookingSummary' => $bookingSummary,
            'financialData' => $financialData,
        ]);
    }
}