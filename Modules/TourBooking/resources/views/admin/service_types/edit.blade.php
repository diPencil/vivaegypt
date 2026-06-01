@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Edit Service Type') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Service Type') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Tour Booking') }} >> {{ __('translate.Edit Service Type') }}</p>
@endsection

@section('body-content')
    @php
        $current_lang = request()->get('lang_code', admin_lang());
    @endphp

    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="row">
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card translation_main_box">
                                        <div class="crancy-customer-filter">
                                            <div
                                                class="crancy-customer-filter__single crancy-customer-filter__single--csearch">
                                                <div class="crancy-header__form crancy-header__form--customer">
                                                    <h4 class="crancy-product-card__title">
                                                        {{ __('translate.Switch to language translation') }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="translation_box">
                                            <ul>
                                                @foreach ($language_list as $language)
                                                    <li>
                                                        <a
                                                            href="{{ dashboard_route('admin.tourbooking.service-types.edit', ['service_type' => $serviceType->id, 'lang_code' => $language->lang_code]) }}">
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
                                                @php
                                                    $edited_language = $language_list
                                                        ->where('lang_code', $current_lang)
                                                        ->first();
                                                @endphp
                                                <p>{{ __('translate.Your editing mode') }} :
                                                    <b>{{ $edited_language?->lang_name ?? $current_lang }}</b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <form action="{{ dashboard_route('admin.tourbooking.service-types.update', [$serviceType->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="lang_code" value="{{ $current_lang }}">

                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <div class="crancy-product-card">
                                            <div class="create_new_btn_inline_box">
                                                <h4 class="crancy-product-card__title">{{ __('translate.Edit Service Type') }}
                                                </h4>

                                                <a href="{{ dashboard_route('admin.tourbooking.service-types.index') }}"
                                                    class="crancy-btn "><i class="fa fa-list"></i>
                                                    {{ __('translate.Service Type List') }}</a>
                                            </div>

                                            <div class="row mg-top-30">
                                                <div class="col-12 col-md-6">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Name') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input class="crancy__item-input" type="text" name="name"
                                                            id="name" required
                                                            value="{{ old('name', $serviceType->translation->name ?? $serviceType->name) }}">
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                @if (admin_lang() == $current_lang)
                                                    <div class="col-12 col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Slug') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="crancy__item-input" type="text" name="slug"
                                                                id="slug" required
                                                                value="{{ old('slug', $serviceType->slug) }}">
                                                            @error('slug')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-12">
                                                    <div class="crancy__item-form--group mg-top-form-20">
                                                        <label class="crancy__item-label">{{ __('translate.Description') }}</label>
                                                        <textarea
                                                            class="crancy__item-input crancy__item-textarea summernote"
                                                            name="description"
                                                            rows="3">{!! clean(html_decode(old('description', $serviceType->translation->description ?? $serviceType->description))) !!}</textarea>
                                                        @error('description')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                @if (admin_lang() == $current_lang)
                                                    <div class="col-12 col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Icon Class') }}
                                                                <span class="text-muted">(e.g. fa fa-hotel)</span></label>
                                                            <input class="crancy__item-input" type="text" name="icon"
                                                                value="{{ old('icon', $serviceType->icon) }}">
                                                            @error('icon')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="crancy__item-form--group mg-top-form-20">
                                                            <label class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                            <input class="crancy__item-input" type="file" name="image"
                                                                accept="image/*">
                                                            @error('image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                            @if ($serviceType->image)
                                                                <div class="mt-2">
                                                                    <img src="{{ asset($serviceType->image) }}"
                                                                        alt="{{ $serviceType->name }}"
                                                                        style="max-width: 100px; max-height: 100px;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4 mg-top-form-20">
                                                        <div class="crancy__item-form--group">
                                                            <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                                            <div class="crancy-ptabs__notify-switch">
                                                                <label class="crancy__item-switch">
                                                                    <input name="status" type="checkbox"
                                                                        {{ $serviceType->status ? 'checked' : '' }}>
                                                                    <span
                                                                        class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4 mg-top-form-20">
                                                        <div class="crancy__item-form--group">
                                                            <label
                                                                class="crancy__item-label">{{ __('translate.Featured') }}</label>
                                                            <div class="crancy-ptabs__notify-switch">
                                                                <label class="crancy__item-switch">
                                                                    <input name="is_featured" type="checkbox"
                                                                        {{ $serviceType->is_featured ? 'checked' : '' }}>
                                                                    <span
                                                                        class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4 mg-top-form-20">
                                                        <div class="crancy__item-form--group">
                                                            <label
                                                                class="crancy__item-label">{{ __('translate.Show on Homepage') }}</label>
                                                            <div class="crancy-ptabs__notify-switch">
                                                                <label class="crancy__item-switch">
                                                                    <input name="show_on_homepage" type="checkbox"
                                                                        {{ $serviceType->show_on_homepage ? 'checked' : '' }}>
                                                                    <span
                                                                        class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <button class="crancy-btn mg-top-25"
                                                type="submit">{{ __('translate.Update') }}</button>

                                        </div>
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
                @if (admin_lang() == $current_lang)
                    $("#name").on("keyup", function(e) {
                        let inputValue = $(this).val();
                        let slug = inputValue.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
                        $("#slug").val(slug);
                    });
                @endif
            });
            tinymce.init({
                selector: '.summernote',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [{
                        value: 'First.Name',
                        title: 'First Name'
                    },
                    {
                        value: 'Email',
                        title: 'Email'
                    },
                ]
            });
        })(jQuery);
    </script>
@endpush
