@php
    use Illuminate\Support\Str;

    $authUser = Auth::guard('web')->user();
    $currentRoute = (string) request()->route()?->getName();
    $serviceTypes = \Modules\TourBooking\App\Models\ServiceType::query()
        ->with('translation')
        ->active()
        ->orderBy('ordering')
        ->get();

    $staffMenu = [
        [
            'title' => dashboard_label('Operations'),
            'items' => [
                [
                    'label' => dashboard_label('Dashboard'),
                    'route' => route('staff.dashboard'),
                    'icon' => 'M9.02 2.84L3.63 7.04C2.73 7.74 2 9.23 2 10.36V17.77C2 20.09 3.89 21.99 6.21 21.99H17.79C20.11 21.99 22 20.09 22 17.78V10.5C22 9.29 21.19 7.74 20.2 7.05L14.02 2.72C12.62 1.74 10.37 1.79 9.02 2.84Z M12 17.99V14.99',
                    'active' => ['staff.dashboard'],
                ],
                [
                    'label' => dashboard_label('Booking Services'),
                    'section' => 'booking_services',
                    'icon' => 'M2 21C2.5 20.0909 4.4 18.2727 8 18.2727C11.6 18.2727 13.5 16.0909 14 15M8 8V5C8 3.89543 8.89543 3 10 3H20C21.1046 3 22 3.89543 22 5V13C22 14.1046 21.1046 15 20 15H16.7397M12 7H18M10 13C10 14.1046 9.10457 15 8 15C6.89543 15 6 14.1046 6 13C6 11.8954 6.89543 11 8 11C9.10457 11 10 11.8954 10 13Z',
                    'active' => ['staff.tourbooking.services.*', 'staff.tourbooking.service-types.*', 'staff.tourbooking.amenities.*'],
                    'children' => [
                        ['label' => dashboard_label('Booking Services'), 'route' => route('staff.tourbooking.services.index'), 'active' => ['staff.tourbooking.services.index']],
                        ['label' => dashboard_label('Booking Service Types'), 'route' => route('staff.tourbooking.service-types.index'), 'active' => ['staff.tourbooking.service-types.*']],
                        ['label' => dashboard_label('Amenities'), 'route' => route('staff.tourbooking.amenities.index'), 'active' => ['staff.tourbooking.amenities.*']],
                    ],
                ],
                [
                    'label' => dashboard_label('Destinations'),
                    'section' => 'destinations',
                    'icon' => 'M12 21S18 16.65 18 11A6 6 0 1 0 6 11C6 16.65 12 21 12 21ZM12 11.5A1.5 1.5 0 1 1 12 8.5A1.5 1.5 0 0 1 12 11.5Z',
                    'active' => ['staff.tourbooking.destinations.*'],
                    'children' => [
                        ['label' => dashboard_label('Destinations'), 'route' => route('staff.tourbooking.destinations.index'), 'active' => ['staff.tourbooking.destinations.index', 'staff.tourbooking.destinations.show']],
                        ['label' => dashboard_label('Create Destination'), 'route' => route('staff.tourbooking.destinations.create'), 'active' => ['staff.tourbooking.destinations.create']],
                    ],
                ],
                [
                    'label' => dashboard_label('Special Bookings'),
                    'section' => 'special_bookings',
                    'icon' => 'M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z',
                    'active' => ['staff.special-booking.*'],
                    'children' => [
                        ['label' => dashboard_label('SPA Services'), 'route' => route('staff.special-booking.spa-services.index'), 'active' => ['staff.special-booking.spa-services.*'], 'route_name' => 'staff.special-booking.spa-services.index'],
                        ['label' => dashboard_label('Airlines'), 'route' => route('staff.special-booking.airlines.index'), 'active' => ['staff.special-booking.airlines.*'], 'route_name' => 'staff.special-booking.airlines.index'],
                        ['label' => dashboard_label('Transfer Vehicles'), 'route' => route('staff.special-booking.transfer-vehicles.index'), 'active' => ['staff.special-booking.transfer-vehicles.*'], 'route_name' => 'staff.special-booking.transfer-vehicles.index'],
                        ['label' => dashboard_label('Nile Cruise Routes'), 'route' => route('staff.special-booking.nile-cruise-routes.index'), 'active' => ['staff.special-booking.nile-cruise-routes.*'], 'route_name' => 'staff.special-booking.nile-cruise-routes.index'],
                        ['label' => dashboard_label('Nile Cruise Cabins'), 'route' => route('staff.special-booking.nile-cruise-cabins.index'), 'active' => ['staff.special-booking.nile-cruise-cabins.*'], 'route_name' => 'staff.special-booking.nile-cruise-cabins.index'],
                        ['label' => dashboard_label('Booking Features'), 'route' => route('staff.special-booking.booking-features.index'), 'active' => ['staff.special-booking.booking-features.*'], 'route_name' => 'staff.special-booking.booking-features.index'],
                        ['label' => dashboard_label('SPA Bookings'), 'route' => route('staff.special-booking.spa-bookings.index'), 'active' => ['staff.special-booking.spa-bookings.*'], 'route_name' => 'staff.special-booking.spa-bookings.index'],
                        ['label' => dashboard_label('Flight Requests'), 'route' => route('staff.special-booking.flight-requests.index'), 'active' => ['staff.special-booking.flight-requests.*'], 'route_name' => 'staff.special-booking.flight-requests.index'],
                        ['label' => dashboard_label('Transfer Requests'), 'route' => route('staff.special-booking.transfer-requests.index'), 'active' => ['staff.special-booking.transfer-requests.*'], 'route_name' => 'staff.special-booking.transfer-requests.index'],
                        ['label' => dashboard_label('Nile Cruise Requests'), 'route' => route('staff.special-booking.nile-cruise-requests.index'), 'active' => ['staff.special-booking.nile-cruise-requests.*'], 'route_name' => 'staff.special-booking.nile-cruise-requests.index'],
                    ],
                ],
            ],
        ],
        [
            'title' => dashboard_label('Commerce & Content'),
            'items' => [
                [
                    'label' => dashboard_label('Manage Product'),
                    'section' => 'products',
                    'icon' => 'M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C20.9033 11.0876 20.4982 11.6081 20.3919 12.2134L19.7993 15.5878C19.5386 17.0725 19.4495 19.1943 18.1484 20.2402C17.1938 21 15.8184 21 13.0675 21H10.9325C8.18162 21 6.8062 21 5.8516 20.2402C4.55052 19.1942 4.46138 17.0725 4.20066 15.5878L3.60807 12.2134C3.50177 11.6081 3.09673 11.0876 2.51841 10.8132C2.37896 10.747 2.27952 10.6235 2.24894 10.4784C2.07874 9.67075 1.6264 8.5469 2.63812 8.10084C2.86684 8 3.17922 8 3.80397 8H7.5M14 12H10M6.5 11L10 3M15 3L17.5 8',
                    'active' => ['staff.product.*', 'staff.category.*', 'staff.brand.*'],
                    'children' => [
                        ['label' => dashboard_label('Create Product'), 'route' => route('staff.product.create'), 'active' => ['staff.product.create']],
                        ['label' => dashboard_label('Product List'), 'route' => route('staff.product.index'), 'active' => ['staff.product.index', 'staff.product.edit', 'staff.product.edit-by-id', 'staff.product.gallery']],
                        ['label' => dashboard_label('Category List'), 'route' => route('staff.category.index'), 'active' => ['staff.category.*']],
                        ['label' => dashboard_label('Brand List'), 'route' => route('staff.brand.index'), 'active' => ['staff.brand.*']],
                    ],
                ],
                [
                    'label' => dashboard_label('CMS & Explores'),
                    'section' => 'explores',
                    'icon' => 'M17.5 8V5C17.5 3.89543 16.6046 3 15.5 3H4.5C3.39543 3 2.5 3.89543 2.5 5V19C2.5 20.1046 3.39543 21 4.5 21H19.5M6.5 8H13.5M6.5 12H13.5M6.5 16H9.5',
                    'active' => ['staff.blog.*', 'staff.blog-category.*', 'staff.comment-list', 'staff.show-comment', 'staff.blog-comment-status'],
                    'children' => [
                        ['label' => dashboard_label('Create Category'), 'route' => route('staff.blog-category.create'), 'active' => ['staff.blog-category.create']],
                        ['label' => dashboard_label('Category List'), 'route' => route('staff.blog-category.index'), 'active' => ['staff.blog-category.index', 'staff.blog-category.edit']],
                        ['label' => dashboard_label('Create Explore'), 'route' => route('staff.blog.create'), 'active' => ['staff.blog.create']],
                        ['label' => dashboard_label('Explore List'), 'route' => route('staff.blog.index'), 'active' => ['staff.blog.index', 'staff.blog.edit']],
                        ['label' => dashboard_label('Comment List'), 'route' => route('staff.comment-list'), 'active' => ['staff.comment-list', 'staff.show-comment', 'staff.blog-comment-status']],
                    ],
                ],
                [
                    'label' => dashboard_label('Pages & Content'),
                    'section' => 'pages',
                    'icon' => 'M21 10V4.5C21 3.39543 20.1046 2.5 19 2.5H4C2.89543 2.5 2 3.39543 2 4.5V17.5C2 18.6046 2.89543 19.5 4 19.5H10',
                    'active' => ['staff.contact-us', 'staff.terms-conditions', 'staff.privacy-policy', 'staff.faq.*', 'staff.custom-page.*', 'staff.front-end.*', 'staff.footer', 'staff.testimonial.*', 'staff.partner.*'],
                    'children' => [
                        ['label' => dashboard_label('Frontend Section'), 'route' => route('staff.front-end.frontend-section'), 'active' => ['staff.front-end.*']],
                        ['label' => dashboard_label('Contact Us'), 'route' => route('staff.contact-us', ['lang_code' => admin_lang()]), 'active' => ['staff.contact-us']],
                        ['label' => dashboard_label('Terms and Conditions'), 'route' => route('staff.terms-conditions', ['lang_code' => admin_lang()]), 'active' => ['staff.terms-conditions']],
                        ['label' => dashboard_label('Privacy Policy'), 'route' => route('staff.privacy-policy', ['lang_code' => admin_lang()]), 'active' => ['staff.privacy-policy']],
                        ['label' => dashboard_label('FAQ'), 'route' => route('staff.faq.index'), 'active' => ['staff.faq.*']],
                        ['label' => dashboard_label('Custom Page'), 'route' => route('staff.custom-page.index'), 'active' => ['staff.custom-page.*']],
                        ['label' => dashboard_label('Footer Info'), 'route' => route('staff.footer', ['lang_code' => admin_lang()]), 'active' => ['staff.footer']],
                        ['label' => dashboard_label('Testimonial'), 'route' => route('staff.testimonial.index'), 'active' => ['staff.testimonial.*']],
                        ['label' => dashboard_label('Partner'), 'route' => route('staff.partner.index'), 'active' => ['staff.partner.*']],
                    ],
                ],
            ],
        ],
        [
            'title' => dashboard_label('Orders & Financials'),
            'items' => [
                [
                    'label' => dashboard_label('Manage Order'),
                    'section' => 'orders',
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z',
                    'active' => ['staff.orders', 'staff.order', 'staff.active-orders', 'staff.reject-orders', 'staff.delivered-orders', 'staff.complete-orders', 'staff.pending-payment-orders'],
                    'children' => [
                        ['label' => dashboard_label('All Orders'), 'route' => route('staff.orders'), 'active' => ['staff.orders']],
                        ['label' => dashboard_label('Active Orders'), 'route' => route('staff.active-orders'), 'active' => ['staff.active-orders']],
                        ['label' => dashboard_label('Pending Payments'), 'route' => route('staff.pending-payment-orders'), 'active' => ['staff.pending-payment-orders']],
                    ],
                ],
                [
                    'label' => dashboard_label('Manage Withdraw'),
                    'section' => 'withdraw',
                    'icon' => 'M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm7-5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z',
                    'active' => ['staff.withdraw-list.*', 'staff.withdraw-methods.*'],
                    'children' => [
                        ['label' => dashboard_label('Withdrawal List'), 'route' => route('staff.withdraw-list.index'), 'active' => ['staff.withdraw-list.*']],
                        ['label' => dashboard_label('Withdrawal Methods'), 'route' => route('staff.withdraw-methods.index'), 'active' => ['staff.withdraw-methods.*']],
                    ],
                ],
            ],
        ],
        [
            'title' => dashboard_label('Support & Communication'),
            'items' => [
                [
                    'label' => dashboard_label('Support Ticket'),
                    'section' => 'support',
                    'icon' => 'M18 8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V8zm-3 5h-4m4 4H9m11-8a3 3 0 0 1-3 3',
                    'active' => ['staff.support-tickets', 'staff.support-ticket', 'staff.contact-message', 'staff.show-message', 'staff.live-chat.*'],
                    'children' => [
                        ['label' => dashboard_label('Support Tickets'), 'route' => route('staff.support-tickets'), 'active' => ['staff.support-tickets', 'staff.support-ticket']],
                        ['label' => dashboard_label('Contact Messages'), 'route' => route('staff.contact-message'), 'active' => ['staff.contact-message', 'staff.show-message']],
                        ['label' => dashboard_label('Live Chat'), 'route' => route('staff.live-chat.index'), 'active' => ['staff.live-chat.*']],
                    ],
                ],
            ],
        ],
        [
            'title' => dashboard_label('Settings'),
            'items' => [
                [
                    'label' => dashboard_label('Setting & Configuration'),
                    'section' => 'settings',
                    'icon' => 'M12 8.5A3.5 3.5 0 1 0 12 15.5a3.5 3.5 0 0 0 0-7zm8.5 3a6.8 6.8 0 0 0-.1-1l2.1-1.6-2-3.4-2.6 1a7 7 0 0 0-1.7-1l-.4-2.8H9.7l-.4 2.8a7 7 0 0 0-1.7 1l-2.6-1-2 3.4L4 10.5a6.8 6.8 0 0 0-.1 1c0 .3 0 .7.1 1L1.8 14.1l2 3.4 2.6-1a7 7 0 0 0 1.7 1l.4 2.8h4.6l.4-2.8a7 7 0 0 0 1.7-1l2.6 1 2-3.4-2.1-1.6c.1-.3.1-.7.1-1z',
                    'active' => ['staff.multi-currency.*', 'staff.language.*', 'staff.theme-language', 'staff.update-theme-language', 'staff.seo-setting', 'staff.update-seo-setting'],
                    'children' => [
                        ['label' => dashboard_label('Multi Currency'), 'route' => route('staff.multi-currency.index'), 'active' => ['staff.multi-currency.*']],
                        ['label' => dashboard_label('Language'), 'route' => route('staff.language.index'), 'active' => ['staff.language.*']],
                        ['label' => dashboard_label('Theme language'), 'route' => route('staff.theme-language', ['lang_code' => admin_lang()]), 'active' => ['staff.theme-language', 'staff.update-theme-language']],
                        ['label' => dashboard_label('SEO Setup'), 'route' => route('staff.seo-setting'), 'active' => ['staff.seo-setting', 'staff.update-seo-setting']],
                    ],
                ],
            ],
        ],
    ];

    foreach ($staffMenu as &$menuGroup) {
        foreach ($menuGroup['items'] as &$menuItem) {
            if (($menuItem['section'] ?? null) === 'booking_services') {
                foreach ($serviceTypes as $serviceType) {
                    $menuItem['children'][] = [
                        'label' => $serviceType->localized_name,
                        'route' => route('staff.tourbooking.services.by-type', ['type' => $serviceType->slug]),
                        'active' => ['staff.tourbooking.services.by-type'],
                        'query' => $serviceType->slug,
                    ];
                }
            }
        }
    }
    unset($menuGroup, $menuItem);

    $matchesPattern = static function (array $patterns, string $routeName): bool {
        foreach ($patterns as $pattern) {
            if (Str::is($pattern, $routeName)) {
                return true;
            }
        }

        return false;
    };
@endphp

<style>
    /* Ensure the sidebar matches the Admin Dashboard white style exactly */
    .admin-menu {
        height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        background: #ffffff !important;
        border-right: 1px solid #e8edff !important;
        overflow: hidden !important;
    }
    
    .admin-menu__one {
        flex: 1 !important;
        overflow-y: auto !important;
        /* Hide scrollbar by default as requested */
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
        padding-bottom: 100px !important;
        margin-top: 0 !important;
    }

    .admin-menu__one::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }

    /* Fixed logo area matching Admin Dashboard */
    .logo {
        flex-shrink: 0 !important;
        z-index: 10;
        background: #ffffff !important;
        border-bottom: 1px solid #e8edff !important;
        padding: 30px 20px !important;
        min-height: 100px;
    }

    /* Match Admin Dashboard section title style from dev.css */
    .admin-menu__title {
        color: #404054 !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        border-bottom: 1px solid #edf2f7 !important;
        margin-top: 25px !important;
        margin-bottom: 10px !important;
        padding-left: 20px !important;
        padding-bottom: 5px !important;
        opacity: 1 !important;
    }
    
    /* Ensure icons and text use standard theme colors */
    .menu-bar li a {
        color: #14212b !important;
        transition: all 0.3s ease;
    }

    .menu-bar li a .crancy-menu-icon {
        color: #14212b !important;
    }
    
    .menu-bar li.active > a,
    .menu-bar li.active > a .menu-bar__name,
    .menu-bar li:not(.collapsed) > a .crancy-menu-icon,
    .menu-bar li:hover > a,
    .menu-bar li:hover > a .menu-bar__name {
        color: var(--theme-color, #c62828) !important;
    }

    .menu-bar li.active > a .crancy-menu-icon,
    .menu-bar li:hover > a .crancy-menu-icon {
        color: var(--theme-color, #c62828) !important;
    }
    
    .menu-bar__one {
        padding-bottom: 20px;
    }
</style>

<div class="admin-menu__one crancy-sidebar-padding mg-top-20">
    <div class="menu-bar">
        <ul id="CrancyMenu" class="menu-bar__one crancy-dashboard-menu">
            @foreach ($staffMenu as $menuGroup)
                @php
                    $visibleItems = array_filter($menuGroup['items'], function ($item) use ($authUser) {
                        return empty($item['section']) || $authUser?->canSeeStaffSection($item['section']);
                    });
                @endphp

                @if (! empty($visibleItems))
                    <h4 class="admin-menu__title">{{ $menuGroup['title'] }}</h4>

                    @foreach ($visibleItems as $item)
                        @php
                            $hasChildren = ! empty($item['children']);
                            $isOpen = $matchesPattern($item['active'] ?? [], $currentRoute);

                            if ($hasChildren) {
                                foreach ($item['children'] as $child) {
                                    if ($matchesPattern($child['active'] ?? [], $currentRoute) && (! isset($child['query']) || request('type') === $child['query'])) {
                                        $isOpen = true;
                                    }
                                }
                            }

                            $menuId = 'staff-menu-' . Str::slug($item['label']);
                        @endphp

                        <li class="{{ $isOpen ? 'active' : '' }}">
                            @if ($hasChildren)
                                <a href="#{{ $menuId }}" class="collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $menuId }}" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                                    <span class="menu-bar__text">
                                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="{{ $item['icon'] }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="menu-bar__name">{{ $item['label'] }}</span>
                                    </span>
                                    <span class="crancy__toggle"></span>
                                </a>

                                <div class="collapse crancy__dropdown {{ $isOpen ? 'show' : '' }}" id="{{ $menuId }}" data-bs-parent="#CrancyMenu">
                                    <ul class="menu-bar__one-dropdown">
                                        @foreach ($item['children'] as $child)
                                            @if (isset($child['route_name']) && ! $authUser?->canAccessStaffRoute($child['route_name']))
                                                @continue
                                            @endif
                                            @php
                                                $childActive = $matchesPattern($child['active'] ?? [], $currentRoute)
                                                    && (! isset($child['query']) || request('type') === $child['query']);
                                            @endphp
                                            <li class="{{ $childActive ? 'active' : '' }}">
                                                <a href="{{ $child['route'] }}">
                                                    <span class="menu-bar__text">
                                                        <span class="menu-bar__name">{{ $child['label'] }}</span>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a class="collapsed" href="{{ $item['route'] }}">
                                    <span class="menu-bar__text">
                                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="{{ $item['icon'] }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="menu-bar__name">{{ $item['label'] }}</span>
                                    </span>
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <h4 class="admin-menu__title">{{ dashboard_label('Account') }}</h4>

            <li class="{{ Route::is('user.edit-profile') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('user.edit-profile') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="12" cy="17.5" rx="7" ry="3.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ dashboard_label('Edit Profile') }}</span>
                    </span>
                </a>
            </li>

            <li class="{{ Route::is('user.change-password') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('user.change-password') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 7H5M13 7C15.2091 7 17 8.79086 17 11V17C17 19.2091 15.2091 21 13 21H5C2.79086 21 1 19.2091 1 17V11C1 8.79086 2.79086 7 5 7M13 7V5C13 2.79086 11.2091 1 9 1C6.79086 1 5 2.79086 5 5V7M9 15V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ dashboard_label('Change Password') }}</span>
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('user.logout') }}" class="collapsed">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 14L21.2929 12.7071C21.6834 12.3166 21.6834 11.6834 21.2929 11.2929L20 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.5 4H6.5C5.39543 4 4.5 4.89543 4.5 6V18C4.5 19.1046 5.39543 20 6.5 20H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ dashboard_label('Logout') }}</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
