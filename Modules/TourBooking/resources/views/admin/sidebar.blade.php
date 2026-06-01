@php
    $servicesTypes = \Modules\TourBooking\App\Models\ServiceType::where('status', true)
        ->orderBy('display_order', 'asc')
        ->get()
        ->mapWithKeys(function ($serviceType) {
            return [$serviceType->slug => $serviceType->localized_name];
        });
@endphp

@if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.tourbooking.services.index'))
<h4 class="admin-menu__title pt-2">{{ __('translate.Booking Services') }}</h4>
<li
    class="{{ Route::is('admin.tourbooking.services.index') || Route::is('admin.tourbooking.service-types.index') || Route::is('admin.tourbooking.services.by-type') || Route::is('admin.tourbooking.services.tours') || Route::is('admin.tourbooking.services.hotels') || Route::is('admin.tourbooking.services.restaurants') || Route::is('admin.tourbooking.services.rentals') || Route::is('admin.tourbooking.services.activities') || Route::is('admin.tourbooking.amenities.index') ? 'active' : '' }}">
    <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__booking_services_list"><span
            class="menu-bar__text">
            <span class="crancy-menu-icon crancy-svg-icon__v1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 21C2.5 20.0909 4.4 18.2727 8 18.2727C11.6 18.2727 13.5 16.0909 14 15M8 8V5C8 3.89543 8.89543 3 10 3H20C21.1046 3 22 3.89543 22 5V13C22 14.1046 21.1046 15 20 15H16.7397M12 7H18M10 13C10 14.1046 9.10457 15 8 15C6.89543 15 6 14.1046 6 13C6 11.8954 6.89543 11 8 11C9.10457 11 10 11.8954 10 13Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M15 11H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </span>

            <span class="menu-bar__name">{{ __('translate.Booking Services') }}</span></span> <span
            class="crancy__toggle"></span></a></span>
    <!-- Dropdown Menu -->
    <div class="collapse crancy__dropdown {{ Route::is('admin.tourbooking.services.index') || Route::is('admin.tourbooking.service-types.index') || Route::is('admin.tourbooking.services.by-type') || Route::is('admin.tourbooking.services.tours') || Route::is('admin.tourbooking.services.hotels') || Route::is('admin.tourbooking.services.restaurants') || Route::is('admin.tourbooking.services.rentals') || Route::is('admin.tourbooking.services.activities') || Route::is('admin.tourbooking.amenities.index') ? 'show' : '' }}"
        id="menu-item__booking_services_list" data-bs-parent="#CrancyMenu">
        <ul class="menu-bar__one-dropdown">
            <li><a href="{{ dashboard_route('admin.tourbooking.services.index') }}"><span class="menu-bar__text"><span
                            class="menu-bar__name">{{ __('translate.Booking Services') }}</span></span></a></li>

            <li><a href="{{ dashboard_route('admin.tourbooking.service-types.index') }}"><span class="menu-bar__text"><span
                            class="menu-bar__name">{{ __('translate.Booking Service Types') }}</span></span></a></li>

            <li><a href="{{ dashboard_route('admin.tourbooking.amenities.index') }}"><span class="menu-bar__text"><span
                            class="menu-bar__name">{{ __('translate.Amenities') }}</span></span></a></li>

            @foreach ($servicesTypes as $slug => $name)
                <li><a href="{{ dashboard_route('admin.tourbooking.services.by-type', ['type' => $slug]) }}"><span
                            class="menu-bar__text"><span class="menu-bar__name">{{ $name }}</span></span></a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
@endif

@if (! $currentAdmin?->isStaff() || $currentAdmin?->canAccessAdminRoute('admin.tourbooking.destinations.index'))
<li
    class="{{ Route::is('admin.tourbooking.destinations.index') || Route::is(' admin.tourbooking.destinations.create') ? 'active' : '' }}">
    <a href="#!" class="collapsed" data-bs-toggle="collapse" data-bs-target="#menu-item__destination_list"><span
            class="menu-bar__text">
            <span class="crancy-menu-icon crancy-svg-icon__v1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 21C2.5 20.0909 4.4 18.2727 8 18.2727C11.6 18.2727 13.5 16.0909 14 15M8 8V5C8 3.89543 8.89543 3 10 3H20C21.1046 3 22 3.89543 22 5V13C22 14.1046 21.1046 15 20 15H16.7397M12 7H18M10 13C10 14.1046 9.10457 15 8 15C6.89543 15 6 14.1046 6 13C6 11.8954 6.89543 11 8 11C9.10457 11 10 11.8954 10 13Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M15 11H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </span>

            <span class="menu-bar__name">{{ __('translate.Destinations') }}</span></span> <span
            class="crancy__toggle"></span></a></span>
    <!-- Dropdown Menu -->
    <div class="collapse crancy__dropdown {{ Route::is(' admin.tourbooking.destinations.index') || Route::is(' admin.tourbooking.destinations.create') ? 'show' : '' }}"
        id="menu-item__destination_list" data-bs-parent="#CrancyMenu">
        <ul class="menu-bar__one-dropdown">


            <li><a href="{{ dashboard_route('admin.tourbooking.destinations.index') }}"><span class="menu-bar__text"><span
                            class="menu-bar__name">{{ __('translate.Destinations') }}</span></span></a></li>

            <li><a href="{{ dashboard_route('admin.tourbooking.destinations.create') }}"><span class="menu-bar__text"><span
                            class="menu-bar__name">{{ __('translate.Create Destination') }}</span></span></a></li>
        </ul>
    </div>
</li>
@endif

@if (! $currentAdmin?->isStaff())
<li class="{{ Route::is('admin.tourbooking.bookings.index') ? 'active' : '' }}">
    <a class="collapsed" href="{{ dashboard_route('admin.tourbooking.bookings.index') }}">
        <span class="menu-bar__text">
            <span class="crancy-menu-icon crancy-svg-icon__v1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 21C2.5 20.0909 4.4 18.2727 8 18.2727C11.6 18.2727 13.5 16.0909 14 15M8 8V5C8 3.89543 8.89543 3 10 3H20C21.1046 3 22 3.89543 22 5V13C22 14.1046 21.1046 15 20 15H16.7397M12 7H18M10 13C10 14.1046 9.10457 15 8 15C6.89543 15 6 14.1046 6 13C6 11.8954 6.89543 11 8 11C9.10457 11 10 11.8954 10 13Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M15 11H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </span>
            <span class="menu-bar__name">{{ __('translate.Bookings') }}</span>
        </span>
    </a>
</li>
@endif

@if (! $currentAdmin?->isStaff())
<li class="{{ Route::is('admin.tourbooking.reviews.index') || Route::is('admin.tourbooking.reviews.detail') ? 'active' : '' }}">
    <a class="collapsed" href="{{ dashboard_route('admin.tourbooking.reviews.index') }}">
        <span class="menu-bar__text">
            <span class="crancy-menu-icon crancy-svg-icon__v1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.5 22H6.59087C5.04549 22 3.81631 21.248 2.71266 20.1966C0.453366 18.0441 4.1628 16.324 5.57757 15.4816C7.827 14.1422 10.4865 13.7109 13 14.1878"
                        stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path
                        d="M15.5 6.5C15.5 8.98528 13.4853 11 11 11C8.51472 11 6.5 8.98528 6.5 6.5C6.5 4.01472 8.51472 2 11 2C13.4853 2 15.5 4.01472 15.5 6.5Z"
                        stroke="currentcolor" stroke-width="1.5"></path>
                    <path
                        d="M18.6911 14.5777L19.395 15.9972C19.491 16.1947 19.7469 16.3843 19.9629 16.4206L21.2388 16.6343C22.0547 16.7714 22.2467 17.3682 21.6587 17.957L20.6668 18.9571C20.4989 19.1265 20.4069 19.4531 20.4589 19.687L20.7428 20.925C20.9668 21.9049 20.4509 22.284 19.591 21.7718L18.3951 21.0581C18.1791 20.929 17.8232 20.929 17.6032 21.0581L16.4073 21.7718C15.5514 22.284 15.0315 21.9009 15.2554 20.925L15.5394 19.687C15.5914 19.4531 15.4994 19.1265 15.3314 18.9571L14.3395 17.957C13.7556 17.3682 13.9436 16.7714 14.7595 16.6343L16.0353 16.4206C16.2473 16.3843 16.5033 16.1947 16.5993 15.9972L17.3032 14.5777C17.6872 13.8074 18.3111 13.8074 18.6911 14.5777Z"
                        stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </span>
            <span class="menu-bar__name">{{ __('translate.Review list') }}</span>
        </span>
    </a>
</li>
@endif
