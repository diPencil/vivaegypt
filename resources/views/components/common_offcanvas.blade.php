    <!-- offCanvas-menu -->
    <div class="offCanvas__info">
        <div class="offCanvas__close-icon menu-close">
            <button><i class="fa-sharp fa-regular fa-xmark"></i></button>
        </div>
        <div class="offCanvas__logo mb-30">
            <a href="{{ route('home') }}"><img src="{{ asset($general_setting?->secondary_logo) }}"
                    alt="Logo"></a>
        </div>
        <div class="offCanvas__side-info mb-30">
            <div class="contact-list mb-30">
                <h4>{{ __('translate.Office Address') }}</h4>
                <p>{{ __('brand.office_hurghada') }}</p>
            </div>
            <div class="contact-list mb-30">
                <h4>{{ __('translate.Phone Number') }}</h4>
                <p>{{ $footer->phone }}</p>
            </div>
            <div class="contact-list mb-30">
                <h4>{{ __('translate.Email Address') }}</h4>
                <p>{{ $footer->email }}</p>
            </div>
        </div>
        <div class="offCanvas__social-icon mt-30">
            @if ($footer->facebook)
                <a href="{{ $footer->facebook }}"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if ($footer->twitter)
                <a href="{{ $footer->twitter }}"><i class="fab fa-twitter"></i></a>
            @endif
            @if ($footer->instagram)
                <a href="{{ $footer->instagram }}"><i class="fab fa-instagram"></i></a>
            @endif
            @if ($footer->linkedin)
                <a href="{{ $footer->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if ($footer->youtube)
                <a href="{{ $footer->youtube }}"><i class="fab fa-youtube"></i></a>
            @endif
        </div>
        @if (isset($language_list) && count($language_list) > 1)
            <div class="offCanvas__lang mt-30" data-lang-dropdown>
                <button type="button" class="offCanvas__lang-toggle language-btn-icon"
                    onclick="toggleLanguageDropdown(event)" aria-haspopup="true" aria-expanded="false"
                    title="{{ __('translate.Language') }}" aria-label="{{ __('translate.Language') }}">
                    <span class="offCanvas__lang-toggle-ring" aria-hidden="true">
                        <svg class="offCanvas__lang-toggle-svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3.5" y="4" width="17" height="16" rx="4" stroke="currentColor" stroke-width="1.5" />
                            <path d="M8.2 15.2L10.8 8.8L13.4 15.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 13h3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M14.5 8.8h3M16 7v3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M15.2 13.2c.6.7 1.4 1.2 2.3 1.5M15.2 15.6c.9-.2 1.8-.7 2.5-1.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="offCanvas__lang-toggle-label">{{ __('translate.Language') }}</span>
                    <span class="offCanvas__lang-chevron" aria-hidden="true">
                        <i class="fa-sharp fa-regular fa-chevron-down"></i>
                    </span>
                </button>
                <div class="language-dropdown-menu offCanvas__lang-dropdown" style="display: none;">
                    @foreach ($language_list as $lang)
                        <a href="{{ route('language-switcher') }}?lang_code={{ $lang->lang_code }}"
                            class="offCanvas__lang-dropdown__link {{ Session::get('front_lang') == $lang->lang_code ? 'is-active' : '' }}">{{ $lang->lang_name }}</a>
                    @endforeach
                </div>
            </div>
        @endif

        @include('components.front.currency_dropdown_pill', ['variant' => 'offcanvas'])
    </div>
    <div class="offCanvas__overly"></div>
    <!-- offCanvas-menu-end -->
