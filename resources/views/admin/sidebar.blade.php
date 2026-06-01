<!-- Main Menu -->
<div class="admin-menu__one crancy-sidebar-padding mg-top-20">

    <!-- Nav Menu -->
    <div class="menu-bar">
        <ul id="CrancyMenu" class="menu-bar__one crancy-dashboard-menu">
            @php($currentAdmin = Auth::guard('admin')->user())

            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.dashboard') }}"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">

                            <svg class="crancy-svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.02 2.84L3.63 7.04C2.73 7.74 2 9.23 2 10.36V17.77C2 20.09 3.89 21.99 6.21 21.99H17.79C20.11 21.99 22 20.09 22 17.78V10.5C22 9.29 21.19 7.74 20.2 7.05L14.02 2.72C12.62 1.74 10.37 1.79 9.02 2.84Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 17.99V14.99" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Dashboard') }}</span></span></a>
            </li>

            @if (! $currentAdmin?->isStaff() || $currentAdmin?->canSeeStaffSection('special_bookings'))
            <li class="{{ Route::is('admin.special-booking.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__special_bookings"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Special Bookings') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <div class="collapse crancy__dropdown {{ Route::is('admin.special-booking.*') ? 'show' : '' }}"
                    id="menu-item__special_bookings" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.spa-services.index') || $currentAdmin?->canAccessAdminRoute('admin.special-booking.spa-bookings.index'))
                        <li class="{{ Route::is('admin.special-booking.spa-services.*') || Route::is('admin.special-booking.spa-bookings.*') ? 'active' : '' }}">
                            <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__special_bookings_spa">
                                <span class="menu-bar__text">
                                    <span class="menu-bar__name">{{ __('translate.SPA') }}</span>
                                </span>
                                <span class="crancy__toggle"></span>
                            </a>
                            <div class="collapse crancy__dropdown {{ Route::is('admin.special-booking.spa-services.*') || Route::is('admin.special-booking.spa-bookings.*') ? 'show' : '' }}" id="menu-item__special_bookings_spa">
                                <ul class="menu-bar__one-dropdown">
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.spa-services.index'))
                                    <li><a href="{{ route('admin.special-booking.spa-services.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.SPA Services') }}</span></span></a></li>
                                    @endif
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.spa-bookings.index'))
                                    <li><a href="{{ route('admin.special-booking.spa-bookings.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.SPA Bookings') }}</span></span></a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.airlines.index') || $currentAdmin?->canAccessAdminRoute('admin.special-booking.flight-requests.index'))
                        <li class="{{ Route::is('admin.special-booking.airlines.*') || Route::is('admin.special-booking.flight-requests.*') ? 'active' : '' }}">
                            <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__special_bookings_flights">
                                <span class="menu-bar__text">
                                    <span class="menu-bar__name">{{ __('translate.Flights') }}</span>
                                </span>
                                <span class="crancy__toggle"></span>
                            </a>
                            <div class="collapse crancy__dropdown {{ Route::is('admin.special-booking.airlines.*') || Route::is('admin.special-booking.flight-requests.*') ? 'show' : '' }}" id="menu-item__special_bookings_flights">
                                <ul class="menu-bar__one-dropdown">
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.airlines.index'))
                                    <li><a href="{{ route('admin.special-booking.airlines.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Airlines') }}</span></span></a></li>
                                    @endif
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.flight-requests.index'))
                                    <li><a href="{{ route('admin.special-booking.flight-requests.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Flight Requests') }}</span></span></a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.transfer-vehicles.index') || $currentAdmin?->canAccessAdminRoute('admin.special-booking.transfer-requests.index'))
                        <li class="{{ Route::is('admin.special-booking.transfer-vehicles.*') || Route::is('admin.special-booking.transfer-requests.*') ? 'active' : '' }}">
                            <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__special_bookings_transfers">
                                <span class="menu-bar__text">
                                    <span class="menu-bar__name">{{ __('translate.Transfers') }}</span>
                                </span>
                                <span class="crancy__toggle"></span>
                            </a>
                            <div class="collapse crancy__dropdown {{ Route::is('admin.special-booking.transfer-vehicles.*') || Route::is('admin.special-booking.transfer-requests.*') ? 'show' : '' }}" id="menu-item__special_bookings_transfers">
                                <ul class="menu-bar__one-dropdown">
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.transfer-vehicles.index'))
                                    <li><a href="{{ route('admin.special-booking.transfer-vehicles.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Transfer Vehicles') }}</span></span></a></li>
                                    @endif
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.transfer-requests.index'))
                                    <li><a href="{{ route('admin.special-booking.transfer-requests.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Transfer Requests') }}</span></span></a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.nile-cruise-routes.index') || $currentAdmin?->canAccessAdminRoute('admin.special-booking.nile-cruise-requests.index'))
                        <li class="{{ Route::is('admin.special-booking.nile-cruise-routes.*') || Route::is('admin.special-booking.nile-cruise-cabins.*') || Route::is('admin.special-booking.nile-cruise-requests.*') ? 'active' : '' }}">
                            <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__special_bookings_nile">
                                <span class="menu-bar__text">
                                    <span class="menu-bar__name">{{ __('translate.Nile Cruises') }}</span>
                                </span>
                                <span class="crancy__toggle"></span>
                            </a>
                            <div class="collapse crancy__dropdown {{ Route::is('admin.special-booking.nile-cruise-routes.*') || Route::is('admin.special-booking.nile-cruise-cabins.*') || Route::is('admin.special-booking.nile-cruise-requests.*') ? 'show' : '' }}" id="menu-item__special_bookings_nile">
                                <ul class="menu-bar__one-dropdown">
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.nile-cruise-routes.index'))
                                    <li><a href="{{ route('admin.special-booking.nile-cruise-routes.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Nile Cruise Routes') }}</span></span></a></li>
                                    @endif
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.nile-cruise-cabins.index'))
                                    <li><a href="{{ route('admin.special-booking.nile-cruise-cabins.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Nile Cruise Cabins') }}</span></span></a></li>
                                    @endif
                                    @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.nile-cruise-requests.index'))
                                    <li><a href="{{ route('admin.special-booking.nile-cruise-requests.index') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Nile Cruise Requests') }}</span></span></a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.special-booking.booking-features.index'))
                        <li class="{{ Route::is('admin.special-booking.booking-features.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.special-booking.booking-features.index') }}">
                                <span class="menu-bar__text">
                                    <span class="menu-bar__name">{{ __('translate.Settings / Content') }}</span>
                                </span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @include('tourbooking::admin.sidebar')

            @if (! $currentAdmin?->isStaff() || $currentAdmin?->canSeeStaffSection('withdraw'))
            <li
                class="{{ Route::is('admin.withdraw-methods.*') || Route::is('admin.withdraw-list.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__withdraw_list"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 11C21.8626 10.7762 22 9.98695 22 9.04763V5.01588C22 3.90254 21.1046 3 20 3H4C2.89543 3 2 3.90254 2 5.01588V9.04763C2 9.98695 2.13739 10.7762 3 11"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12 21C15.866 21 19 17.866 19 14C19 10.134 15.866 7 12 7C8.13401 7 5 10.134 5 14C5 17.866 8.13401 21 12 21Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path
                                    d="M12 11C10.8954 11 10 11.6716 10 12.5C10 13.3284 10.8954 14 12 14C13.1046 14 14 14.6716 14 15.5C14 16.3284 13.1046 17 12 17M12 11C12.8708 11 13.6116 11.4174 13.8862 12M12 11V10M12 17C11.1292 17 10.3884 16.5826 10.1138 16M12 17V18"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5 7H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>

                        <span class="menu-bar__name">{{ __('translate.Manage Withdraw') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.withdraw-methods.*') || Route::is('admin.withdraw-list.*') ? 'show' : '' }}"
                    id="menu-item__withdraw_list" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.withdraw-methods.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Withdraw Method') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.withdraw-list.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Withdraw List') }}</span></span></a>
                        </li>

                    </ul>
                </div>
            </li>
            @endif

            <li class="{{ Route::is('admin.contact-message') || Route::is('admin.show-message') ? 'active' : '' }}"><a
                    class="collapsed" href="{{ route('admin.contact-message') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 10H16M8 14H12M11 3H13C17.9706 3 22 7.02944 22 12C22 16.9706 17.9706 21 13 21H6C3.79086 21 2 19.2091 2 17V12C2 7.02944 6.02944 3 11 3Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>


                        </span>
                        <span class="menu-bar__name">{{ __('translate.Contact Message') }}</span>
                    </span>

                </a>
            </li>


            <li class="{{ Route::is('admin.support-tickets') || Route::is('admin.support-ticket') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.support-tickets') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="18" height="22" viewBox="0 0 18 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 7H5M13 7C15.2091 7 17 8.79086 17 11V17C17 19.2091 15.2091 21 13 21H5C2.79086 21 1 19.2091 1 17V11C1 8.79086 2.79086 7 5 7M13 7V5C13 2.79086 11.2091 1 9 1C6.79086 1 5 2.79086 5 5V7M9 15V13"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Support Ticket') }}</span>
                    </span>

                </a>
            </li>

            <li class="{{ Route::is('admin.live-chat.*') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.live-chat.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                    stroke="currentColor"/>
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Live Chat') }}</span>
                    </span>
                </a>
            </li>

            @if (! $currentAdmin?->isStaff() || $currentAdmin?->canSeeStaffSection('product-review'))
            <h4 class="admin-menu__title pt-2">{{ __('translate.Product & Review') }}</h4>
            <li
                class="{{ Route::is('admin.orders') || Route::is('admin.order') || Route::is('admin.active-orders') || Route::is('admin.reject-orders') || Route::is('admin.delivered-orders') || Route::is('admin.complete-orders') || Route::is('admin.pending-payment-orders') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__order"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C21.1491 10.971 20.8738 11.2102 20.6797 11.5M7.5 8H3.80397C3.17922 8 2.86684 8 2.63812 8.10084C1.6264 8.5469 2.07874 9.67075 2.24894 10.4784C2.27952 10.6235 2.37896 10.747 2.51841 10.8132C3.09673 11.0876 3.50177 11.6081 3.60807 12.2134L4.20066 15.5878C4.46138 17.0725 4.55052 19.1942 5.8516 20.2402C6.8062 21 8.18162 21 10.9325 21H13.0675C13.2156 21 12.5 21.0001 13 21"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" />
                                <g clip-path="url(#clip0_8302_44)">
                                    <path d="M14.8333 14.5H19.8333" stroke="currentcolor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.8333 17H21.5" stroke="currentcolor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.8333 19.5H19.2778" stroke="currentcolor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <path d="M6.5 11L10 3M15 3L17.5 8" stroke="currentcolor" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <defs>
                                    <clipPath id="clip0_8302_44">
                                        <rect width="8.33333" height="8.33333" fill="white"
                                            transform="translate(14 12.8333)" />
                                    </clipPath>
                                </defs>
                            </svg>



                        </span>

                        <span class="menu-bar__name">{{ __('translate.Manage Order') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.orders') || Route::is('admin.order') || Route::is('admin.active-orders') || Route::is('admin.reject-orders') || Route::is('admin.delivered-orders') || Route::is('admin.complete-orders') || Route::is('admin.pending-payment-orders') ? 'show' : '' }}"
                    id="menu-item__order" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">


                        <li><a href="{{ route('admin.orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.All Orders') }}</span></span></a></li>

                        <li><a href="{{ route('admin.active-orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Active Orders') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.reject-orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Rejected Orders') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.delivered-orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Delivered Orders') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.complete-orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Complete Orders') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.pending-payment-orders') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Pending Payment Order') }}</span></span></a>
                        </li>

                    </ul>
                </div>
            </li>



            <li
                class="{{ Route::is('admin.product.index') || Route::is('admin.product.create') || Route::is('admin.product.edit') || Route::is('admin.brand.*') || Route::is('admin.category.*') || Route::is('admin.sub-category.*') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__ecommerce"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.5 8H20.196C20.8208 8 21.1332 8 21.3619 8.10084C22.3736 8.5469 21.9213 9.67075 21.7511 10.4784C21.7205 10.6235 21.621 10.747 21.4816 10.8132C20.9033 11.0876 20.4982 11.6081 20.3919 12.2134L19.7993 15.5878C19.5386 17.0725 19.4495 19.1943 18.1484 20.2402C17.1938 21 15.8184 21 13.0675 21H10.9325C8.18162 21 6.8062 21 5.8516 20.2402C4.55052 19.1942 4.46138 17.0725 4.20066 15.5878L3.60807 12.2134C3.50177 11.6081 3.09673 11.0876 2.51841 10.8132C2.37896 10.747 2.27952 10.6235 2.24894 10.4784C2.07874 9.67075 1.6264 8.5469 2.63812 8.10084C2.86684 8 3.17922 8 3.80397 8H7.5"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M14 12H10" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.5 11L10 3M15 3L17.5 8" stroke="currentcolor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                        </span>

                        <span class="menu-bar__name">{{ __('translate.Manage Product') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <div class="collapse crancy__dropdown {{ Route::is('admin.product.index') || Route::is('admin.product.create') || Route::is('admin.product.edit') || Route::is('admin.brand.*') || Route::is('admin.category.*') || Route::is('admin.sub-category.*') ? 'show' : '' }}"
                    id="menu-item__ecommerce" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.product.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Product') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.product.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Product List') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.category.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Category List') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.brand.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Brand List') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            <li class="{{ Route::is('admin.product.review.list') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.product.review.list') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.5 22H6.59087C5.04549 22 3.81631 21.248 2.71266 20.1966C0.453366 18.0441 4.1628 16.324 5.57757 15.4816C7.827 14.1422 10.4865 13.7109 13 14.1878"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M15.5 6.5C15.5 8.98528 13.4853 11 11 11C8.51472 11 6.5 8.98528 6.5 6.5C6.5 4.01472 8.51472 2 11 2C13.4853 2 15.5 4.01472 15.5 6.5Z"
                                    stroke="currentcolor" stroke-width="1.5" />
                                <path
                                    d="M18.6911 14.5777L19.395 15.9972C19.491 16.1947 19.7469 16.3843 19.9629 16.4206L21.2388 16.6343C22.0547 16.7714 22.2467 17.3682 21.6587 17.957L20.6668 18.9571C20.4989 19.1265 20.4069 19.4531 20.4589 19.687L20.7428 20.925C20.9668 21.9049 20.4509 22.284 19.591 21.7718L18.3951 21.0581C18.1791 20.929 17.8232 20.929 17.6032 21.0581L16.4073 21.7718C15.5514 22.284 15.0315 21.9009 15.2554 20.925L15.5394 19.687C15.5914 19.4531 15.4994 19.1265 15.3314 18.9571L14.3395 17.957C13.7556 17.3682 13.9436 16.7714 14.7595 16.6343L16.0353 16.4206C16.2473 16.3843 16.5033 16.1947 16.5993 15.9972L17.3032 14.5777C17.6872 13.8074 18.3111 13.8074 18.6911 14.5777Z"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Review List') }}</span>
                    </span>
                </a>
            </li>

            <li class="{{ Route::is('admin.shipping-method.index') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.shipping-method.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.5 17.5C19.5 18.8807 18.3807 20 17 20C15.6193 20 14.5 18.8807 14.5 17.5C14.5 16.1193 15.6193 15 17 15C18.3807 15 19.5 16.1193 19.5 17.5Z"
                                    stroke="currentcolor" stroke-width="1.5" />
                                <path
                                    d="M9.5 17.5C9.5 18.8807 8.38071 20 7 20C5.61929 20 4.5 18.8807 4.5 17.5C4.5 16.1193 5.61929 15 7 15C8.38071 15 9.5 16.1193 9.5 17.5Z"
                                    stroke="currentcolor" stroke-width="1.5" />
                                <path
                                    d="M14.5 17.5H9.5M15 15.5V7C15 5.58579 15 4.87868 14.5607 4.43934C14.1213 4 13.4142 4 12 4H5C3.58579 4 2.87868 4 2.43934 4.43934C2 4.87868 2 5.58579 2 7V15C2 15.9346 2 16.4019 2.20096 16.75C2.33261 16.978 2.52197 17.1674 2.75 17.299C3.09808 17.5 3.56538 17.5 4.5 17.5M15.5 6.5H17.3014C18.1311 6.5 18.5459 6.5 18.8898 6.6947C19.2336 6.8894 19.4471 7.2451 19.8739 7.95651L21.5725 10.7875C21.7849 11.1415 21.8911 11.3186 21.9456 11.5151C22 11.7116 22 11.918 22 12.331V15C22 15.9346 22 16.4019 21.799 16.75C21.6674 16.978 21.478 17.1674 21.25 17.299C20.9019 17.5 20.4346 17.5 19.5 17.5"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Shipping') }}</span>
                    </span>
                </a>
            </li>
            @endif

            <h4 class="admin-menu__title pt-2">{{ __('translate.Team & Users') }}</h4>

            @if (! $currentAdmin?->isStaff() || $currentAdmin?->canSeeStaffSection('cms'))
            <li class="{{ Route::is('admin.team.*') ? 'active' : '' }}">
                <a class="collapsed" href="{{ route('admin.team.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <!-- Team SVG Icon -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5 19.5C7.5 18.5344 7.82853 17.5576 8.63092 17.0204C9.59321 16.3761 10.7524 16 12 16C13.2476 16 13.5 16 15.3691 17.0204"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M12 13.5C13.3807 13.5 14.5 12.3807 14.5 11C14.5 9.61929 13.3807 8.5 12 8.5C10.6193 8.5 9.5 9.61929 9.5 11C9.5 12.3807 10.6193 13.5 12 13.5Z"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M17.5 8.5C18.6046 8.5 19.5 7.60457 19.5 6.5C19.5 5.39543 18.6046 4.5 17.5 4.5C16.3954 4.5 15.5 5.39543 15.5 6.5C15.5 7.60457 16.3954 8.5 17.5 8.5Z"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M6.5 11C5.38987 11 4.35846 11.3769 3.50256 12.0224C2.77706 12.5696 2.5 13.4951 2.5 14.4038V14.5"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M6.5 8.5C7.60457 8.5 8.5 7.60457 8.5 6.5C8.5 5.39543 7.60457 4.5 6.5 4.5C5.39543 4.5 4.5 5.39543 4.5 6.5C4.5 7.60457 5.39543 8.5 6.5 8.5Z"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17 12H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17 15H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M20 18H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Team') }}</span>
                    </span>
                </a>
            </li>
            @endif

            <li
                class="{{ Route::is('admin.seller-list') || Route::is('admin.pending-seller') || Route::is('admin.seller-show') || Route::is('admin.seller-joining-request') || Route::is('admin.seller-joining-detail') || Route::is('admin.staff-role-matrix') || (Route::is('admin.staff-list') && (request('type') === 'travel-agent' || request('type') === 'sales-agent' || request('type') === 'booking-agent')) ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__seller"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 5V3C6 1.89543 6.89543 1 8 1H19C20.1046 1 21 1.89543 21 3V12C21 13.1046 20.1046 14 19 14H14M10 5.5H17M13 9.5H17M4.58579 14.5858C5.36683 15.3668 6.63317 15.3668 7.41421 14.5858C7.78929 14.2107 8.29799 14 8.82843 14H9C10.1046 14 11 14.8954 11 16V17C11 18.1046 10.1046 19 9 19H3C1.89543 19 1 18.1046 1 17V16C1 14.8954 1.89543 14 3 14H3.17157C3.70201 14 4.21071 14.2107 4.58579 14.5858ZM8 10C8 11.1046 7.10457 12 6 12C4.89543 12 4 11.1046 4 10C4 8.89543 4.89543 8 6 8C7.10457 8 8 8.89543 8 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Agent') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <div class="collapse crancy__dropdown {{ Route::is('admin.seller-list') || Route::is('admin.pending-seller') || Route::is('admin.seller-show') || Route::is('admin.seller-joining-request') || Route::is('admin.seller-joining-detail') || Route::is('admin.staff-role-matrix') || (Route::is('admin.staff-list') && (request('type') === 'travel-agent' || request('type') === 'sales-agent' || request('type') === 'booking-agent')) ? 'show' : '' }}"
                    id="menu-item__seller" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.seller-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Agent List') }}</span></span></a>
                        </li>
                        <li><a href="{{ route('admin.seller-joining-request') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Join Request') }}</span></span></a>
                        </li>
                        <li><a href="{{ route('admin.agent-role-matrix') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Agent Permissions') }}</span></span></a>
                        </li>
                        <li><a href="{{ route('admin.staff-list', ['type' => 'travel-agent']) }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Travel Agent') }}</span></span></a></li>
                        <li><a href="{{ route('admin.staff-list', ['type' => 'sales-agent']) }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Sales Agent') }}</span></span></a></li>
                        <li><a href="{{ route('admin.staff-list', ['type' => 'booking-agent']) }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Booking Agent') }}</span></span></a></li>
                    </ul>
                </div>
            </li>

            <li
                class="{{ Route::is('admin.user-list') || Route::is('admin.pending-user') || Route::is('admin.user-show') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__users"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.08069 15.2964C3.86241 16.0335 0.668176 17.5386 2.61368 19.422C3.56404 20.342 4.62251 21 5.95325 21H13.5468C14.8775 21 15.936 20.342 16.8863 19.422C18.8318 17.5386 15.6376 16.0335 14.4193 15.2964C11.5625 13.5679 7.93752 13.5679 5.08069 15.2964Z"
                                    stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z"
                                    stroke="currentcolor" stroke-width="1.5" />
                                <path d="M17 5H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17 8H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M20 11H22" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>


                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Users') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.user-list') || Route::is('admin.pending-user') || Route::is('admin.user-show') ? 'show' : '' }}"
                    id="menu-item__users" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.user-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.User List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.pending-user') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Pending User') }}</span></span></a>
                        </li>
                    </ul>
                </div>
            </li>

            @if (! $currentAdmin?->isStaff() || $currentAdmin?->canSeeStaffSection('settings'))
            <li
                class="{{ Route::is('admin.staff-list') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__staff"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M4 20C4 16.6863 7.58172 14 12 14C16.4183 14 20 16.6863 20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Staff Management') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <div class="collapse crancy__dropdown {{ Route::is('admin.staff-list') ? 'show' : '' }}"
                    id="menu-item__staff" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.staff-list') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.All Staff') }}</span></span></a></li>
                        <li><a href="{{ route('admin.staff-list', ['type' => 'data-entry']) }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Data Entry') }}</span></span></a></li>
                        <li><a href="{{ route('admin.staff-list', ['type' => 'accountant']) }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Accountant') }}</span></span></a></li>
                        <li><a href="{{ route('admin.staff-role-matrix') }}"><span class="menu-bar__text"><span class="menu-bar__name">{{ __('translate.Staff Permissions') }}</span></span></a></li>
                    </ul>
                </div>
            </li>
            @endif

            @if (! $currentAdmin?->isStaffAccountant())
            <h4 class="admin-menu__title pt-4">{{ __('translate.CMS & Blogs') }}</h4>

            <li
                class="{{ Route::is('admin.blog.*') || Route::is('admin.blog-category.*') || Route::is('admin.comment-list') || Route::is('admin.show-comment') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__blog"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.5 8V5C17.5 3.89543 16.6046 3 15.5 3H4.5C3.39543 3 2.5 3.89543 2.5 5V19C2.5 20.1046 3.39543 21 4.5 21H19.5"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6.5 8H13.5M6.5 12H13.5M6.5 16H9.5" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M17.5 8H19.5C20.6046 8 21.5 8.89543 21.5 10V19C21.5 20.1046 20.6046 21 19.5 21C18.3954 21 17.5 20.1046 17.5 19V8Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Blog') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.blog.*') || Route::is('admin.blog-category.*') || Route::is('admin.comment-list') || Route::is('admin.show-comment') ? 'show' : '' }}"
                    id="menu-item__blog" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.blog-category.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Categroy') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.blog-category.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Categroy List') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.blog.create') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Create Blog') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.blog.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Blog List') }}</span></span></a></li>

                        <li><a href="{{ route('admin.comment-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Comment List') }}</span></span></a>
                        </li>


                    </ul>
                </div>
            </li>


            <li
                class="{{ Route::is('admin.terms-conditions') || Route::is('admin.privacy-policy') || Route::is('admin.faq.*') || Route::is('admin.custom-page.*') || Route::is('admin.contact-us') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__pages"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.5 22H4.50002C3.39544 22 2.50001 21.1046 2.50002 20L2.50016 3.99998C2.50017 2.89542 3.39559 2 4.50016 2H17.5C18.6046 2 19.5 2.89543 19.5 4V11"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7 7H15M7 12H15" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <path d="M13.5 20V22H15.5L21.5 16L19.5 14L13.5 20Z" stroke="currentColor"
                                    stroke-width="1.5" stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Pages') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.terms-conditions') || Route::is('admin.privacy-policy') || Route::is('admin.faq.*') || Route::is('admin.custom-page.*') || Route::is('admin.contact-us') ? 'show' : '' }}"
                    id="menu-item__pages" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">


                        <li><a href="{{ route('admin.contact-us', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Contact Us') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.terms-conditions', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Terms and Conditions') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.privacy-policy', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Privacy Policy') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.faq.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.FAQ') }}</span></span></a></li>


                        <li><a href="{{ route('admin.custom-page.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Custom Page') }}</span></span></a>
                        </li>

                    </ul>
                </div>
            </li>


            <li
                class="{{ Route::is('admin.front-end.frontend-section') || Route::is('admin.front-end.section') || Route::is('admin.testimonial.*') || Route::is('admin.partner.*') || Route::is('admin.footer') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__for_section"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 10V4.5C21 3.39543 20.1046 2.5 19 2.5H4C2.89543 2.5 2 3.39543 2 4.5V17.5C2 18.6046 2.89543 19.5 4 19.5H10"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M2 8.5H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M13 19.0265L19.2367 12.7898C19.6231 12.4034 20.2496 12.4034 20.6359 12.7898L21.7102 13.8641C22.0966 14.2504 22.0966 14.8769 21.7102 15.2633L15.4735 21.5H13V19.0265Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M5.5 5.5H5.50998M9.49002 5.5H9.5" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>


                        </span>
                        <span class="menu-bar__name">{{ __('translate.Manage Content') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.front-end.frontend-section') || Route::is('admin.front-end.section') || Route::is('admin.testimonial.*') || Route::is('admin.partner.*') || Route::is('admin.footer') ? 'show' : '' }}"
                    id="menu-item__for_section" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">


                        <li><a href="{{ route('admin.front-end.frontend-section') }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Frontend Section') }}</span></span></a>
                        </li>


                        <li><a href="{{ route('admin.footer', ['lang_code' => admin_lang()]) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Footer Info') }}</span></span></a>
                        </li>


                        <li><a href="{{ route('admin.testimonial.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Testimonial') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.partner.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Partner') }}</span></span></a></li>

                    </ul>
                </div>
            </li>


            @endif

            @if (! $currentAdmin?->isStaff())
            <h4 class="admin-menu__title pt-4">{{ __('translate.Setting & Configuration') }}</h4>


            <li class="{{ Route::is('admin.general-setting') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.general-setting') }}"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.8485 4H11.1515C10.2143 4 9.45453 4.71634 9.45453 5.6C9.45453 6.61121 8.37258 7.25411 7.48444 6.77064L7.39423 6.72153C6.58258 6.27971 5.54472 6.54191 5.07612 7.30717L4.22763 8.69281C3.75902 9.45808 4.03711 10.4366 4.84877 10.8785C5.73734 11.3622 5.73733 12.6378 4.84876 13.1215C4.03711 13.5634 3.75902 14.5419 4.22763 15.3072L5.07612 16.6928C5.54472 17.4581 6.58258 17.7203 7.39423 17.2785L7.48444 17.2294C8.37258 16.7459 9.45453 17.3888 9.45453 18.4C9.45453 19.2837 10.2143 20 11.1515 20H12.8485C13.7857 20 14.5455 19.2837 14.5455 18.4C14.5455 17.3888 15.6274 16.7459 16.5156 17.2294L16.6058 17.2785C17.4174 17.7203 18.4553 17.4581 18.9239 16.6928L19.7724 15.3072C20.241 14.5419 19.9629 13.5634 19.1512 13.1215C18.2627 12.6378 18.2627 11.3622 19.1512 10.8785C19.9629 10.4366 20.241 9.45809 19.7724 8.69283L18.9239 7.30719C18.4553 6.54192 17.4174 6.27972 16.6058 6.72154L16.5156 6.77065C15.6274 7.25412 14.5455 6.61122 14.5455 5.6C14.5455 4.71634 13.7857 4 12.8485 4Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor"
                                    stroke-width="1.5" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Setting') }}</span></span></a>
            </li>

            <li class="{{ Route::is('admin.multi-currency.*') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.multi-currency.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.86004 10.75C7.78769 11.1563 7.75 11.574 7.75 12C7.75 12.426 7.78769 12.8437 7.86004 13.25H16C16.4142 13.25 16.75 13.5858 16.75 14C16.75 14.4142 16.4142 14.75 16 14.75H8.30272C9.40895 17.385 12.0576 19.25 15.1667 19.25C17.2472 19.25 19.124 18.4137 20.4698 17.0684C20.7627 16.7756 21.2376 16.7757 21.5304 17.0686C21.8233 17.3615 21.8232 17.8364 21.5302 18.1293C19.9114 19.7475 17.6564 20.75 15.1667 20.75C11.2308 20.75 7.87522 18.2419 6.6988 14.75H3C2.58579 14.75 2.25 14.4142 2.25 14C2.25 13.5858 2.58579 13.25 3 13.25H6.34014C6.28074 12.8419 6.25 12.4246 6.25 12C6.25 11.5754 6.28074 11.1581 6.34015 10.75H3C2.58579 10.75 2.25 10.4142 2.25 10C2.25 9.58579 2.58579 9.25 3 9.25H6.6988C7.87522 5.75809 11.2308 3.25 15.1667 3.25C17.6564 3.25 19.9114 4.25247 21.5302 5.87074C21.8232 6.16359 21.8233 6.63846 21.5304 6.9314C21.2376 7.22435 20.7627 7.22443 20.4698 6.93158C19.124 5.58631 17.2472 4.75 15.1667 4.75C12.0576 4.75 9.40895 6.61504 8.30272 9.25H16C16.4142 9.25 16.75 9.58579 16.75 10C16.75 10.4142 16.4142 10.75 16 10.75H7.86004Z"
                                    fill="currentColor" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Multi Currency') }}</span>
                    </span>

                </a>
            </li>

            <li class="{{ Route::is('admin.language.*') || Route::is('admin.theme-language') ? 'active' : '' }}"><a
                    href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__languages"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1444_12299)">
                                    <path
                                        d="M7.50753 9.196C7.40053 8.732 7.10453 8.31 6.66553 8.126C6.45953 8.04 6.25253 8 6.05253 8C5.36353 8 4.76553 8.475 4.60953 9.147L3.13453 15.399C3.06253 15.706 3.29453 16 3.61053 16C3.83653 16 4.03253 15.845 4.08553 15.625L4.47453 14H7.58953L7.96353 15.621C8.01453 15.843 8.21253 16 8.43953 16H8.45153C8.76553 16 8.99753 15.708 8.92753 15.402L7.50553 9.196H7.50753ZM4.71453 13L5.58353 9.373C5.63453 9.154 5.82753 9 6.05253 9C6.12553 9 6.20153 9.016 6.27853 9.049C6.38953 9.095 6.49153 9.246 6.53153 9.42L7.35853 13H4.71453ZM19.5195 4H4.51953C2.03753 4 0.0195312 6.019 0.0195312 8.5V15.5C0.0195312 17.981 2.03853 20 4.51953 20H19.5195C22.0005 20 24.0195 17.981 24.0195 15.5V8.5C24.0195 6.019 22.0005 4 19.5195 4ZM1.01953 15.5V8.5C1.01953 6.57 2.58953 5 4.51953 5H11.5195V19H4.51953C2.58953 19 1.01953 17.43 1.01953 15.5ZM23.0195 15.5C23.0195 17.43 21.4495 19 19.5195 19H12.5195V5H19.5195C21.4495 5 23.0195 6.57 23.0195 8.5V15.5ZM22.0195 9.491V9.509C22.0195 9.78 21.7995 10 21.5285 10H20.9825C20.8755 10.917 20.4655 12.904 18.8975 14.341C19.5985 14.695 20.4715 14.936 21.5555 14.989C21.8155 15.002 22.0195 15.218 22.0195 15.479V15.497C22.0195 15.778 21.7845 16.002 21.5035 15.988C20.0345 15.917 18.8985 15.54 18.0195 15.002C17.1405 15.54 16.0045 15.917 14.5355 15.988C14.2555 16.002 14.0195 15.778 14.0195 15.497V15.479C14.0195 15.219 14.2235 15.002 14.4835 14.989C15.5685 14.935 16.4405 14.694 17.1425 14.341C16.6025 13.846 16.1995 13.286 15.8995 12.727C15.7235 12.398 15.9585 12 16.3315 12C16.5125 12 16.6765 12.1 16.7635 12.259C17.0545 12.793 17.4585 13.325 18.0205 13.778C19.4945 12.593 19.8825 10.853 19.9845 10.001H14.5115C14.2405 10.001 14.0205 9.781 14.0205 9.51V9.492C14.0205 9.221 14.2405 9.001 14.5115 9.001H17.5205V8.492C17.5205 8.221 17.7405 8.001 18.0115 8.001H18.0295C18.3005 8.001 18.5205 8.221 18.5205 8.492V9.001H21.5295C21.8005 9.001 22.0205 9.221 22.0205 9.492L22.0195 9.491Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.92831 15.4018C8.99831 15.7078 8.76631 15.9998 8.45231 15.9998H8.44031C8.21331 15.9998 8.01531 15.8428 7.96431 15.6208L7.59031 13.9998H4.47531L4.08631 15.6248C4.03331 15.8448 3.83731 15.9998 3.61131 15.9998C3.29531 15.9998 3.06331 15.7058 3.13531 15.3988L4.61031 9.1468C4.76631 8.4748 5.36431 7.9998 6.05331 7.9998C6.25331 7.9998 6.46031 8.0398 6.66631 8.1258C7.0412 8.28293 7.3118 8.61362 7.44948 8.9958C7.47203 9.05841 7.49102 9.1224 7.50631 9.18723C7.50695 9.18994 7.50759 9.19265 7.50821 9.19537C7.50818 9.19522 7.50824 9.19551 7.50821 9.19537L7.50641 9.19624L8.92831 15.4018ZM7.75732 9.3958H7.75968L7.7032 9.15086C7.58517 8.63903 7.25479 8.1556 6.74362 7.94135C6.51372 7.84537 6.28031 7.7998 6.05331 7.7998C5.27133 7.7998 4.5927 8.33886 4.41557 9.10127C4.41554 9.10137 4.41559 9.10117 4.41557 9.10127L2.94066 15.3529C2.83932 15.785 3.166 16.1998 3.61131 16.1998C3.93018 16.1998 4.20621 15.981 4.28075 15.6716L4.63309 14.1998H7.4312L7.76939 15.6656M7.75732 9.3958L9.12326 15.3571C9.22182 15.788 8.89518 16.1998 8.45231 16.1998H8.44031C8.12039 16.1998 7.84138 15.9785 7.76939 15.6656M5.58431 9.3728L4.71531 12.9998H7.35931L6.53231 9.4198C6.49231 9.2458 6.39031 9.0948 6.27931 9.0488C6.20231 9.0158 6.12631 8.9998 6.05331 8.9998C5.82831 8.9998 5.63531 9.1538 5.58431 9.3728ZM7.10784 12.7998L6.33744 9.46482C6.32267 9.40056 6.29666 9.3423 6.26706 9.29878C6.23571 9.25268 6.20996 9.23656 6.20274 9.23357L6.20052 9.23265C6.14597 9.20927 6.09669 9.1998 6.05331 9.1998C5.92175 9.1998 5.80912 9.28928 5.7791 9.41817L5.77881 9.4194L4.96889 12.7998H7.10784ZM22.0213 9.48981C22.0213 9.48948 22.0213 9.49014 22.0213 9.48981C22.0207 9.32807 21.9417 9.18467 21.8203 9.09566C21.739 9.03603 21.6388 9.0008 21.5303 9.0008H18.5213V8.4918C18.5213 8.2208 18.3013 8.0008 18.0303 8.0008H18.0123C17.7413 8.0008 17.5213 8.2208 17.5213 8.4918V9.0008H14.5123C14.2413 9.0008 14.0213 9.2208 14.0213 9.4918V9.5098C14.0213 9.7808 14.2413 10.0008 14.5123 10.0008H19.9853C19.9779 10.0629 19.9689 10.1298 19.9581 10.2008C19.8209 11.1036 19.3878 12.6792 18.0213 13.7778C17.4593 13.3248 17.0553 12.7928 16.7643 12.2588C16.6773 12.0998 16.5133 11.9998 16.3323 11.9998C15.9593 11.9998 15.7243 12.3978 15.9003 12.7268C16.171 13.2312 16.5256 13.7364 16.989 14.194C17.0391 14.2435 17.0906 14.2925 17.1433 14.3408C17.08 14.3726 17.0153 14.4035 16.9493 14.4335C16.2823 14.7357 15.4715 14.9397 14.4843 14.9888C14.2243 15.0018 14.0203 15.2188 14.0203 15.4788V15.4968C14.0203 15.7778 14.2563 16.0018 14.5363 15.9878C16.0053 15.9168 17.1413 15.5398 18.0203 15.0018C18.8993 15.5398 20.0353 15.9168 21.5043 15.9878C21.7853 16.0018 22.0203 15.7778 22.0203 15.4968V15.4788C22.0203 15.2178 21.8163 15.0018 21.5563 14.9888C20.57 14.9406 19.7584 14.7367 19.0921 14.4337C19.0261 14.4037 18.9615 14.3727 18.8983 14.3408C18.951 14.2925 19.0024 14.2436 19.0526 14.1941C20.4935 12.7714 20.8799 10.886 20.9833 9.9998H21.5293C21.7231 9.9998 21.8909 9.88727 21.9707 9.72402C22.0025 9.65902 22.0203 9.58598 22.0203 9.5088V9.4908L22.0213 9.4918C22.0213 9.49147 22.0213 9.49014 22.0213 9.48981ZM22.1178 9.87109L22.2213 9.97465V9.4918C22.2213 9.11035 21.9118 8.80081 21.5303 8.80081H18.7213V8.4918C18.7213 8.11035 18.4118 7.80081 18.0303 7.80081H18.0123C17.6309 7.80081 17.3213 8.11035 17.3213 8.4918V8.80081H14.5123C14.1309 8.80081 13.8213 9.11035 13.8213 9.4918V9.5098C13.8213 9.89126 14.1309 10.2008 14.5123 10.2008H19.7558C19.6218 11.0553 19.2197 12.4821 18.0215 13.5174C17.5475 13.107 17.1981 12.6369 16.9399 12.1631C16.8189 11.9419 16.5886 11.7998 16.3323 11.7998C15.8058 11.7998 15.4778 12.361 15.724 12.8211C15.9923 13.3212 16.3417 13.8239 16.7952 14.2831C16.1668 14.5566 15.4035 14.7428 14.4744 14.7891C14.1067 14.8074 13.8203 15.1135 13.8203 15.4788V15.4968C13.8203 15.8922 14.152 16.2071 14.546 16.1876C15.9885 16.1179 17.1254 15.7583 18.0203 15.2349C18.9152 15.7583 20.0522 16.1179 21.4947 16.1876C21.8899 16.2071 22.2203 15.8919 22.2203 15.4968V15.4788C22.2203 15.1122 21.9337 14.8074 21.5663 14.7891C20.638 14.7437 19.8739 14.5576 19.2461 14.2834C20.6023 12.9104 21.0261 11.1486 21.1592 10.1998H21.5293C21.7779 10.1998 21.996 10.0683 22.1178 9.87109ZM4.52031 3.7998H19.5203C22.1118 3.7998 24.2203 5.90835 24.2203 8.4998V15.4998C24.2203 18.0913 22.1118 20.1998 19.5203 20.1998H4.52031C1.92886 20.1998 -0.179688 18.0913 -0.179688 15.4998V8.4998C-0.179688 5.90838 1.92783 3.7998 4.52031 3.7998ZM1.22031 8.4998V15.4998C1.22031 17.3193 2.70077 18.7998 4.52031 18.7998H11.3203V5.1998H4.52031C2.70077 5.1998 1.22031 6.68026 1.22031 8.4998ZM19.5203 18.7998C21.3399 18.7998 22.8203 17.3193 22.8203 15.4998V8.4998C22.8203 6.68026 21.3399 5.1998 19.5203 5.1998H12.7203V18.7998H19.5203ZM4.52031 3.9998H19.5203C22.0013 3.9998 24.0203 6.0188 24.0203 8.4998V15.4998C24.0203 17.9808 22.0013 19.9998 19.5203 19.9998H4.52031C2.03931 19.9998 0.0203125 17.9808 0.0203125 15.4998V8.4998C0.0203125 6.0188 2.03831 3.9998 4.52031 3.9998ZM1.02031 8.4998V15.4998C1.02031 17.4298 2.59031 18.9998 4.52031 18.9998H11.5203V4.9998H4.52031C2.59031 4.9998 1.02031 6.5698 1.02031 8.4998ZM19.5203 18.9998C21.4503 18.9998 23.0203 17.4298 23.0203 15.4998V8.4998C23.0203 6.5698 21.4503 4.9998 19.5203 4.9998H12.5203V18.9998H19.5203Z"
                                        fill="currentColor" />
                                </g>

                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Language') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.language.*') || Route::is('admin.theme-language') ? 'show' : '' }}"
                    id="menu-item__languages" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.language.index') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Languages') }}</span></span></a></li>

                        <li><a href="{{ route('admin.theme-language', ['lang_code' => 'en']) }}"><span
                                    class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Theme Languages') }}</span></span></a>
                        </li>

                    </ul>
                </div>
            </li>

            <li
                class="{{ Route::is('admin.email-setting') || Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__apps_email_config"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 9L9.7812 11.5208C11.1248 12.4165 12.8752 12.4165 14.2188 11.5208L14.7092 11.1939M13.8027 4H6C3.79086 4 2 5.79086 2 8V18C2 20.2091 3.79086 22 6 22H18C20.2091 22 22 20.2091 22 18V12.1973M22 7C22 8.65685 20.6569 10 19 10C17.3431 10 16 8.65685 16 7C16 5.34315 17.3431 4 19 4C20.6569 4 22 5.34315 22 7Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Email Configuration') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.email-setting') || Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'show' : '' }}"
                    id="menu-item__apps_email_config" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.email-setting') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Configuration') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.email-template') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Email Template') }}</span></span></a>
                        </li>


                    </ul>
                </div>
            </li>


            <li
                class="{{ Route::is('admin.cookie-consent') || Route::is('admin.error-image') || Route::is('admin.login-image') || Route::is('admin.breadcrumb') || Route::is('admin.social-login') || Route::is('admin.default-avatar') || Route::is('admin.maintenance-mode') || Route::is('admin.admin-login-image') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__apps"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="20" height="16" rx="3" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path d="M9 22H12M15 22H12M12 22V18" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11 15H13" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Website Setup') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.cookie-consent') || Route::is('admin.error-image') || Route::is('admin.login-image') || Route::is('admin.breadcrumb') || Route::is('admin.social-login') || Route::is('admin.default-avatar') || Route::is('admin.maintenance-mode') || Route::is('admin.admin-login-image') ? 'show' : '' }}"
                    id="menu-item__apps" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">
                        <li><a href="{{ route('admin.cookie-consent') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Cookie Consent') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.error-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Error Page') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.login-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Login Page') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.admin-login-image') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Admin Login') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.breadcrumb') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Breadcrumb Image') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.social-login') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Social Login') }}</span></span></a>
                        </li>


                        <li><a href="{{ route('admin.default-avatar') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Default Avatar') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.maintenance-mode') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Maintenance mode') }}</span></span></a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="{{ Route::is('admin.seo-setting') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.seo-setting') }}"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.75 11.5C2.75 16.3325 6.66751 20.25 11.5 20.25C16.3325 20.25 20.25 16.3325 20.25 11.5C20.25 6.66751 16.3325 2.75 11.5 2.75C6.66751 2.75 2.75 6.66751 2.75 11.5ZM11.5 21.75C5.83908 21.75 1.25 17.1609 1.25 11.5C1.25 5.83908 5.83908 1.25 11.5 1.25C17.1609 1.25 21.75 5.83908 21.75 11.5C21.75 14.0605 20.8111 16.4017 19.2589 18.1982L22.5303 21.4697C22.8232 21.7626 22.8232 22.2374 22.5303 22.5303C22.2374 22.8232 21.7626 22.8232 21.4697 22.5303L18.1982 19.2589C16.4017 20.8111 14.0605 21.75 11.5 21.75Z"
                                    fill="currentColor" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.SEO Setup') }}</span></span></a>
            </li>

            <li class="{{ Route::is('admin.paymentgateway') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.paymentgateway') }}"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path
                                    d="M14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12C13.1046 12 14 12.8954 14 14C14 15.1046 13.1046 16 12 16C10.8954 16 10 15.1046 10 14"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M12 12C13.1046 12 14 12.8954 14 14C14 15.1046 13.1046 16 12 16C10.8954 16 10 15.1046 10 14"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M12 6.5V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 16V17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Payment Method') }}</span></span></a>
            </li>

            @endif

            {{-- Dev admin: full menu above + Theme/Menu. Super admin: same menu without these two (routes 403 for non-dev). --}}
            @if (Auth::guard('admin')->user()?->isDevAdmin())
            <li class="{{ Route::is('admin.themes.*') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.themes.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 9C2 6.79086 3.79086 5 6 5H18C20.2091 5 22 6.79086 22 9V15C22 17.2091 20.2091 19 18 19H6C3.79086 19 2 17.2091 2 15V9Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 5V19M7 12H17" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Theme Management') }}</span>
                    </span>
                </a>
            </li>

            <li class="{{ Route::is('admin.menus.*') ? 'active' : '' }}"><a class="collapsed"
                    href="{{ route('admin.menus.index') }}">
                    <span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 9C2 6.79086 3.79086 5 6 5H18C20.2091 5 22 6.79086 22 9V15C22 17.2091 20.2091 19 18 19H6C3.79086 19 2 17.2091 2 15V9Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 5V19M7 12H17" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Menu Management') }}</span>
                    </span>
                </a>
            </li>
            @endif

        </ul>
    </div>
    <!-- End Nav Menu -->
</div>
<div class="crancy-sidebar-padding pd-btm-40 pb-btm2">
    <h4 class="admin-menu__title">{{ __('translate.Others') }}</h4>
    <!-- Nav Menu -->
    <div class="menu-bar">
        <ul class="menu-bar__one crancy-dashboard-menu" id="CrancyMenu">
            <li
                class="{{ Route::is('admin.newsletter-list') || Route::is('admin.newsletter-email') ? 'active' : '' }}">
                <a href="#!" class="collapsed" data-bs-toggle="collapse"
                    data-bs-target="#menu-item__apps_newsletter"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 9H12M8 13H16M8 17H16M15.9995 2V5M7.99951 2V5M7 3.5H17C19.2091 3.5 21 5.29086 21 7.5V18C21 20.2091 19.2091 22 17 22H7C4.79086 22 3 20.2091 3 18V7.5C3 5.29086 4.79086 3.5 7 3.5Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </span>
                        <span class="menu-bar__name">{{ __('translate.Newsletter') }}</span></span> <span
                        class="crancy__toggle"></span></a></span>
                <!-- Dropdown Menu -->
                <div class="collapse crancy__dropdown {{ Route::is('admin.newsletter-list') || Route::is('admin.newsletter-email') ? 'show' : '' }}"
                    id="menu-item__apps_newsletter" data-bs-parent="#CrancyMenu">
                    <ul class="menu-bar__one-dropdown">

                        <li><a href="{{ route('admin.newsletter-list') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Subscriber List') }}</span></span></a>
                        </li>

                        <li><a href="{{ route('admin.newsletter-email') }}"><span class="menu-bar__text"><span
                                        class="menu-bar__name">{{ __('translate.Send Mail') }}</span></span></a></li>

                    </ul>
                </div>
            </li>

            <li><a class="collapsed" href="{{ route('admin.cache-clear') }}"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 10C1 14.9706 5.02944 19 10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C6.66873 1 3.76018 2.80989 2.20404 5.5M1.5 1L1.93552 6L7 5.5"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>


                        </span>
                        <span class="menu-bar__name">{{ __('translate.Cache Clear') }}</span></span></a>
            </li>

            <li><a href="javascript:;"
                    onclick="event.preventDefault();
                document.getElementById('admin-sidebar-logout').submit();"
                    class="collapsed"><span class="menu-bar__text">
                        <span class="crancy-menu-icon crancy-svg-icon__v1">
                            <svg class="crancy-svg-icon" xmlns="http://www.w3.org/2000/svg" width="22"
                                height="18" viewBox="0 0 22 18" fill="none">
                                <path d="M19 11L20.2929 9.70711C20.6834 9.31658 20.6834 8.68342 20.2929 8.29289L19 7"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M20 9H12M5 17C2.79086 17 1 15.2091 1 13V5C1 2.79086 2.79086 1 5 1M5 17C7.20914 17 9 15.2091 9 13V5C9 2.79086 7.20914 1 5 1M5 17H13C15.2091 17 17 15.2091 17 13M5 1H13C15.2091 1 17 2.79086 17 5"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span class="menu-bar__name">{{ __('translate.Logout') }}</span></span></a>
            </li>

            <form id="admin-sidebar-logout" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </ul>
    </div>
    <!-- End Nav Menu -->
    <!-- Support Card -->
    <p class=" crancy-ybcolor mg-top-20">{{ __('translate.Version') }} : {{ $general_setting->app_version }}</p>
    <!-- End Support Card -->
    </div>


