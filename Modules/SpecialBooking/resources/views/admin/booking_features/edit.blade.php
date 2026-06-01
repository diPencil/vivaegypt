@extends(dashboard_layout())
@section('title')<title>{{ __('translate.Edit Booking Feature') }}</title>@endsection
@section('body-header')<h3 class="crancy-header__title m-0">{{ __('translate.Edit Booking Feature') }}</h3><p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Edit Booking Feature') }}</p>@endsection
@section('body-content')
@php
    $current_lang = $lang_code ?? (function_exists('admin_lang') ? admin_lang() : 'en');
    $default_lang = function_exists('admin_lang') ? admin_lang() : 'en';
    $t = $booking_feature->translation;
@endphp
<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row">
            <div class="col-12">
                <div class="crancy-body">
                    <div class="crancy-dsinner">

                        {{-- Language Switcher --}}
                        <div class="row">
                            <div class="col-12 mg-top-30">
                                <div class="crancy-product-card translation_main_box">
                                    <div class="crancy-customer-filter">
                                        <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch">
                                            <div class="crancy-header__form crancy-header__form--customer">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Switch to language translation') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="translation_box">
                                        <ul>
                                            @foreach ($language_list as $language)
                                                <li>
                                                    <a href="{{ dashboard_route('admin.special-booking.booking-features.edit', ['booking_feature' => $booking_feature->id, 'lang_code' => $language->lang_code]) }}">
                                                        @if ($current_lang == $language->lang_code)
                                                            <i class="fas fa-eye"></i>
                                                        @else
                                                            <i class="fas fa-edit"></i>
                                                        @endif
                                                        {{ $language->lang_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="alert alert-secondary" role="alert">
                                            @php $edited_language = $language_list->where('lang_code', $current_lang)->first(); @endphp
                                            <p>{{ __('translate.Your editing mode') }} : <b>{{ $edited_language?->lang_name ?? $current_lang }}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Form --}}
                        <form action="{{ dashboard_route('admin.special-booking.booking-features.update', $booking_feature->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="lang_code" value="{{ $current_lang }}">

                            <div class="row">
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <div class="create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Booking Features') }}</h4>
                                            <a href="{{ dashboard_route('admin.special-booking.booking-features.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Booking Features') }}</a>
                                        </div>

                                        <div class="row mg-top-30">
                                            @if($default_lang == $current_lang)
                                            {{-- Context (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Feature Context') }} *</label>
                                                    <select class="crancy__item-input" name="context" required>
                                                        @foreach($contexts as $value => $label)
                                                            <option value="{{ $value }}" {{ old('context', $booking_feature->context) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Title (translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                    <input class="crancy__item-input" type="text" name="title" value="{{ old('title', $t->title ?? $booking_feature->title) }}" required>
                                                </div>
                                            </div>

                                            {{-- Short Description (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Short Description') }}</label>
                                                    <textarea class="crancy__item-input" name="short_description" rows="3">{{ old('short_description', $t->short_description ?? $booking_feature->short_description) }}</textarea>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- Icon Class (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Icon Class') }}</label>
                                                    <input class="crancy__item-input" type="text" name="icon_class" value="{{ old('icon_class', $booking_feature->icon_class) }}">
                                                </div>
                                            </div>

                                            {{-- Sort Order (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Sort Order') }}</label>
                                                    <input class="crancy__item-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $booking_feature->sort_order) }}">
                                                </div>
                                            </div>

                                            {{-- Status (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                                    <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                        <label class="crancy__item-switch">
                                                            <input name="status" type="checkbox" {{ $booking_feature->status ? 'checked' : '' }} value="1">
                                                            <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mg-top-30">
                                    <button class="crancy-btn" type="submit">{{ __('translate.Update') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection