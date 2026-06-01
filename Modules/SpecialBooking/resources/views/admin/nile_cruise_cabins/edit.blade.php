@extends(dashboard_layout())
@section('title')<title>{{ __('translate.Edit Nile Cruise Cabin') }}</title>@endsection
@section('body-header')<h3 class="crancy-header__title m-0">{{ __('translate.Edit Nile Cruise Cabin') }}</h3><p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Edit Nile Cruise Cabin') }}</p>@endsection
@section('body-content')
@php
    $current_lang = $lang_code ?? (function_exists('admin_lang') ? admin_lang() : 'en');
    $default_lang = function_exists('admin_lang') ? admin_lang() : 'en';
    $t = $nile_cruise_cabin->translation;
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
                                                    <a href="{{ dashboard_route('admin.special-booking.nile-cruise-cabins.edit', ['nile_cruise_cabin' => $nile_cruise_cabin->id, 'lang_code' => $language->lang_code]) }}">
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
                        <form action="{{ dashboard_route('admin.special-booking.nile-cruise-cabins.update', $nile_cruise_cabin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <input type="hidden" name="lang_code" value="{{ $current_lang }}">

                            <div class="row">
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <div class="create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Nile Cruise Cabins') }}</h4>
                                            <a href="{{ dashboard_route('admin.special-booking.nile-cruise-cabins.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.Nile Cruise Cabins') }}</a>
                                        </div>

                                        <div class="row mg-top-30">
                                            {{-- Title (translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                    <input class="crancy__item-input" type="text" name="title" value="{{ old('title', $t->title ?? $nile_cruise_cabin->title) }}" required>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- Image (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                    <input class="crancy__item-input" type="file" name="image" accept="image/*">
                                                    @if($imageUrl = special_booking_image_url($nile_cruise_cabin->image))
                                                        <div class="mg-top-10"><img src="{{ $imageUrl }}" alt="{{ $nile_cruise_cabin->title }}" width="100"></div>
                                                    @elseif($nile_cruise_cabin->image)
                                                        <div class="mg-top-10 d-inline-flex align-items-center justify-content-center rounded bg-light border text-muted" style="width: 100px; height: 62px;"><span class="small">{{ __('translate.No image') }}</span></div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Short Description (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Short Description') }}</label>
                                                    <textarea class="crancy__item-input" name="short_description" rows="3">{{ old('short_description', $t->short_description ?? $nile_cruise_cabin->short_description) }}</textarea>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- Sort Order (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Sort Order') }}</label>
                                                    <input class="crancy__item-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $nile_cruise_cabin->sort_order) }}">
                                                </div>
                                            </div>

                                            {{-- Status (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                                    <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                        <label class="crancy__item-switch">
                                                            <input name="status" type="checkbox" {{ $nile_cruise_cabin->status ? 'checked' : '' }} value="1">
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