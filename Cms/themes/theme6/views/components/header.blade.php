    <!-- header-search -->
    <div class="search__popup">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search__wrapper">
                        <div class="search__close">
                            <button type="button" class="search-close-btn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="search__form">
                            <form action="#">
                                <div class="search__input">
                                    <input class="search-input-field" type="text" placeholder="{{ __('translate.Search keyword') }}">
                                    <span class="search-focus-border"></span>
                                    <button>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-popup-overlay"></div>
    <!-- header-search-end -->

    <!-- header-area -->
    <header class="tg-header-height theme6-header">
        <div class="tg-header__area">
            <div class="tg-header-top tg-header-top-space tg-primary-bg d-none d-lg-block p-relative overflow-hidden">
                <img class="d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/hill-4.png') }}" style="position: absolute; right: 5%; top: -20px; height: 120px; opacity: 0.15; pointer-events: none; z-index: 0;" alt="shape">
                <img class="d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/pyramid-3.png') }}" style="position: absolute; left: 5%; bottom: -10px; height: 80px; opacity: 0.15; pointer-events: none; z-index: 0;" alt="shape">
                <div class="container" style="position: relative; z-index: 1;">
                    <div class="row">
                        @if ($footer->address || $footer->email)
                            <div class="col-lg-6">
                                <div class="tg-header-top-info d-flex align-items-center">
                                    @if ($footer->address)
                                        <a href="{{ $footer->address_url }}"><i
                                                class="mr-5 fa-regular fa-location-dot"></i>
                                            {{ $footer->address }}</a>
                                    @endif

                                    @if ($footer->email)
                                        <span class="tg-header-dvdr mr-10 ml-10"></span>
                                        <a href="mailto:{{ $footer->email }}"><i
                                                class="mr-5 fa-regular fa-envelope"></i> {{ $footer->email }}</a>
                                    @endif

                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="tg-header-top-info d-flex align-items-center justify-content-end">
                                @if ($footer->phone)
                                    <a href="tel:{{ $footer->phone }}"><i class="fa-sharp fa-regular fa-phone"></i>
                                        {{ $footer->phone }}</a>
                                @endif
                                <span class="tg-header-dvdr mr-10 ml-10"></span>
                                <a href="{{ route('user.login') }}"><i class="fa-regular fa-user"></i>
                                    {{ __('translate.Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tg-header-4-bootom tg-header-lg-space" id="header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-5">
                            <div class="tgmenu__wrap d-flex align-items-center">
                                <div class="logo flex-auto">
                                    <a href="{{ route('home') }}"><img
                                            src="{{ asset($general_setting->secondary_logo) }}" alt="Logo"></a>
                                </div>
                                <nav class="tgmenu__nav  ml-90 d-none d-xl-block">
                                    <div
                                        class="tgmenu__navbar-wrap tgmenu__main-menu tgmenu__navbar-wrap-4 d-none d-xl-flex">
                                        @include('components.common_navitems')
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-4 col-7">
                            <div
                                class="tg-menu-right-action tg-menu-right-action-3 tg-menu-4-right-action d-flex align-items-center justify-content-end">
                                <button class="search-button search-open-btn d-none d-sm-block">
                                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M17.3047 16.8044L13.8294 13.3291M15.9857 8.14485C15.9857 12.1989 12.6992 15.4854 8.64519 15.4854C4.59114 15.4854 1.30469 12.1989 1.30469 8.14485C1.30469 4.09081 4.59114 0.804352 8.64519 0.804352C12.6992 0.804352 15.9857 4.09081 15.9857 8.14485Z"
                                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="tg-header-cart p-relative">
                                    @include('components.cart')
                                </div>
                                @include('components.front_language_switcher')
                                <div class="tg-header-btn ms-3 ms-sm-4">
                                @guest('web')
                                    <a class="tg-btn-header" href="{{ route('user.login') }}">
                                        <span class="d-none d-xl-inline-block">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.7 17.2C1.5 17.2 1.3 17.1 1.2 17C1.1 16.8 1 16.7 1 16.5C1 15.1 1.4 13.7 2.1 12.4C2.8 11.2 3.9 10.1 5.1 9.4C4.6 8.8 4.2 8 4 7.2C3.9 6.4 3.9 5.5 4.1 4.8C4.3 4 4.8 3.2 5.3 2.6C5.9 2 6.6 1.5 7.3 1.3C7.9 1.1 8.5 1 9.1 1C9.3 1 9.6 1 9.8 1C10.6 1.1 11.4 1.4 12.1 1.9C12.8 2.4 13.3 3 13.7 3.7C14.1 4.4 14.3 5.2 14.3 6.1C14.3 7.3 13.9 8.5 13.1 9.4C13.7 9.8 14.3 10.2 14.9 10.7C15.7 11.5 16.2 12.3 16.7 13.3C17.1 14.3 17.3 15.3 17.3 16.4C17.3 16.6 17.2 16.8 17.1 16.9C17 17 16.8 17.1 16.6 17.1C16.5 17.1 16.4 17.1 16.3 17C16.2 17 16.1 16.9 16.1 16.8C16 16.7 16 16.7 15.9 16.6C15.9 16.5 15.8 16.4 15.8 16.3C15.8 15.4 15.6 14.6 15.3 13.8C15 13 14.5 12.3 13.8 11.7C13.2 11.2 12.6 10.7 11.9 10.4C11.1 10.9 10.2 11.2 9.1 11.2C8.1 11.2 7.1 10.9 6.3 10.4C5.2 10.9 4.2 11.7 3.5 12.8C2.8 13.9 2.4 15.1 2.4 16.4C2.4 16.6 2.3 16.8 2.2 16.9C2.1 17.1 1.9 17.2 1.7 17.2ZM9.1 2.5C8.4 2.5 7.7 2.7 7.1 3.1C6.4 3.5 6 4.1 5.7 4.7C5.4 5.4 5.3 6.1 5.5 6.9C5.6 7.6 6 8.3 6.5 8.8C7 9.3 7.7 9.7 8.4 9.8C8.6 9.8 8.9 9.9 9.1 9.9C9.6 9.9 10.1 9.8 10.5 9.6C11.2 9.3 11.7 8.9 12.2 8.2C12.6 7.6 12.8 6.9 12.8 6.2C12.8 5.2 12.4 4.3 11.7 3.6C11 2.8 10.1 2.5 9.1 2.5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        {{ __('translate.Login') }}
                                    </a>
                                @else
                                    <a class="tg-btn-header"
                                        href="{{ Auth::guard('web')->user()->is_seller == 1 ? route('agent.dashboard') : route('user.dashboard') }}">
                                        <span class="d-none d-xl-inline-block">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.7 17.2C1.5 17.2 1.3 17.1 1.2 17C1.1 16.8 1 16.7 1 16.5C1 15.1 1.4 13.7 2.1 12.4C2.8 11.2 3.9 10.1 5.1 9.4C4.6 8.8 4.2 8 4 7.2C3.9 6.4 3.9 5.5 4.1 4.8C4.3 4 4.8 3.2 5.3 2.6C5.9 2 6.6 1.5 7.3 1.3C7.9 1.1 8.5 1 9.1 1C9.3 1 9.6 1 9.8 1C10.6 1.1 11.4 1.4 12.1 1.9C12.8 2.4 13.3 3 13.7 3.7C14.1 4.4 14.3 5.2 14.3 6.1C14.3 7.3 13.9 8.5 13.1 9.4C13.7 9.8 14.3 10.2 14.9 10.7C15.7 11.5 16.2 12.3 16.7 13.3C17.1 14.3 17.3 15.3 17.3 16.4C17.3 16.6 17.2 16.8 17.1 16.9C17 17 16.8 17.1 16.6 17.1C16.5 17.1 16.4 17.1 16.3 17C16.2 17 16.1 16.9 16.1 16.8C16 16.7 16 16.7 15.9 16.6C15.9 16.5 15.8 16.4 15.8 16.3C15.8 15.4 15.6 14.6 15.3 13.8C15 13 14.5 12.3 13.8 11.7C13.2 11.2 12.6 10.7 11.9 10.4C11.1 10.9 10.2 11.2 9.1 11.2C8.1 11.2 7.1 10.9 6.3 10.4C5.2 10.9 4.2 11.7 3.5 12.8C2.8 13.9 2.4 15.1 2.4 16.4C2.4 16.6 2.3 16.8 2.2 16.9C2.1 17.1 1.9 17.2 1.7 17.2ZM9.1 2.5C8.4 2.5 7.7 2.7 7.1 3.1C6.4 3.5 6 4.1 5.7 4.7C5.4 5.4 5.3 6.1 5.5 6.9C5.6 7.6 6 8.3 6.5 8.8C7 9.3 7.7 9.7 8.4 9.8C8.6 9.8 8.9 9.9 9.1 9.9C9.6 9.9 10.1 9.8 10.5 9.6C11.2 9.3 11.7 8.9 12.2 8.2C12.6 7.6 12.8 6.9 12.8 6.2C12.8 5.2 12.4 4.3 11.7 3.6C11 2.8 10.1 2.5 9.1 2.5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        {{ __('translate.Dashboard') }}
                                    </a>
                                @endguest
                            </div>
                                <div class="tg-header-menu-bar lh-1 p-relative ml-10">
                                    <button class="tgmenu-offcanvas-open-btn menu-tigger d-none d-xl-block">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                    <button class="tgmenu-offcanvas-open-btn mobile-nav-toggler d-block d-xl-none">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu  -->
        @include('components.common_mobile_menu')
        <!-- End Mobile Menu -->

        <!-- offCanvas-menu -->
        @include('components.common_offcanvas')
        <!-- offCanvas-menu-end -->

    </header>
    <!-- header-area-end -->

    <style>
        .tg-btn-header {
        color: var(--tg-common-white);
        background: var(--tg-theme-primary);
        border-color: var(--tg-theme-primary);
    }
    </style>
