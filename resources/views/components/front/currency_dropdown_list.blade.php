@php
    $currencies = $currency_list ?? collect();
@endphp

@if ($currencies->count() > 0)
    <div class="tg-filter-currency">
        <h4 class="tg-filter-title mb-15">{{ __('translate.Currency') }}</h4>
        <div class="tg-filter-list">
            <ul>
                @foreach ($currencies as $currency)
                    @php
                        $currencyRowLabel = trim((string) $currency->currency_name) !== '' ? $currency->currency_name : $currency->currency_code;
                        $isActive = Session::get('currency_code') == $currency->currency_code;
                    @endphp
                    <li>
                        <a href="{{ route('currency-switcher', ['currency_code' => $currency->currency_code]) }}"
                            class="checkbox d-flex align-items-center w-100 {{ $isActive ? 'active' : '' }}">
                            <span class="tg-label flex-grow-1">{{ $currencyRowLabel }}</span>
                            <span>{{ $currency->currency_icon }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
