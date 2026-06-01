@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Edit SPA Service') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit SPA Service') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Edit SPA Service') }}</p>
@endsection

@section('body-content')
@php
    $current_lang = $lang_code ?? (function_exists('admin_lang') ? admin_lang() : 'en');
    $default_lang = function_exists('admin_lang') ? admin_lang() : 'en';
    $t = $spa_service->translation;
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
                                                    <a href="{{ dashboard_route('admin.special-booking.spa-services.edit', ['spa_service' => $spa_service->id, 'lang_code' => $language->lang_code]) }}">
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
                        <form action="{{ dashboard_route('admin.special-booking.spa-services.update', $spa_service->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="lang_code" value="{{ $current_lang }}">

                            <div class="row">
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <div class="create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Basic Information') }}</h4>
                                            <a href="{{ dashboard_route('admin.special-booking.spa-services.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.SPA Service List') }}</a>
                                        </div>

                                        <div class="row mg-top-30">
                                            {{-- Title (translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                    <input class="crancy__item-input" type="text" name="title" id="title" value="{{ old('title', $t->title ?? $spa_service->title) }}" required>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- Slug (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Slug') }}</label>
                                                    <input class="crancy__item-input" type="text" name="slug" id="slug" value="{{ old('slug', $spa_service->slug) }}">
                                                </div>
                                            </div>

                                            {{-- Duration (non-translatable) --}}
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Duration (Min)') }} *</label>
                                                    <input class="crancy__item-input" type="number" name="duration_minutes" value="{{ old('duration_minutes', $spa_service->duration_minutes) }}" required>
                                                </div>
                                            </div>

                                            {{-- Price (non-translatable) --}}
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Price') }}</label>
                                                    <input class="crancy__item-input" type="number" step="0.01" name="price" value="{{ old('price', $spa_service->price) }}">
                                                </div>
                                            </div>

                                            {{-- Max Guests (non-translatable) --}}
                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Max Guests') }} *</label>
                                                    <input class="crancy__item-input" type="number" name="max_guests_per_slot" value="{{ old('max_guests_per_slot', $spa_service->max_guests_per_slot) }}" required>
                                                </div>
                                            </div>

                                            {{-- Gender Type (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Gender Type') }} *</label>
                                                    <select class="crancy__item-input" name="gender_type" required>
                                                        <option value="both" {{ old('gender_type', $spa_service->gender_type) == 'both' ? 'selected' : '' }}>{{ __('translate.Both') }}</option>
                                                        <option value="male" {{ old('gender_type', $spa_service->gender_type) == 'male' ? 'selected' : '' }}>{{ __('translate.Male') }}</option>
                                                        <option value="female" {{ old('gender_type', $spa_service->gender_type) == 'female' ? 'selected' : '' }}>{{ __('translate.Female') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Image (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                    <input class="crancy__item-input" type="file" name="image" accept="image/*">
                                                    @if($imageUrl = special_booking_image_url($spa_service->image))
                                                        <div class="mg-top-10">
                                                            <img src="{{ $imageUrl }}" alt="{{ $spa_service->title }}" width="100">
                                                        </div>
                                                    @elseif($spa_service->image)
                                                        <div class="mg-top-10 d-inline-flex align-items-center justify-content-center rounded bg-light border text-muted" style="width: 100px; height: 62px;">
                                                            <span class="small">{{ __('translate.No image') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Price Note (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Price Note') }}</label>
                                                    <input class="crancy__item-input" type="text" name="price_note" value="{{ old('price_note', $t->price_note ?? $spa_service->price_note) }}" placeholder="{{ __('translate.e.g. Price may vary by session type') }}">
                                                </div>
                                            </div>

                                            {{-- Location (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                    <input class="crancy__item-input" type="text" name="location" value="{{ old('location', $t->location ?? $spa_service->location) }}">
                                                </div>
                                            </div>

                                            {{-- Short Description (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Short Description') }}</label>
                                                    <textarea class="crancy__item-input" name="short_description" rows="3">{{ old('short_description', $t->short_description ?? $spa_service->short_description) }}</textarea>
                                                </div>
                                            </div>

                                            {{-- Description (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Description') }} *</label>
                                                    <textarea class="crancy__item-input summernote" name="description" rows="5">{{ old('description', $t->description ?? $spa_service->description) }}</textarea>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- Available Days (non-translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Available Days') }}</label>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ is_array($spa_service->available_days) && in_array($day, $spa_service->available_days) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="day_{{ $day }}">{{ __("translate.$day") }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Sort Order (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Sort Order') }}</label>
                                                    <input class="crancy__item-input" type="number" name="sort_order" value="{{ old('sort_order', $spa_service->sort_order) }}">
                                                </div>
                                            </div>

                                            {{-- Status (non-translatable) --}}
                                            <div class="col-lg-6 col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                                    <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                        <label class="crancy__item-switch">
                                                            <input name="status" type="checkbox" {{ $spa_service->status ? 'checked' : '' }} value="1">
                                                            <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- SEO Section --}}
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <h4 class="crancy-product-card__title">{{ __('translate.SEO Information') }}</h4>
                                        <div class="row mg-top-30">
                                            {{-- Meta Title (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.SEO Title') }}</label>
                                                    <input class="crancy__item-input" type="text" name="meta_title" value="{{ old('meta_title', $t->meta_title ?? $spa_service->meta_title) }}">
                                                </div>
                                            </div>

                                            {{-- Meta Description (translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.SEO Description') }}</label>
                                                    <textarea class="crancy__item-input" name="meta_description" rows="3">{{ old('meta_description', $t->meta_description ?? $spa_service->meta_description) }}</textarea>
                                                </div>
                                            </div>

                                            @if($default_lang == $current_lang)
                                            {{-- SEO Keywords (non-translatable) --}}
                                            <div class="col-12">
                                                <div class="crancy__item-form--group mg-top-form-20">
                                                    <label class="crancy__item-label">{{ __('translate.SEO Keywords') }}</label>
                                                    <input class="crancy__item-input" type="text" name="seo_keywords" value="{{ old('seo_keywords', $spa_service->seo_keywords) }}" placeholder="{{ __('translate.Comma separated keywords') }}">
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

@push('js_section')
    <script src="{{ asset('global/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('global/js/tinymce-override-defaults.js') }}"></script>
    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {
                @if($default_lang == $current_lang)
                $("#title").on("keyup", function(e) {
                    let inputValue = $(this).val();
                    let slug = inputValue.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
                    $("#slug").val(slug);
                });
                @endif

                tinymce.init({
                    selector: '.summernote',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                });
            });
        })(jQuery);
    </script>
@endpush
