@props(['variant' => 'offcanvas', 'wrapperClass' => ''])

@php
    $isFilter = $variant === 'filter';
    $isFooter = $variant === 'footer';
    $root = $isFilter ? 'tg-filter-currency' : 'offCanvas__currency';
    $rootClasses = trim($root . ' ' . ($isFilter ? 'mt-20' : ($isFooter ? 'footer-locale-switcher__currency' : 'mt-30')) . ' ' . $wrapperClass);
@endphp

@if (isset($currency_list) && $currency_list->count() > 0)
    <div class="{{ $rootClasses }}" data-currency-dropdown>
        <button type="button" class="{{ $root }}-toggle" onclick="toggleCurrencyDropdown(event)"
            aria-haspopup="true" aria-expanded="false" title="{{ __('translate.Currency') }}"
            aria-label="{{ __('translate.Currency') }}">
            <span class="{{ $root }}-toggle-ring" aria-hidden="true">
                <svg class="{{ $root }}-toggle-svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 2V22M17 5H9.5C8.11929 5 7 6.11929 7 7.5C7 8.88071 8.11929 10 9.5 10H14.5C15.8807 10 17 11.1193 17 12.5C17 13.8807 15.8807 15 14.5 15H7"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <span class="{{ $root }}-toggle-label">{{ __('translate.Currency') }}</span>
            <span class="{{ $root }}-chevron" aria-hidden="true">
                <i class="fa-sharp fa-regular fa-chevron-down"></i>
            </span>
        </button>
        <div class="language-dropdown-menu {{ $root }}-dropdown" style="display: none;">
            @foreach ($currency_list as $c)
                @php
                    $currencyRowLabel = trim((string) $c->currency_name) !== '' ? $c->currency_name : $c->currency_code;
                @endphp
                <a href="{{ route('currency-switcher', ['currency_code' => $c->currency_code]) }}"
                    class="{{ $root }}-dropdown__link {{ Session::get('currency_code') == $c->currency_code ? 'is-active' : '' }}">
                    <span class="{{ $root }}-dropdown__icon">{{ $c->currency_icon }}</span>
                    <span class="{{ $root }}-dropdown__text">{{ $currencyRowLabel }}</span>
                    <span class="{{ $root }}-dropdown__rate">{{ number_format((float) $c->currency_rate, 2) }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
