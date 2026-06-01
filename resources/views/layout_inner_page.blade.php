<!DOCTYPE html>
<html class="no-js" lang="{{ Session::get('front_lang', 'en') }}" dir="{{ Session::get('lang_dir') == 'right_to_left' ? 'rtl' : 'ltr' }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset($general_setting->favicon) }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Site Title -->
    @yield('title')

    @if(Session::get('lang_dir') == 'right_to_left')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/flatpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dev.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/cookie_consent.css') }}">
    @if(Session::get('lang_dir') == 'right_to_left')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/rtl-utils.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
    @if(Session::get('lang_dir') == 'right_to_left')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme1-rtl.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">

    @stack('style_section')

    @if ($general_setting->google_analytic_status == 1)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $general_setting->google_analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $general_setting->google_analytic_id }}');
        </script>
    @endif


    @if ($general_setting->pixel_status == 1)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $general_setting->pixel_app_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $general_setting->pixel_app_id }}&ev=PageView&noscript=1" /></noscript>
    @endif

</head>

<body class="inner_page">

    @if ($general_setting->preloader_status == 'enable')
        <!-- Start Preloader -->
        <div id="loading">
            <div class="loader"></div>
        </div>
        <!-- End Preloader -->
    @endif

    @if ($general_setting->preloader_status == 'enable')
        <!-- Scroll-top -->
        <button class="scroll__top scroll-to-target" data-target="html">
            <i class="fa-sharp fa-regular fa-arrow-up"></i>
        </button>
        <!-- Scroll-top-end-->
    @endif


    <!-- header (same markup as active theme home — see Cms/themes/.../components/header.blade.php) -->
    @include('components.header')
    @yield('front-content')


    <!-- footer-area-start -->
    <footer>
        <div class="tg-footer-area pt-130 include-bg {{ request()->routeIs('faq') || request()->routeIs('pricing') ? 'tg-footer-space' : '' }} "
            data-background="{{ asset('frontend/assets/img/others/footer/footer.jpg') }}">
            <div class="container">
                <div class="tg-footer-top pb-40">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="tg-footer-widget mb-40">
                                <div class="tg-footer-logo mb-25">
                                    @if ($general_setting->footer_logo)
                                        <a href="{{ route('home') }}"><img
                                                src="{{ asset($general_setting->footer_logo) }}" alt="Viva Egypt Travel"></a>
                                    @else
                                        <a href="{{ route('home') }}"><img src="{{ asset($general_setting->logo) }}"
                                                alt="Viva Egypt Travel"></a>
                                    @endif
                                </div>
                                <div class="footer-content">
                                    <h4 class="tg-footer-widget-title mb-20 text-white">{{ __('brand.about_us') }}</h4>
                                    <p class="mb-20">{{ __('brand.footer_about') }}</p>
                                    <div class="tg-footer-social">
                                        <h5 class="text-white mb-15" style="font-size: 16px;">{{ __('translate.Follow us:') }}</h5>
                                        @isset($footer->facebook)
                                            <a href="{{ $footer->facebook }}"><i class="fa-brands fa-facebook-f"></i></a>
                                        @endisset
                                        @isset($footer->twitter)
                                            <a href="{{ $footer->twitter }}"><i class="fa-brands fa-twitter"></i></a>
                                        @endisset
                                        @isset($footer->instagram)
                                            <a href="{{ $footer->instagram }}"><i class="fa-brands fa-instagram"></i></a>
                                        @endisset
                                        @isset($footer->youtube)
                                            <a href="{{ $footer->youtube }}"><i class="fa-brands fa-youtube"></i></a>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                            <div class="tg-footer-widget tg-footer-link mb-40">
                                <h3 class="tg-footer-widget-title mb-25">{{ __('translate.Quick Links') }}</h3>
                                <ul>
                                    <li><a href="{{ route('home') }}">{{ __('translate.nav_home') }}</a></li>
                                    <li><a href="{{ route('about-us') }}">{{ __('translate.nav_about') }}</a></li>
                                    <li><a href="{{ route('tours') }}">{{ __('translate.nav_tours') }}</a></li>
                                    <li><a href="{{ route('contact-us') }}">{{ __('translate.nav_contact') }}</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Utility Pages -->
                        <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                            <div class="tg-footer-widget tg-footer-link mb-40">
                                <h3 class="tg-footer-widget-title mb-25">{{ __('translate.Utility Pages') }}</h3>
                                <ul>
                                    <li><a href="#">{{ __('translate.Privacy Policy') }}</a></li>
                                    <li><a href="#">{{ __('translate.Terms and Condition') }}</a></li>
                                    <li><a href="#">{{ __('translate.FAQ') }}</a></li>
                                    <li><a href="#">{{ __('translate.Destinations') }}</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="tg-footer-widget mb-40">
                                <h3 class="tg-footer-widget-title mb-25">{{ __('translate.Information') }}</h3>
                                <div class="footer-contact-list">
                                    <ul class="list-wrap">
                                        <li class="d-flex align-items-start mb-20">
                                            <div class="icon mr-15 mt-5">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                            </div>
                                            <div class="text">
                                                <span class="d-block text-white fw-bold mb-5">{{ __('translate.Office Address') }}</span>
                                                <p class="mb-0 text-white-50">{{ __('brand.office_hurghada') }}</p>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-start mb-20">
                                            <div class="icon mr-15 mt-5">
                                                <i class="fas fa-phone-alt text-danger"></i>
                                            </div>
                                            <div class="text">
                                                <span class="d-block text-white fw-bold mb-5">{{ __('translate.Phone Number') }}</span>
                                                <p class="mb-0 text-white-50">{{ $footer->phone }}</p>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <div class="icon mr-15 mt-5">
                                                <i class="fas fa-clock text-danger"></i>
                                            </div>
                                            <div class="text">
                                                <span class="d-block text-white fw-bold mb-5">{{ __('translate.Working Days') }}</span>
                                                <p class="mb-0 text-white-50">{{ __('brand.mon_sat') }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tg-footer-copyright text-center">
                <span>
                    © {{ date('Y') }} <a href="{{ route('home') }}" class="text-white">Viva Egypt Travel</a>. {{ __('translate.Copyright') }}
                </span>
            </div>
        </div>
    </footer>
    <!-- footer-area-end -->

    @if ($general_setting->tawk_status == 1)
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $general_setting->tawk_chat_link }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endif

    @include('components.front.live-chat-widget')



    @if ($general_setting->cookie_consent_status == 1)
        <!-- common-modal start  -->
        <div class="common-modal cookie_consent_modal d-none bg-white">
            <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>

            <h5>{{ __('translate.Cookies') }}</h5>
            <p>{{ $general_setting->cookie_consent_message }}</p>


            <a href="javascript:;"
                class="td_btn td_style_1 td_type_3 td_radius_30 td_medium td_fs_14 report-modal-btn cookie_consent_accept_btn">
                <span class="td_btn_in td_accent_color">
                    <span>{{ __('translate.Accept') }}</span>
                </span>
            </a>

        </div>
        <!-- common-modal end  -->
    @endif


    <!-- Script -->
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('global/js/language-switcher.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/cart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>

    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {

                const session_notify_message = @json(Session::get('message'));
                const demo_mode_message = @json(Session::get('demo_mode'));

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

                if (demo_mode_message != null) {
                    toastr.warning(
                        "{{ __('translate.All Language keywords are not implemented in the demo mode') }}"
                    );
                    toastr.info("{{ __('translate.Admin can translate every word from the admin panel') }}");
                }

                const validation_errors = @json($errors->all());

                if (validation_errors.length > 0) {
                    validation_errors.forEach(error => toastr.error(error));
                }

                if (localStorage.getItem('vivaegypttravel-cookie') != '1') {
                    $('.cookie_consent_modal').removeClass('d-none');
                }

                $('.cookie_consent_close_btn').on('click', function() {
                    $('.cookie_consent_modal').addClass('d-none');
                });

                $('.cookie_consent_accept_btn').on('click', function() {
                    localStorage.setItem('vivaegypttravel-cookie', '1');
                    $('.cookie_consent_modal').addClass('d-none');
                });

                $('.before_auth_wishlist').on("click", function() {
                    toastr.error("{{ __('translate.Please login first') }}")
                });

                $(".currency_code").on('change', function() {
                    var currency_code = $(this).val();

                    window.location.href = "{{ route('currency-switcher') }}" + "?currency_code=" +
                        currency_code;
                });

                $(".language_code").on('change', function() {
                    var language_code = $(this).val();

                    window.location.href = "{{ route('language-switcher') }}" + "?lang_code=" +
                        language_code;
                });

            });
        })(jQuery);
    </script>


    @stack('js_section')


</body>

</html>
