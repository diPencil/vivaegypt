<style>
    .footer-locale-switcher {
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 10px !important;
        align-items: flex-start; /* Changed to flex-start so opening a menu doesn't center the other item */
    }
    .footer-locale-switcher .footer-locale-switcher__item {
        flex: 1;
        min-width: 0;
        position: relative; /* Set to relative so absolute dropdown works within it */
    }
    .footer-locale-switcher .language-dropdown-menu {
        position: absolute !important;
        bottom: calc(100% + 10px) !important; /* Open upwards */
        top: auto !important;
        left: 0;
        z-index: 100;
        width: auto;
        min-width: 200px;
        max-height: 250px;
        overflow-y: auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.15);
    }
    .footer-locale-switcher .footer-locale-switcher__item button {
        width: 100%;
        padding: 5px 10px !important;
        min-height: 40px !important;
    }
    .footer-locale-switcher .footer-locale-switcher__item button span {
        font-size: 13px !important;
    }
    .footer-locale-switcher .footer-locale-switcher__item button svg {
        width: 16px !important;
        height: 16px !important;
    }
</style>
<div class="footer-locale-switcher mt-20" data-footer-locale-switcher>
    @if (isset($language_list) && count($language_list) > 1)
        <div class="offCanvas__lang footer-locale-switcher__item" data-lang-dropdown>
        <button type="button" class="offCanvas__lang-toggle language-btn-icon"
            onclick="toggleLanguageDropdown(event)" aria-haspopup="true" aria-expanded="false"
            title="{{ __('translate.Language') }}" aria-label="{{ __('translate.Language') }}">
            <span class="offCanvas__lang-toggle-ring" aria-hidden="true">
                <svg class="offCanvas__lang-toggle-svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
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

    @include('components.front.currency_dropdown_pill', ['variant' => 'footer', 'wrapperClass' => 'footer-locale-switcher__item'])
</div>