@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Flights by Request') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Flights by Request') }}">
    <meta name="description" content="{{ __('translate.Request custom flight bookings and get the best deals from top airlines worldwide.') }}">
@endsection

@section('front-content')
    <main>
        @php
            $breadcrumb_title = __('translate.Flights by Request');
        @endphp
        @include('breadcrumb')

        <section class="flights-page-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-40">
                            <h2 class="title">{{ __('translate.Personalized flight booking requests') }}</h2>
                            <p>{{ __('translate.Tell us your destination and preferences, and our team will find the best flight options for you.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <div class="airlines-section">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-30">
                                <div>
                                    <h4 class="mb-2">{{ __('translate.Highlights') }}</h4>
                                    <p class="text-muted mb-0">{{ __('translate.Best Airlines We Work With') }}</p>
                                </div>
                            </div>

                            <div class="row g-4 align-items-stretch text-center">
                                @forelse($airlines as $airline)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="catalog-card airline-card h-100 p-3 p-lg-4 bg-white border rounded-4 shadow-sm">
                                            <div class="catalog-card__media airline-card__media mb-3">
                                                @if($logoUrl = special_booking_image_url($airline->logo))
                                                    <img src="{{ $logoUrl }}" alt="{{ $airline->getTranslatedValue('name') }}" class="img-fluid">
                                                @else
                                                    <div class="catalog-card__placeholder catalog-card__placeholder--icon">
                                                        <i class="fas fa-image"></i>
                                                        <span>{{ __('translate.Image not available') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="mb-2 airline-card__title">{{ $airline->getTranslatedValue('name') }}</h5>
                                            @if($airline->short_description)
                                                <p class="text-muted small mb-0">{{ $airline->getTranslatedValue('short_description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state-card p-4 p-lg-5 text-center border rounded-4 bg-light">
                                            <p class="mb-0 text-muted">{{ __('translate.No airlines available right now') }}</p>
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
                            <h4 class="mb-4">{{ __('translate.Request a Flight') }}</h4>

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

                            <form action="{{ route('special-booking.flights.request') }}" method="POST" class="request-form" data-request-form>
                                @csrf

                                <div class="request-form__stepper mb-4 mb-lg-5" aria-label="{{ __('translate.Review your details') }}">
                                    <div class="request-form__stepper-item is-active" data-step-indicator="1">
                                        <span class="request-form__stepper-index">1</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 1') }}</strong>
                                            <small>{{ __('translate.Trip Details') }}</small>
                                        </span>
                                    </div>
                                    <div class="request-form__stepper-divider"></div>
                                    <div class="request-form__stepper-item" data-step-indicator="2">
                                        <span class="request-form__stepper-index">2</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 2') }}</strong>
                                            <small>{{ __('translate.Travelers & Preferences') }}</small>
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
                                                <h5 class="mb-2">{{ __('translate.Trip Details') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">{{ __('translate.Trip Type') }} *</label>
                                            <div class="d-flex flex-wrap gap-3 request-form__radio-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="trip_type" id="one_way" value="one_way" {{ old('trip_type', 'one_way') == 'one_way' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="one_way">{{ __('translate.One Way') }}</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="trip_type" id="round_trip" value="round_trip" {{ old('trip_type') == 'round_trip' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="round_trip">{{ __('translate.Round Trip') }}</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="trip_type" id="multi_city" value="multi_city" {{ old('trip_type') == 'multi_city' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="multi_city">{{ __('translate.Multi City') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.From City') }} *</label>
                                                <input type="text" name="from_city" class="form-control form-control-lg" placeholder="{{ __('translate.Origin') }}" value="{{ old('from_city') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.To City') }} *</label>
                                                <input type="text" name="to_city" class="form-control form-control-lg" placeholder="{{ __('translate.Destination') }}" value="{{ old('to_city') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Departure Date') }} *</label>
                                                <input type="date" name="departure_date" class="form-control form-control-lg" value="{{ old('departure_date') }}" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6 return-date-col {{ old('trip_type') == 'round_trip' ? '' : 'd-none' }}">
                                                <label class="form-label">{{ __('translate.Return Date') }}</label>
                                                <input type="date" name="return_date" class="form-control form-control-lg" value="{{ old('return_date') }}" min="{{ date('Y-m-d') }}">
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
                                                <h5 class="mb-2">{{ __('translate.Travelers & Preferences') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-4">
                                                <label class="form-label">{{ __('translate.Adults') }}</label>
                                                <input type="number" name="adults" class="form-control form-control-lg" value="{{ old('adults', 1) }}" min="1">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">{{ __('translate.Children') }}</label>
                                                <input type="number" name="children" class="form-control form-control-lg" value="{{ old('children', 0) }}" min="0">
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">{{ __('translate.Infants') }}</label>
                                                <input type="number" name="infants" class="form-control form-control-lg" value="{{ old('infants', 0) }}" min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Travel Class') }} *</label>
                                                <select name="travel_class" class="form-select form-select-lg" required>
                                                    <option value="economy" {{ old('travel_class') == 'economy' ? 'selected' : '' }}>{{ __('translate.Economy') }}</option>
                                                    <option value="premium_economy" {{ old('travel_class') == 'premium_economy' ? 'selected' : '' }}>{{ __('translate.Premium Economy') }}</option>
                                                    <option value="business" {{ old('travel_class') == 'business' ? 'selected' : '' }}>{{ __('translate.Business') }}</option>
                                                    <option value="first" {{ old('travel_class') == 'first' ? 'selected' : '' }}>{{ __('translate.First') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Preferred Airline') }}</label>
                                                <select name="preferred_airline" class="form-select form-select-lg">
                                                    <option value="Any" {{ old('preferred_airline', 'Any') === 'Any' ? 'selected' : '' }}>{{ __('translate.Any') }}</option>
                                                    @foreach($airlines as $airline)
                                                        <option value="{{ $airline->name }}" {{ old('preferred_airline') === $airline->name ? 'selected' : '' }}>{{ $airline->getTranslatedValue('name') }}</option>
                                                    @endforeach
                                                </select>
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
                                            <div class="col-12">
                                                <label class="form-label">{{ __('translate.Notes') }}</label>
                                                <textarea name="notes" class="form-control form-control-lg" rows="4" placeholder="{{ __('translate.Flexible dates, specific budget, etc.') }}">{{ old('notes') }}</textarea>
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
                        <div class="flight-benefits flight-benefits--premium p-4 p-lg-5 rounded-4">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                                <div>
                                    <h4 class="mb-2 text-white">{{ __('translate.Why Book With Us') }}</h4>
                                    <p class="mb-0 text-white-50">{{ __('translate.Highlights') }}</p>
                                </div>
                            </div>

                            <div class="row g-3 g-lg-4 align-items-stretch">
                                @php
                                    $fallbackBenefitIcons = [
                                        'fas fa-tags',
                                        'fas fa-users',
                                        'fas fa-headset',
                                        'fas fa-calendar-check',
                                    ];
                                @endphp
                                @forelse($whyBookFeatures as $feature)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="benefit-strip-card h-100">
                                            <div class="benefit-strip-card__icon">
                                                <i class="{{ $feature->icon_class ?: ($fallbackBenefitIcons[$loop->index] ?? 'fas fa-star') }}"></i>
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
                                        $fallbackBenefits = [
                                            __('translate.Competitive pricing for all classes'),
                                            __('translate.Exclusive group rates and deals'),
                                            __('translate.24/7 travel support and assistance'),
                                            __('translate.Flexible booking and cancellation options'),
                                        ];
                                    @endphp
                                    @php
                                        $fallbackBenefitIcons = [
                                            'fas fa-tags',
                                            'fas fa-users',
                                            'fas fa-headset',
                                            'fas fa-calendar-check',
                                        ];
                                    @endphp
                                    @foreach($fallbackBenefits as $benefit)
                                        <div class="col-md-6 col-lg-3">
                                            <div class="benefit-strip-card h-100">
                                                <div class="benefit-strip-card__icon">
                                                    <i class="{{ $fallbackBenefitIcons[$loop->index] ?? 'fas fa-check' }}"></i>
                                                </div>
                                                <div class="benefit-strip-card__body">
                                                    <h6 class="mb-0">{{ $benefit }}</h6>
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
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08) !important;
        border-color: #c92127 !important;
    }
    .airline-card__media {
        min-height: 88px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .airline-card__media img {
        max-height: 72px;
        width: auto;
        object-fit: contain;
    }
    .catalog-card__placeholder {
        width: 100%;
        min-height: 88px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px dashed rgba(201, 33, 39, 0.25);
        border-radius: 16px;
        color: #c92127;
        background: rgba(201, 33, 39, 0.04);
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        padding: 12px;
    }
    .benefit-strip-card {
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
    .benefit-strip-card__icon {
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
    .benefit-strip-card__icon i {
        font-size: 18px;
    }
    .benefit-strip-card__body h6,
    .benefit-strip-card__body p {
        color: #fff;
        margin-bottom: 0;
    }
    .benefit-strip-card__body p {
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        line-height: 1.6;
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
    .flight-benefits--premium {
        background: linear-gradient(135deg, #c92127 0%, #a9151b 100%);
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
            var oldTripType = $requestForm.find('input[name="trip_type"]:checked').val();
            if (oldTripType === 'round_trip') {
                $('.return-date-col').removeClass('d-none');
                $('input[name="return_date"]').prop('required', true);
            }

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

        $('input[name="trip_type"]').on('change', function() {
            if ($(this).val() == 'round_trip') {
                $('.return-date-col').removeClass('d-none');
                $('input[name="return_date"]').prop('required', true);
            } else {
                $('.return-date-col').addClass('d-none');
                $('input[name="return_date"]').prop('required', false);
            }
        });
    });
</script>
@endpush
