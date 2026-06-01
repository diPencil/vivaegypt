@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Itineraries') }} - {{ $service->translation->title ?? $service->title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Itineraries') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Tour Booking') }} >> {{ __('translate.Services') }} >>
        {{ __('translate.Itineraries') }}</p>
@endsection

@push('style_section')
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
    <style>
        .itinerary-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .itinerary-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px;
        }

        .itinerary-card .card-body {
            padding: 20px;
        }

        .itinerary-image {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .itinerary-day-badge {
            font-size: 14px;
            padding: 5px 10px;
            background: #4e73df;
            color: white;
            border-radius: 20px;
            margin-right: 10px;
        }
    </style>
@endpush

@section('body-content')
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
                                                @foreach ($itineraryLocales as $language)
                                                    <li><a
                                                            href="{{ dashboard_route('admin.tourbooking.services.itineraries', ['service' => $service->id, 'lang_code' => $language->lang_code]) }}">
                                                            @if ($lang_code == $language->lang_code)
                                                                <i class="fas fa-eye"></i>
                                                            @else
                                                                <i class="fas fa-edit"></i>
                                                            @endif

                                                            {{ $language->lang_name }}
                                                        </a></li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @php
                                            $edited_language = $itineraryLocales->where('lang_code', $lang_code)->first();
                                        @endphp

                                        <div class="alert alert-secondary mt-3">
                                            <p>{{ __('translate.Your editing mode') }} :
                                                <b>{{ $edited_language?->lang_name ?? $lang_code }}</b></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <div class="create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Itineraries for') }}:
                                                {{ $service->translation->title ?? $service->title }}</h4>
                                            <div>
                                                <a href="{{ dashboard_route('admin.tourbooking.services.edit', ['service' => $service->id, 'lang_code' => admin_lang()]) }}"
                                                    class="crancy-btn"><i class="fa fa-edit"></i>
                                                    {{ __('translate.Edit Service') }}</a>
                                                <a href="{{ dashboard_route('admin.tourbooking.services.index') }}"
                                                    class="crancy-btn"><i class="fa fa-list"></i>
                                                    {{ __('translate.Service List') }}</a>
                                            </div>
                                        </div>

                                        <div class="row mg-top-30">
                                            <div class="col-12">
                                                <div class="accordion" id="itineraryAccordion">
                                                    <div class="accordion-item">
                                                        @if ($lang_code === admin_lang())
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                aria-expanded="true" aria-controls="collapseOne">
                                                                {{ __('translate.Add New Itinerary') }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#itineraryAccordion">
                                                            <div class="accordion-body">
                                                                <form
                                                                    action="{{ dashboard_route('admin.tourbooking.services.itineraries.store', ['service' => $service->id, 'lang_code' => $lang_code]) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="lang_code"
                                                                        value="{{ $lang_code }}">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Title') }}
                                                                                    *</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="text" name="title"
                                                                                    value="{{ old('title') }}" required>
                                                                                @error('title')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-3 col-md-3 col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Day Number') }}
                                                                                    *</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="number" min="1"
                                                                                    name="day_number"
                                                                                    value="{{ old('day_number', $service->itineraries->count() + 1) }}"
                                                                                    required>
                                                                                @error('day_number')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-3 col-md-3 col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Duration') }}</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="text" name="duration"
                                                                                    value="{{ old('duration') }}"
                                                                                    placeholder="e.g. 2 hours, Full day">
                                                                                @error('duration')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Description') }}
                                                                                    *</label>
                                                                                <textarea class="crancy__item-input summernote" name="description" rows="5">{{ old('description') }}</textarea>
                                                                                @error('description')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="file" name="image"
                                                                                    accept="image/*">
                                                                                @error('image')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Meal Included') }}</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="text" name="meal_included"
                                                                                    value="{{ old('meal_included') }}"
                                                                                    placeholder="e.g. Breakfast, Lunch, Dinner">
                                                                                @error('meal_included')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <div
                                                                                class="crancy__item-form--group mg-top-form-20">
                                                                                <label
                                                                                    class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                                                <input class="crancy__item-input"
                                                                                    type="text" name="location"
                                                                                    value="{{ old('location') }}"
                                                                                    placeholder="e.g. Eiffel Tower, Paris">
                                                                                @error('location')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 mg-top-30">
                                                                            <button type="submit"
                                                                                class="crancy-btn">{{ __('translate.Add Itinerary') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        @else
                                                            <div class="accordion-body">
                                                                <div class="alert alert-info mb-0">
                                                                    {{ __('translate.Create itinerary rows in English first, then use this language tab to translate existing itinerary items.') }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mg-top-30">
                                            <div class="col-12">
                                                <h4 class="crancy-product-card__title">
                                                    {{ __('translate.Existing Itineraries') }}</h4>

                                                @if ($service->itineraries->count() > 0)
                                                    @foreach ($service->itineraries->sortBy('day_number') as $itinerary)
                                                        @php
                                                            $itineraryTitle = $itinerary->translated('title', $lang_code);
                                                            $itineraryDescription = $itinerary->translated('description', $lang_code);
                                                            $itineraryLocation = $itinerary->translated('location', $lang_code);
                                                            $itineraryMealIncluded = $itinerary->translated('meal_included', $lang_code);
                                                        @endphp
                                                        <div class="itinerary-card mg-top-20">
                                                            <div
                                                                class="card-header d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span
                                                                        class="itinerary-day-badge">{{ __('translate.Day') }}
                                                                        {{ $itinerary->day_number }}</span>
                                                                    <strong>{{ $itineraryTitle }}</strong>
                                                                    @if ($itinerary->duration)
                                                                        <span
                                                                            class="badge bg-info ms-2">{{ $itinerary->duration }}</span>
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="crancy-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editModal{{ $itinerary->id }}">
                                                                        <i class="fa fa-edit"></i>
                                                                        {{ __('translate.Edit') }}
                                                                    </button>
                                                                    <button type="button"
                                                                        class="crancy-btn delete_danger_btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteModal{{ $itinerary->id }}">
                                                                        <i class="fa fa-trash"></i>
                                                                        {{ __('translate.Delete') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    @if ($itinerary->image)
                                                                        <div class="col-md-3">
                                                                            <img src="{{ asset($itinerary->image) }}"
                                                                                alt="{{ $itineraryTitle }}"
                                                                                class="itinerary-image">
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                        @else
                                                                            <div class="col-12">
                                                                    @endif
                                                                    <div>
                                                                        {!! $itineraryDescription !!}
                                                                    </div>

                                                                    @if ($itineraryLocation)
                                                                        <div class="mt-3">
                                                                            <strong><i class="fa fa-map-marker"></i>
                                                                                {{ __('translate.Location') }}:</strong>
                                                                            {{ $itineraryLocation }}
                                                                        </div>
                                                                    @endif

                                                                    @if ($itineraryMealIncluded)
                                                                        <div class="mt-2">
                                                                            <strong><i class="fa fa-utensils"></i>
                                                                                {{ __('translate.Meal Included') }}:</strong>
                                                                            <span
                                                                                class="badge bg-success">{{ $itineraryMealIncluded }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $itinerary->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $itinerary->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel{{ $itinerary->id }}">
                                                                {{ __('translate.Edit Itinerary') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ dashboard_route('admin.tourbooking.services.itineraries.update', ['itinerary' => $itinerary->id, 'lang_code' => $lang_code]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="lang_code"
                                                                value="{{ $lang_code }}">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-12">
                                                                        <div class="crancy__item-form--group">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Title') }}
                                                                                *</label>
                                                                            <input class="crancy__item-input"
                                                                                type="text" name="title"
                                                                                value="{{ $itineraryTitle }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3 col-md-3 col-12">
                                                                        <div class="crancy__item-form--group">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Day Number') }}
                                                                                *</label>
                                                                            <input class="crancy__item-input"
                                                                                type="number" min="1"
                                                                                name="day_number"
                                                                                value="{{ $itinerary->day_number }}"
                                                                                required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3 col-md-3 col-12">
                                                                        <div class="crancy__item-form--group">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Duration') }}</label>
                                                                            <input class="crancy__item-input"
                                                                                type="text" name="duration"
                                                                                value="{{ $itinerary->duration }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div
                                                                            class="crancy__item-form--group mg-top-form-20">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Description') }}
                                                                                *</label>
                                                                            <textarea class="crancy__item-input summernote" name="description" rows="5">{{ $itineraryDescription }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6 col-md-6 col-12">
                                                                        <div
                                                                            class="crancy__item-form--group mg-top-form-20">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Image') }}</label>
                                                                            @if ($itinerary->image)
                                                                                <div class="mb-2">
                                                                                    <img src="{{ asset($itinerary->image) }}"
                                                                                        alt="{{ $itineraryTitle }}"
                                                                                        style="max-width: 150px; max-height: 100px;"
                                                                                        class="img-thumbnail">
                                                                                </div>
                                                                            @endif
                                                                            <input class="crancy__item-input"
                                                                                type="file" name="image"
                                                                                accept="image/*">
                                                                            <small
                                                                                class="text-muted">{{ __('translate.Leave empty to keep current image') }}</small>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6 col-md-6 col-12">
                                                                        <div
                                                                            class="crancy__item-form--group mg-top-form-20">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Meal Included') }}</label>
                                                                            <input class="crancy__item-input"
                                                                                type="text" name="meal_included"
                                                                                value="{{ $itineraryMealIncluded }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div
                                                                            class="crancy__item-form--group mg-top-form-20">
                                                                            <label
                                                                                class="crancy__item-label">{{ __('translate.Location') }}</label>
                                                                            <input class="crancy__item-input"
                                                                                type="text" name="location"
                                                                                value="{{ $itineraryLocation }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="crancy-btn crancy-btn__default"
                                                                    data-bs-dismiss="modal">{{ __('translate.Cancel') }}</button>
                                                                <button type="submit"
                                                                    class="crancy-btn">{{ __('translate.Update') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $itinerary->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $itinerary->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="deleteModalLabel{{ $itinerary->id }}">
                                                                {{ __('translate.Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('translate.Are you sure you want to delete this itinerary?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="crancy-btn crancy-btn__default"
                                                                data-bs-dismiss="modal">{{ __('translate.Cancel') }}</button>
                                                            <form
                                                                action="{{ dashboard_route('admin.tourbooking.services.itineraries.destroy', [$itinerary->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="crancy-btn delete_danger_btn">{{ __('translate.Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info mg-top-20">
                                                {{ __('translate.No itineraries found. Add your first itinerary using the form above.') }}
                                            </div>
                                            @endif
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
@endsection

@push('js_section')
    <script src="{{ asset('global/select2/select2.min.js') }}"></script>
    <script src="{{ asset('global/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('global/js/tinymce-override-defaults.js') }}"></script>
    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {
                tinymce.init({
                    selector: '.summernote',
                    height: 200,
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                });
            });
        })(jQuery);
    </script>
@endpush
