<!DOCTYPE html>
<html class="no-js" lang="{{ Session::get('front_lang', 'en') }}" dir="{{ Session::get('lang_dir') == 'right_to_left' ? 'rtl' : 'ltr' }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Title -->
    @yield('title')

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset($general_setting->favicon) }}">

    <!--  Stylesheet -->
    @if(Session::get('lang_dir') == 'right_to_left')
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('global/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/font-awesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/enrollment.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/overview.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/dev.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">


    @stack('style_section')

    @stack('style_section')
</head>

<body id="crancy-dark-light">

    <div class="crancy-body-area ">
        <!-- crancy Admin Menu -->
        <div class="crancy-smenu" id="CrancyMenu">
            <!-- Admin Menu -->
            <div class="admin-menu">

                <!-- Logo -->
                <div class="logo crancy-sidebar-padding pd-right-0">
                    <a class="crancy-logo" href="{{ route('staff.dashboard') }}">
                        <img src="{{ asset($general_setting->secondary_logo) }}" alt="logo">
                    </a>
                    <div id="crancy__sicon" class="crancy__sicon close-icon">
                        <span>
                            <svg width="6" height="12" viewBox="0 0 6 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 1L1 6.00489L5 11.0098" stroke="#fff" stroke-width="1.2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </span>
                    </div>
                </div>

                @include('staff.sidebar')


            </div>
            <!-- End Admin Menu -->
        </div>
        <!-- End crancy Admin Menu -->

        <!-- Start Header -->
        <header class="crancy-header">
            <div class="container g-0">
                <div class="row g-0">
                    <div class="col-12">
                        <!-- Dashboard Header -->
                        <div class="crancy-header__inner">
                            <div class="crancy-header__middle">
                                <div id="crancy__sicon" class="crancy__sicon close-icon d-none">
                                    <span>
                                        <svg width="6" height="12" viewBox="0 0 6 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L5 6.00489L1 11.0098" stroke="#BFCDFF" stroke-width="1.2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                    </span>
                                </div>

                                <div class="crancy-header__heading">
                                    @yield('body-header')
                                    @php
                                        $staffUser = auth()->user();
                                    @endphp
                                    <span class="badge bg-primary ms-2 align-middle" style="font-size:11px;vertical-align:middle;">{{ __('Staff') }}</span>
                                    @if($staffUser && $staffUser->roleDisplayLabel())
                                        <span class="badge bg-secondary ms-1 align-middle" style="font-size:11px;vertical-align:middle;">{{ $staffUser->roleDisplayLabel() }}</span>
                                    @endif
                                </div>

                                <div class="crancy-header__right">
                                    <div class="crancy-header__group">
                                        <div class="crancy-header__group-two">
                                            <div class="crancy-header__right">



                                                <!-- Header Option Group -->
                                                <div class="crancy-header__options">

                                                    <div class="crancy-header__options-cluster">
                                                        <div class="crancy-header__datetime js-header-datetime" role="status"
                                                            aria-live="polite"
                                                            data-locale="{{ str_replace('_', '-', app()->getLocale()) }}"
                                                            data-timezone="{{ config('app.timezone') }}">
                                                            <span class="crancy-header__datetime-date js-header-datetime-date"></span>
                                                            <span class="crancy-header__datetime-time js-header-datetime-time"></span>
                                                        </div>
                                                    <!-- Header Notifications (visit site) -->
                                                    <div class="crancy-header__single">
                                                        <a target="_blank" class="crancy-header__blink"
                                                            href="{{ route('home') }}">
                                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                                <rect x="2" y="3" width="20" height="13" rx="2"></rect>
                                                                <path d="M12 16v4"></path>
                                                                <path d="M8 20h8"></path>
                                                            </svg>

                                                        </a>

                                                    </div>
                                                    <!-- End Notifications -->
                                                    </div>
                                                    <!-- End options cluster (datetime + visit site) -->

                                                    <!-- Header Settings -->
                                                    @if (!$staffUser->isStaffAccountant())
                                                    <div class="crancy-header__settings">
                                                        <a class="crancy-header__blink"
                                                            href="{{ route('staff.seo-setting') }}">
                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M15.5 12C15.5 13.933 13.933 15.5 12 15.5C10.067 15.5 8.5 13.933 8.5 12C8.5 10.067 10.067 8.5 12 8.5C13.933 8.5 15.5 10.067 15.5 12Z"
                                                                    stroke="currentColor" stroke-width="1.5" />
                                                                <path
                                                                    d="M22 13.9669V10.0332C19.1433 10.0332 17.2857 6.93041 18.732 4.46691L15.2679 2.5001C13.8038 4.99405 10.1978 4.99395 8.73363 2.5L5.26953 4.46681C6.71586 6.93035 4.85673 10.0332 2 10.0332V13.9669C4.85668 13.9669 6.71425 17.0697 5.26795 19.5332L8.73205 21.5C10.1969 19.0048 13.8046 19.0047 15.2695 21.4999L18.7336 19.5331C17.2874 17.0696 19.1434 13.9669 22 13.9669Z"
                                                                    stroke="currentColor" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    @endif

                                                    @if (count($language_list) > 1)
                                                        <div class="crancy-header__settings crancy-header__lang" data-lang-dropdown
                                                            style="position: relative;">
                                                            <button type="button"
                                                                class="crancy-header__blink admin-lang-toggle"
                                                                onclick="toggleLanguageDropdown(event)"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                title="{{ __('translate.Language') }}"
                                                                aria-label="{{ __('translate.Language') }}">
                                                                <svg class="admin-lang-toggle__svg" width="22" height="22"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                    <rect x="3.5" y="4" width="17" height="16" rx="4" stroke="currentColor" stroke-width="1.5" />
                                                                    <path d="M8.2 15.2L10.8 8.8L13.4 15.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 13h3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                                    <path d="M14.5 8.8h3M16 7v3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                                    <path d="M15.2 13.2c.6.7 1.4 1.2 2.3 1.5M15.2 15.6c.9-.2 1.8-.7 2.5-1.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </button>
                                                            <div class="language-dropdown-menu admin-lang-dropdown"
                                                                style="display: none;">
                                                                @foreach ($language_list as $lang)
                                                                    <a href="{{ route('language-switcher') }}?lang_code={{ $lang->lang_code }}"
                                                                        class="admin-lang-dropdown__item {{ Session::get('front_lang') == $lang->lang_code ? 'is-active' : '' }}">{{ $lang->lang_name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (isset($currency_list) && $currency_list->count() > 0)
                                                        <div class="crancy-header__settings crancy-header__currency"
                                                            data-currency-dropdown style="position: relative;">
                                                            <button type="button"
                                                                class="crancy-header__blink admin-currency-toggle"
                                                                onclick="toggleCurrencyDropdown(event)"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                title="{{ __('translate.Currency') }}"
                                                                aria-label="{{ __('translate.Currency') }}">
                                                                <svg class="admin-currency-toggle__svg" width="22"
                                                                    height="22" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                    <path
                                                                        d="M12 2V22M17 5H9.5C8.11929 5 7 6.11929 7 7.5C7 8.88071 8.11929 10 9.5 10H14.5C15.8807 10 17 11.1193 17 12.5C17 13.8807 15.8807 15 14.5 15H7"
                                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </button>
                                                            <div class="language-dropdown-menu admin-lang-dropdown admin-currency-dropdown"
                                                                style="display: none;">
                                                                @foreach ($currency_list as $header_currency)
                                                                    @php
                                                                        $currencyRowLabel = trim((string) $header_currency->currency_name) !== ''
                                                                            ? $header_currency->currency_name
                                                                            : $header_currency->currency_code;
                                                                    @endphp
                                                                    <a href="{{ route('currency-switcher', ['currency_code' => $header_currency->currency_code]) }}"
                                                                        class="admin-lang-dropdown__item admin-currency-dropdown__item {{ Session::get('currency_code') == $header_currency->currency_code ? 'is-active' : '' }}">
                                                                        <span class="admin-currency-dropdown__icon">{{ $header_currency->currency_icon }}</span>
                                                                        <span class="admin-currency-dropdown__title">{{ $currencyRowLabel }}</span>
                                                                        <span class="admin-currency-dropdown__rate">{{ number_format((float) $header_currency->currency_rate, 2) }}</span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <!-- Header Nav -->
                                                </div>
                                                <!-- End Header Option Group-->

                                                @php
                                                    $auth_user = Auth::guard('web')->user();
                                                @endphp

                                                <!-- Header Author -->
                                                <div class="crancy-header__single">
                                                    <a href="{{ route('user.edit-profile') }}">
                                                        <div class="crancy-header__author-img">
                                                            @if ($auth_user?->image)
                                                                <img src="{{ asset($auth_user?->image) }}"
                                                                    alt="#">
                                                            @else
                                                                <img src="{{ asset($general_setting->default_avatar) }}"
                                                                    alt="#">
                                                            @endif

                                                        </div>
                                                    </a>
                                                    <!-- crancy Profile Hover -->

                                                    <!-- Dropdown List -->
                                                    <div class="crancy-dropdown crancy-dropdown--acount">
                                                        <div class="crancy-dropdown__hover--inner">
                                                            <ul class="crancy-dmenu">
                                                                <li>
                                                                    <a href="{{ route('user.edit-profile') }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none">
                                                                            <path
                                                                                d="M12.1202 12.78C12.0502 12.77 11.9602 12.77 11.8802 12.78C10.1202 12.72 8.72021 11.28 8.72021 9.50998C8.72021 7.69998 10.1802 6.22998 12.0002 6.22998C13.8102 6.22998 15.2802 7.69998 15.2802 9.50998C15.2702 11.28 13.8802 12.72 12.1202 12.78Z"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                        {{ __('translate.My Profile') }}
                                                                    </a>
                                                                </li>


                                                                <li>
                                                                    <a href="{{ route('user.logout') }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none">
                                                                            <path
                                                                                d="M15 10L13.7071 11.2929C13.3166 11.6834 13.3166 12.3166 13.7071 12.7071L15 14M14 12L22 12M6 20C3.79086 20 2 18.2091 2 16V8C2 5.79086 3.79086 4 6 4M6 20C8.20914 20 10 18.2091 10 16V8C10 5.79086 8.20914 4 6 4M6 20H14C16.2091 20 18 18.2091 18 16M6 4H14C16.2091 4 18 5.79086 18 8"
                                                                                stroke-width="1.5"
                                                                                stroke-linecap="round" />
                                                                        </svg>
                                                                        {{ __('translate.Logout') }}
                                                                    </a>

                                                                </li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <!-- End Dropdown List -->
                                                </div>
                                                <!-- End Header Author -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End Header -->

        @yield('body-content')

    </div>

    <!--  Scripts -->
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('global/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('global/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery-migrate.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('backend/js/nice-select.min.js') }}"></script>

    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('global/js/language-switcher.js') }}"></script>
    <script src="{{ asset('backend/js/header-datetime.js') }}"></script>

    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {


                const session_notify_message = @json(Session::get('message'));

                if (session_notify_message != null) {
                    const session_notify_type = @json(Session::get('alert-type', 'info'));
                    switch (session_notify_type) {
                        case 'info':
                            toastr.info(session_notify_message);
                            break;
                        case 'success':
                            toastr.success(session_notify_message);
                            break;
                        case 'warning':
                            toastr.warning(session_notify_message);
                            break;
                        case 'error':
                            toastr.error(session_notify_message);
                            break;
                    }
                }

                const validation_errors = @json($errors->all());

                if (validation_errors.length > 0) {
                    validation_errors.forEach(error => toastr.error(error));
                }

                const session_success = `{{ Session::get('success') }}`;
                const session_error = `{{ Session::get('error') }}`;
                if (session_success) {
                    toastr.success(session_success);
                }

                if (session_error) {
                    toastr.error(session_error);
                }

                @if (Session::get('lang_dir') === 'right_to_left')
                    $('#dataTable').DataTable({
                        language: {
                            lengthMenu: @json(__('translate.DT_lengthMenu')),
                            zeroRecords: @json(__('translate.DT_zeroRecords')),
                            info: @json(__('translate.DT_info')),
                            infoEmpty: @json(__('translate.DT_infoEmpty')),
                            infoFiltered: @json(__('translate.DT_infoFiltered')),
                            search: @json(__('translate.DT_search')),
                            paginate: {
                                first: @json(__('translate.DT_first')),
                                last: @json(__('translate.DT_last')),
                                next: @json(__('translate.Next')),
                                previous: @json(__('translate.Previous')),
                            },
                        },
                    });
                @else
                    $('#dataTable').DataTable();
                @endif

                const isStaffDashboard = @json(Auth::guard('web')->user()?->isStaff() ?? false);
                if (isStaffDashboard) {
                    $('.delete_danger_btn, [data-bs-target*="deleteModal"], [data-bs-target="#exampleModal"]').hide();
                    $('.modal[id*="deleteModal"], #exampleModal').remove();

                    $('form').each(function() {
                        const methodField = $(this).find('input[name="_method"]');
                        if (methodField.length && String(methodField.val()).toUpperCase() === 'DELETE') {
                            $(this).remove();
                        }
                    });

                    $(document).on('submit', 'form', function(e) {
                        const methodField = $(this).find('input[name="_method"]');
                        if (methodField.length && String(methodField.val()).toUpperCase() === 'DELETE') {
                            e.preventDefault();
                            return false;
                        }
                    });
                }
            });
        })(jQuery);
    </script>


    @stack('js_section')

</body>

</html>
