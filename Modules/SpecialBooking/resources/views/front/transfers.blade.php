@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Transfers by Request') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Transfers by Request') }}">
    <meta name="description" content="{{ __('translate.Book private transfers and group transportation with professional drivers in Egypt.') }}">
@endsection

@section('front-content')
    <main>
        @php
            $breadcrumb_title = __('translate.Transfers by Request');
        @endphp
        @include('breadcrumb')

        <section class="transfers-page-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-40">
                            <h2 class="title">{{ __('translate.Private and group transportation services') }}</h2>
                            <p>{{ __('translate.We provide reliable and comfortable transportation across Egypt with a modern fleet and professional drivers.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <div class="vehicles-section">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-30">
                                <div>
                                    <h4 class="mb-2">{{ __('translate.Highlights') }}</h4>
                                    <p class="text-muted mb-0">{{ __('translate.Our Fleet Options') }}</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                @forelse($vehicles as $vehicle)
                                    <div class="col-md-6 col-xl-3">
                                        <div class="catalog-card vehicle-card h-100 p-4 bg-white border rounded-4 shadow-sm d-flex flex-column">
                                            <div class="vehicle-card__media mb-3">
                                                @if($imageUrl = special_booking_image_url($vehicle->image))
                                                    <img src="{{ $imageUrl }}" alt="{{ $vehicle->getTranslatedValue('title') }}" class="img-fluid rounded-3">
                                                @elseif($vehicle->icon_class)
                                                    <div class="catalog-card__placeholder catalog-card__placeholder--icon vehicle-card__placeholder">
                                                        <i class="{{ $vehicle->icon_class }}"></i>
                                                        <span>{{ __('translate.Image not available') }}</span>
                                                    </div>
                                                @else
                                                    <div class="catalog-card__placeholder catalog-card__placeholder--icon vehicle-card__placeholder">
                                                        <i class="fas fa-image"></i>
                                                        <span>{{ __('translate.Image not available') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="mb-2">{{ $vehicle->getTranslatedValue('title') }}</h5>
                                            @if($vehicle->short_description)
                                                <p class="text-muted small flex-grow-1 mb-0">{{ $vehicle->getTranslatedValue('short_description') }}</p>
                                            @endif
                                            @if($vehicle->capacity_text)
                                                <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                                    <span class="small font-weight-bold"><i class="fas fa-users text-primary me-1"></i> {{ $vehicle->getTranslatedValue('capacity_text') }}</span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary select-vehicle" data-vehicle="{{ $vehicle->slug }}">
                                                        {{ __('translate.Request This Vehicle') }}
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mt-3 pt-3 border-top d-flex justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-outline-primary select-vehicle" data-vehicle="{{ $vehicle->slug }}">
                                                        {{ __('translate.Request This Vehicle') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state-card p-4 p-lg-5 text-center border rounded-4 bg-light">
                                            <p class="mb-0 text-muted">{{ __('translate.No vehicles available right now') }}</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-12 col-lg-11 col-xl-10">
                        <div class="booking-form-card p-4 p-lg-5 bg-white shadow-sm rounded-4 border-top border-primary border-4">
                            <h4 class="mb-4">{{ __('translate.Request a Transfer') }}</h4>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('special-booking.transfers.request') }}" method="POST" class="request-form" data-request-form>
                                @csrf

                                <div class="request-form__stepper mb-4 mb-lg-5" aria-label="{{ __('translate.Review your details') }}">
                                    <div class="request-form__stepper-item is-active" data-step-indicator="1">
                                        <span class="request-form__stepper-index">1</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 1') }}</strong>
                                            <small>{{ __('translate.Transfer Details') }}</small>
                                        </span>
                                    </div>
                                    <div class="request-form__stepper-divider"></div>
                                    <div class="request-form__stepper-item" data-step-indicator="2">
                                        <span class="request-form__stepper-index">2</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 2') }}</strong>
                                            <small>{{ __('translate.Passengers & Requirements') }}</small>
                                        </span>
                                    </div>
                                    <div class="request-form__stepper-divider"></div>
                                    <div class="request-form__stepper-item" data-step-indicator="3">
                                        <span class="request-form__stepper-index">3</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 3') }}</strong>
                                            <small>{{ __('translate.Contact Details') }}</small>
                                        </span>
                                    </div>
                                </div>

                                <div class="request-form__progress mb-4">
                                    <div class="request-form__progress-bar" data-request-progress></div>
                                </div>

                                <p class="request-form__required mb-4">{{ __('translate.Required fields') }}</p>

                                <div class="request-form__step" data-request-step="1">
                                    <div class="step-card p-4 p-lg-5 rounded-4 border bg-white shadow-sm">
                                        <div class="step-card__header mb-4">
                                            <div>
                                                <span class="step-card__kicker">{{ __('translate.Step 1') }}</span>
                                                <h5 class="mb-2">{{ __('translate.Transfer Details') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12">
                                                <label class="form-label">{{ __('translate.Vehicle Type') }} *</label>
                                                <select name="vehicle_type" id="vehicle_type" class="form-select form-select-lg" required>
                                                    <option value="">{{ __('translate.Select vehicle') }}</option>
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->slug }}" {{ old('vehicle_type') === $vehicle->slug ? 'selected' : '' }}>{{ $vehicle->getTranslatedValue('title') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Pickup Location') }} *</label>
                                                <input type="text" name="pickup_location" class="form-control form-control-lg" placeholder="{{ __('translate.Airport, Hotel, etc.') }}" value="{{ old('pickup_location') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Drop-off Location') }} *</label>
                                                <input type="text" name="dropoff_location" class="form-control form-control-lg" placeholder="{{ __('translate.Destination') }}" value="{{ old('dropoff_location') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Pickup Date') }} *</label>
                                                <input type="date" name="pickup_date" class="form-control form-control-lg" value="{{ old('pickup_date') }}" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Pickup Time') }} *</label>
                                                <input type="time" name="pickup_time" class="form-control form-control-lg" value="{{ old('pickup_time') }}" required>
                                            </div>
                                        </div>

                                        <div class="request-form__actions request-form__actions--single mt-4">
                                            <button type="button" class="btn btn-primary btn-lg px-4 request-form__next">{{ __('translate.Next') }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-form__step d-none" data-request-step="2">
                                    <div class="step-card p-4 p-lg-5 rounded-4 border bg-white shadow-sm">
                                        <div class="step-card__header mb-4">
                                            <div>
                                                <span class="step-card__kicker">{{ __('translate.Step 2') }}</span>
                                                <h5 class="mb-2">{{ __('translate.Passengers & Requirements') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Passengers Count') }} *</label>
                                                <input type="number" name="passengers_count" class="form-control form-control-lg" value="{{ old('passengers_count', 1) }}" min="1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Luggage Count') }}</label>
                                                <input type="number" name="luggage_count" class="form-control form-control-lg" value="{{ old('luggage_count', 1) }}" min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Transfer Type') }} *</label>
                                                <select name="transfer_type" class="form-select form-select-lg" required>
                                                    <option value="one_way" {{ old('transfer_type') == 'one_way' ? 'selected' : '' }}>{{ __('translate.One Way') }}</option>
                                                    <option value="round_trip" {{ old('transfer_type') == 'round_trip' ? 'selected' : '' }}>{{ __('translate.Round Trip') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">{{ __('translate.Airport Transfer') }}</label>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="is_airport_transfer" id="is_airport_transfer" value="1" {{ old('is_airport_transfer') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_airport_transfer">
                                                        {{ __('translate.Airport Transfer') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 flight-number-col {{ old('is_airport_transfer') ? '' : 'd-none' }}">
                                                <label class="form-label">{{ __('translate.Flight Number') }}</label>
                                                <input type="text" name="flight_number" class="form-control form-control-lg" value="{{ old('flight_number') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">{{ __('translate.Notes') }}</label>
                                                <textarea name="notes" class="form-control form-control-lg" rows="4">{{ old('notes') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="request-form__actions mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-lg px-4 request-form__prev">{{ __('translate.Previous') }}</button>
                                            <button type="button" class="btn btn-primary btn-lg px-4 request-form__next">{{ __('translate.Next') }}</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="request-form__step d-none" data-request-step="3">
                                    <div class="step-card p-4 p-lg-5 rounded-4 border bg-white shadow-sm">
                                        <div class="step-card__header mb-4">
                                            <div>
                                                <span class="step-card__kicker">{{ __('translate.Step 3') }}</span>
                                                <h5 class="mb-2">{{ __('translate.Contact Details') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Full Name') }} *</label>
                                                <input type="text" name="full_name" class="form-control form-control-lg" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Email') }} *</label>
                                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Phone') }} *</label>
                                                <input type="text" name="phone" class="form-control form-control-lg" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.WhatsApp') }}</label>
                                                <input type="text" name="whatsapp" class="form-control form-control-lg" value="{{ old('whatsapp') }}">
                                            </div>
                                        </div>

                                        <div class="request-form__actions mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-lg px-4 request-form__prev">{{ __('translate.Previous') }}</button>
                                            <button type="submit" class="btn btn-primary btn-lg px-4">{{ __('translate.Complete Request') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="transfer-highlights transfer-highlights--premium p-4 p-lg-5 rounded-4">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                                <div>
                                    <h4 class="mb-2 text-white">{{ __('translate.Why Book With Us') }}</h4>
                                    <p class="mb-0 text-white-50">{{ __('translate.Highlights') }}</p>
                                </div>
                            </div>

                            <div class="row g-3 g-lg-4">
                                @php
                                    $fallbackHighlightIcons = [
                                        'fas fa-shield-alt',
                                        'fas fa-car',
                                        'fas fa-route',
                                        'fas fa-users',
                                    ];
                                @endphp
                                @forelse($whyBookFeatures as $feature)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="benefit-strip-card h-100">
                                            <div class="benefit-strip-card__icon">
                                                <i class="{{ $feature->icon_class ?: ($fallbackHighlightIcons[$loop->index] ?? 'fas fa-check') }}"></i>
                                            </div>
                                            <div class="benefit-strip-card__body">
                                                <h6 class="mb-2">{{ $feature->getTranslatedValue('title') }}</h6>
                                                @if($feature->short_description)
                                                    <p class="mb-0">{{ $feature->getTranslatedValue('short_description') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    @php
                                        $fallbackHighlights = [
                                            __('translate.Reliable transportation across Egypt'),
                                            __('translate.Modern fleet with professional drivers'),
                                            __('translate.Flexible pickup and drop-off options'),
                                            __('translate.Comfortable transfers for every group size'),
                                        ];
                                    @endphp
                                    @php
                                        $fallbackHighlightIcons = [
                                            'fas fa-shield-alt',
                                            'fas fa-car',
                                            'fas fa-route',
                                            'fas fa-users',
                                        ];
                                    @endphp
                                    @foreach($fallbackHighlights as $highlight)
                                        <div class="col-md-6 col-lg-3">
                                            <div class="benefit-strip-card h-100">
                                                <div class="benefit-strip-card__icon">
                                                    <i class="{{ $fallbackHighlightIcons[$loop->index] ?? 'fas fa-check' }}"></i>
                                                </div>
                                                <div class="benefit-strip-card__body">
                                                    <h6 class="mb-0">{{ $highlight }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('style_section')
<style>
    .catalog-card {
        transition: all 0.3s ease;
    }
    .catalog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08) !important;
        border-color: #c92127 !important;
    }
    .vehicle-card__media {
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .vehicle-card__media img {
        max-height: 120px;
        width: auto;
        object-fit: contain;
    }
    .vehicle-card__placeholder {
        min-height: 140px;
    }
    .booking-form-card {
        position: relative;
        margin: 0 auto;
    }
    .request-form__stepper {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr) auto minmax(0, 1fr);
        gap: 12px;
        align-items: center;
    }
    .request-form__stepper-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 18px;
        border: 1px solid #e9e9e9;
        background: #fff;
        box-shadow: 0 10px 20px rgba(17, 24, 39, 0.04);
    }
    .request-form__stepper-item.is-active {
        border-color: #c92127;
        background: rgba(201, 33, 39, 0.08);
    }
    .request-form__stepper-index {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(201, 33, 39, 0.08);
        color: #c92127;
        font-weight: 700;
        flex: 0 0 36px;
    }
    .request-form__stepper-item.is-active .request-form__stepper-index {
        background: #c92127;
        color: #fff;
    }
    .request-form__stepper-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .request-form__stepper-text strong {
        font-size: 13px;
        color: #111827;
    }
    .request-form__stepper-text small {
        font-size: 12px;
        color: #6b7280;
    }
    .request-form__stepper-divider {
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg, rgba(201,33,39,0.05), rgba(201,33,39,0.45), rgba(201,33,39,0.05));
    }
    .request-form__progress {
        height: 8px;
        background: #eef2f7;
        border-radius: 999px;
        overflow: hidden;
    }
    .request-form__progress-bar {
        height: 100%;
        width: 33.3333%;
        background: linear-gradient(90deg, #c92127, #a9151b);
        border-radius: inherit;
        transition: width 0.25s ease;
    }
    .request-form__required {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 0;
    }
    .step-card {
        border-color: rgba(17, 24, 39, 0.08) !important;
        background: #fff;
    }
    .step-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }
    .step-card__kicker {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(201, 33, 39, 0.08);
        color: #c92127;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .step-card h5 {
        font-size: 22px;
        margin-bottom: 0;
    }
    .request-form__actions {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .request-form__actions--single {
        justify-content: flex-end;
    }
    .request-form--js .request-form__step.d-none {
        display: none !important;
    }
    .transfer-highlights--premium {
        background: linear-gradient(135deg, #c92127 0%, #a9151b 100%);
    }
    .transfer-highlights--premium .benefit-strip-card {
        padding: 18px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #fff;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        height: 100%;
        backdrop-filter: blur(4px);
    }
    .transfer-highlights--premium .benefit-strip-card__icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 42px;
        color: #fff;
    }
    .transfer-highlights--premium .benefit-strip-card__icon i {
        font-size: 18px;
    }
    .transfer-highlights--premium .benefit-strip-card__body h6,
    .transfer-highlights--premium .benefit-strip-card__body p {
        color: #fff;
        margin-bottom: 0;
    }
    .transfer-highlights--premium .benefit-strip-card__body p {
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        line-height: 1.6;
    }
    .form-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    .form-control, .form-select {
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
    }
    .btn-primary {
        background-color: #c92127;
        border-color: #c92127;
    }
    .btn-primary:hover {
        background-color: #a9151b;
        border-color: #a9151b;
    }
    .border-primary {
        border-color: #c92127 !important;
    }
    .vehicle-card .text-primary,
    .transfer-highlights--premium .text-primary {
        color: #c92127 !important;
    }
</style>
@endpush

@push('js_section')
<script>
    $(document).ready(function() {
        var $requestForm = $('[data-request-form]');
        var currentStep = 1;
        var totalSteps = 3;

        if ($requestForm.length) {
            $requestForm.addClass('request-form--js');

            function showStep(step) {
                currentStep = step;
                $requestForm.find('[data-request-step]').addClass('d-none');
                $requestForm.find('[data-request-step="' + step + '"]').removeClass('d-none');

                $requestForm.find('[data-step-indicator]').removeClass('is-active').each(function() {
                    var indicatorStep = parseInt($(this).data('step-indicator'), 10);
                    if (indicatorStep <= step) {
                        $(this).addClass('is-active');
                    }
                });

                $requestForm.find('[data-request-progress]').css('width', (step / totalSteps * 100) + '%');
            }

            $requestForm.on('click', '.request-form__next', function() {
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                }
            });

            $requestForm.on('click', '.request-form__prev', function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });

            showStep(1);
        }

        $('#is_airport_transfer').on('change', function() {
            if ($(this).is(':checked')) {
                $('.flight-number-col').removeClass('d-none');
            } else {
                $('.flight-number-col').addClass('d-none');
            }
        });

        $('.select-vehicle').on('click', function() {
            var vehicleSlug = $(this).data('vehicle');
            $('#vehicle_type').val(vehicleSlug).trigger('change');

            var bookingForm = document.querySelector('.booking-form-card');
            if (bookingForm) {
                bookingForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endpush
