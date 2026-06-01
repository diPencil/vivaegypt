<div class="tgmobile__menu">
    <nav class="tgmobile__menu-box">
        <div class="close-btn"><i class="fa-solid fa-xmark"></i></div>
        <div class="nav-logo">
            <a href="{{ route('home') }}"><img src="{{ asset($general_setting->secondary_logo) }}"
                    alt="logo"></a>
        </div>
        <div class="tgmobile__menu-outer">
            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
        </div>

        <div class="tgmobile__menu-extras mt-30 mb-30 px-4">
            @if (isset($language_list) && count($language_list) > 1)
                <div class="offCanvas__lang mb-20" data-lang-dropdown>
                    <button type="button" class="offCanvas__lang-toggle language-btn-icon w-100"
                        onclick="toggleLanguageDropdown(event)" aria-haspopup="true" aria-expanded="false"
                        title="{{ __('translate.Language') }}" aria-label="{{ __('translate.Language') }}">
                        <span class="offCanvas__lang-toggle-ring" aria-hidden="true">
                            <svg class="offCanvas__lang-toggle-svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path d="M3 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M12 3C14.5013 7.05329 14.5013 16.9467 12 21C9.49872 16.9467 9.49872 7.05329 12 3Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path
                                    d="M5.63672 5.63604C8.20797 8.20729 15.7924 8.20729 18.3636 5.63604"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M18.3643 18.364C15.793 15.7927 8.20862 15.7927 5.63736 18.364"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                                <rect x="3.5" y="4" width="17" height="16" rx="4" stroke="currentColor" stroke-width="1.5" />
                                <path d="M8.2 15.2L10.8 8.8L13.4 15.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 13h3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M14.5 8.8h3M16 7v3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M15.2 13.2c.6.7 1.4 1.2 2.3 1.5M15.2 15.6c.9-.2 1.8-.7 2.5-1.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            @endif

            @include('components.front.currency_dropdown_pill', ['variant' => 'offcanvas', 'wrapperClass' => 'mt-0 w-100'])
        </div>

        <div class="social-links">
            <ul class="list-wrap">
                @if ($footer->facebook)
                    <li><a href="{{ $footer->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                @endif
                @if ($footer->twitter)
                    <li><a href="{{ $footer->twitter }}"><i class="fab fa-twitter"></i></a></li>
                @endif
                @if ($footer->instagram)
                    <li><a href="{{ $footer->instagram }}"><i class="fab fa-instagram"></i></a></li>
                @endif
                @if ($footer->linkedin)
                    <li><a href="{{ $footer->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                @endif
                @if ($footer->youtube)
                    <li><a href="{{ $footer->youtube }}"><i class="fab fa-youtube"></i></a></li>
                @endif
            </ul>
        </div>
    </nav>
</div>
<div class="tgmobile__menu-backdrop"></div>