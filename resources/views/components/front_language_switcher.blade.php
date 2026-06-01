@if (isset($language_list) && count($language_list) > 1)
    <div class="tg-header-lang-wrap d-none d-xl-flex align-items-center" data-lang-dropdown>
        <button type="button" class="tg-header-lang-toggle language-btn-icon"
            onclick="toggleLanguageDropdown(event)" aria-haspopup="true" aria-expanded="false"
            title="{{ __('translate.Language') }}" aria-label="{{ __('translate.Language') }}">
            <svg class="tg-header-lang-toggle__icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect x="3.5" y="4" width="17" height="16" rx="4" stroke="currentColor" stroke-width="1.5" />
                <path d="M8.2 15.2L10.8 8.8L13.4 15.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9 13h3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <path d="M14.5 8.8h3M16 7v3.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                <path d="M15.2 13.2c.6.7 1.4 1.2 2.3 1.5M15.2 15.6c.9-.2 1.8-.7 2.5-1.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="language-dropdown-menu tg-header-lang-dropdown" style="display: none;">
            @foreach ($language_list as $lang)
                <a href="{{ route('language-switcher') }}?lang_code={{ $lang->lang_code }}"
                    class="tg-header-lang-dropdown__link {{ Session::get('front_lang') == $lang->lang_code ? 'is-active' : '' }}">{{ $lang->lang_name }}</a>
            @endforeach
        </div>
    </div>
@endif
