@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Create SPA Service') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Create SPA Service') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Create SPA Service') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ dashboard_route('admin.special-booking.spa-services.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Basic Information') }}</h4>
                                                <a href="{{ dashboard_route('admin.special-booking.spa-services.index') }}" class="crancy-btn"><i class="fa fa-list"></i> {{ __('translate.SPA Service List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Title') }} *</label>
                                                        <input class="crancy__item-input" type="text" name="title" id="title" value="{{ old('title') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Slug') }}</label>
                                                        <input class="crancy__item-input" type="text" name="slug" id="slug" value="{{ old('slug') }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Duration (Min)') }} *</label>
                                                        <input class="crancy__item-input" type="number" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Price') }}</label>
                                                        <input class="crancy__item-input" type="number" step="0.01" name="price" value="{{ old('price') }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Max Guests') }} *</label>
                                                        <input class="crancy__item-input" type="number" name="max_guests_per_slot" value="{{ old('max_guests_per_slot', 1) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Gender Type') }} *</label>
                                                        <select class="crancy__item-input" name="gender_type" required>
                                                            <option value="both" {{ old('gender_type') == 'both' ? 'selected' : '' }}>{{ __('translate.Both') }}</option>
                                                            <option value="male" {{ old('gender_type') == 'male' ? 'selected' : '' }}>{{ __('translate.Male') }}</option>
                                                            <option value="female" {{ old('gender_type') == 'female' ? 'selected' : '' }}>{{ __('translate.Female') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                        <input class="crancy__item-input" type="file" name="image" accept="image/*">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Price Note') }}</label>
                                                        <input class="crancy__item-input" type="text" name="price_note" value="{{ old('price_note') }}" placeholder="{{ __('translate.e.g. Price may vary by session type') }}">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Short Description') }}</label>
                                                        <textarea class="crancy__item-input" name="short_description" rows="3">{{ old('short_description') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }} *</label>
                                                        <textarea class="crancy__item-input summernote" name="description" rows="5">{{ old('description') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Available Days') }}</label>
                                                        <div class="d-flex flex-wrap gap-3">
                                                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $day }}" id="day_{{ $day }}" checked>
                                                                    <label class="form-check-label" for="day_{{ $day }}">{{ __("translate.$day") }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Sort Order') }}</label>
                                                        <input class="crancy__item-input" type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                                        <div class="crancy-ptabs__notify-switch crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                                <input name="status" type="checkbox" checked value="1">
                                                                <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.SEO Information') }}</h4>
                                            <div class="row mg-top-30">
                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.SEO Title') }}</label>
                                                        <input class="crancy__item-input" type="text" name="meta_title" value="{{ old('meta_title') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.SEO Description') }}</label>
                                                        <textarea class="crancy__item-input" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.SEO Keywords') }}</label>
                                                        <input class="crancy__item-input" type="text" name="seo_keywords" value="{{ old('seo_keywords') }}" placeholder="{{ __('translate.Comma separated keywords') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mg-top-30">
                                        <button class="crancy-btn" type="submit">{{ __('translate.Save') }}</button>
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
                $("#title").on("keyup", function(e) {
                    let inputValue = $(this).val();
                    let slug = inputValue.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
                    $("#slug").val(slug);
                });

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
