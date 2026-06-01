@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Nile Cruises') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Nile Cruises') }}">
    <meta name="description" content="{{ __('translate.Discover the magic of the Nile with our luxury cruise packages between Luxor and Aswan.') }}">
@endsection

@section('front-content')
    <main>
        @php
            $breadcrumb_title = __('translate.Nile Cruises');
        @endphp
        @include('breadcrumb')

        <section class="nile-cruise-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Experience the Nile -->
                        <div class="section-title mb-40">
                            <h2 class="title">{{ __('translate.Experience the Nile') }}</h2>
                            <p>{{ __('translate.A Nile cruise is the quintessential Egyptian experience, combining luxury relaxation with the discovery of ancient wonders along the riverbanks.') }}</p>
                        </div>

                        <!-- Popular Routes -->
                        <div class="routes-section mb-60">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-30">
                                <div>
                                    <h4 class="mb-2">{{ __('translate.Popular Routes') }}</h4>
                                    <p class="text-muted mb-0">{{ __('translate.Highlights') }}</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                @forelse($routes as $nileRoute)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="catalog-card route-card h-100 p-4 bg-white rounded-4 border shadow-sm">
                                            <div class="route-card__media mb-3">
                                                @if($imageUrl = special_booking_image_url($nileRoute->image))
                                                    <img src="{{ $imageUrl }}" alt="{{ $nileRoute->getTranslatedValue('title') }}" class="img-fluid rounded-3">
                                                @else
                                                    <div class="catalog-card__placeholder catalog-card__placeholder--icon route-card__placeholder">
                                                        <i class="fas fa-image"></i>
                                                        <span>{{ __('translate.Image not available') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="text-primary mb-2">{{ $nileRoute->getTranslatedValue('title') }}</h5>
                                            @if($nileRoute->getTranslatedValue('badge_text'))
                                                <span class="badge bg-secondary mb-3">{{ $nileRoute->getTranslatedValue('badge_text') }}</span>
                                            @endif
                                            @if($nileRoute->short_description)
                                                <p class="small text-muted mb-0">{{ $nileRoute->getTranslatedValue('short_description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state-card p-4 p-lg-5 text-center border rounded-4 bg-light">
                                            <p class="mb-0 text-muted">{{ __('translate.No Nile cruise routes available right now') }}</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Cabin Options -->
                        <div class="cabins-section mb-60">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-30">
                                <div>
                                    <h4 class="mb-2">{{ __('translate.Cabin Options') }}</h4>
                                    <p class="text-muted mb-0">{{ __('translate.Highlights') }}</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                @forelse($cabins as $nileCabin)
                                    <div class="col-md-6">
                                        <div class="catalog-card cabin-card h-100 p-4 rounded-4 bg-white border shadow-sm">
                                            <div class="cabin-card__media mb-3">
                                                @if($imageUrl = special_booking_image_url($nileCabin->image))
                                                    <img src="{{ $imageUrl }}" alt="{{ $nileCabin->getTranslatedValue('title') }}" class="img-fluid rounded-3">
                                                @else
                                                    <div class="catalog-card__placeholder catalog-card__placeholder--icon cabin-card__placeholder">
                                                        <i class="fas fa-image"></i>
                                                        <span>{{ __('translate.Image not available') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <h6 class="font-weight-bold">{{ $nileCabin->getTranslatedValue('title') }}</h6>
                                            @if($nileCabin->short_description)
                                                <p class="small text-muted mb-0">{{ $nileCabin->getTranslatedValue('short_description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-state-card p-4 p-lg-5 text-center border rounded-4 bg-light">
                                            <p class="mb-0 text-muted">{{ __('translate.No cabin options available right now') }}</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- What is included -->
                        <div class="included-section mb-60">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-30">
                                <div>
                                    <h4 class="mb-2">{{ __('translate.Highlights') }}</h4>
                                    <p class="text-muted mb-0">{{ __('translate.What Can Be Included') }}</p>
                                </div>
                            </div>

                            <div class="row g-3 g-lg-4">
                                @php
                                    $inclusionFallbackIcons = [
                                        'fas fa-bed',
                                        'fas fa-map',
                                        'fas fa-ticket-alt',
                                        'fas fa-music',
                                        'fas fa-shuttle-van',
                                        'fas fa-user-graduate',
                                    ];
                                @endphp
                                @forelse($inclusionFeatures as $feature)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="nile-highlight-card h-100">
                                            <div class="nile-highlight-card__icon">
                                                <i class="{{ $feature->icon_class ?: ($inclusionFallbackIcons[$loop->index] ?? 'fas fa-check') }}"></i>
                                            </div>
                                            <div class="nile-highlight-card__body">
                                                <h6 class="mb-2">{{ $feature->getTranslatedValue('title') }}</h6>
                                                @if($feature->short_description)
                                                    <p class="mb-0">{{ $feature->getTranslatedValue('short_description') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    @php
                                        $fallbackInclusions = [
                                            __('translate.Full Board Accommodation'),
                                            __('translate.Guided Sightseeing Tours'),
                                            __('translate.Entrance Fees to Monuments'),
                                            __('translate.Evening Entertainment'),
                                            __('translate.Airport/Train Transfers'),
                                            __('translate.Professional Egyptologist Guide'),
                                        ];
                                    @endphp
                                    @php
                                        $fallbackInclusionIcons = [
                                            'fas fa-bed',
                                            'fas fa-map',
                                            'fas fa-ticket-alt',
                                            'fas fa-music',
                                            'fas fa-shuttle-van',
                                            'fas fa-user-graduate',
                                        ];
                                    @endphp
                                    @foreach($fallbackInclusions as $inclusion)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="nile-highlight-card h-100">
                                                <div class="nile-highlight-card__icon">
                                                    <i class="{{ $fallbackInclusionIcons[$loop->index] ?? 'fas fa-check' }}"></i>
                                                </div>
                                                <div class="nile-highlight-card__body">
                                                    <h6 class="mb-0">{{ $inclusion }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforelse
                            </div>
                        </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-12 col-lg-11 col-xl-10">
                        <div class="booking-form-card p-4 p-lg-5 bg-white shadow-sm rounded-4 border-top border-primary border-4">
                            <h4 class="mb-4">{{ __('translate.Request a Cruise') }}</h4>

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

                            <form action="{{ route('special-booking.nile-cruises.request') }}" method="POST" class="request-form" data-request-form>
                                @csrf

                                <div class="request-form__stepper mb-4 mb-lg-5" aria-label="{{ __('translate.Review your details') }}">
                                    <div class="request-form__stepper-item is-active" data-step-indicator="1">
                                        <span class="request-form__stepper-index">1</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 1') }}</strong>
                                            <small>{{ __('translate.Cruise Details') }}</small>
                                        </span>
                                    </div>
                                    <div class="request-form__stepper-divider"></div>
                                    <div class="request-form__stepper-item" data-step-indicator="2">
                                        <span class="request-form__stepper-index">2</span>
                                        <span class="request-form__stepper-text">
                                            <strong>{{ __('translate.Step 2') }}</strong>
                                            <small>{{ __('translate.Guests & Cabins') }}</small>
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
                                                <h5 class="mb-2">{{ __('translate.Cruise Details') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-12">
                                                <label class="form-label">{{ __('translate.Route') }} *</label>
                                                <select name="route" class="form-select form-select-lg" required>
                                                    <option value="">{{ __('translate.Select route') }}</option>
                                                    @foreach($routes as $nileRoute)
                                                        <option value="{{ $nileRoute->title }}" {{ old('route') === $nileRoute->title ? 'selected' : '' }}>{{ $nileRoute->getTranslatedValue('title') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Check-in Date') }} *</label>
                                                <input type="date" name="checkin_date" class="form-control form-control-lg" value="{{ old('checkin_date') }}" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Nights Count') }} *</label>
                                                <input type="number" name="nights_count" class="form-control form-control-lg" value="{{ old('nights_count', 3) }}" min="1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Cabin Type') }}</label>
                                                <select name="cabin_type" class="form-select form-select-lg">
                                                    <option value="">{{ __('translate.Select cabin') }}</option>
                                                    @foreach($cabins as $nileCabin)
                                                        <option value="{{ $nileCabin->title }}" {{ old('cabin_type') === $nileCabin->title ? 'selected' : '' }}>{{ $nileCabin->getTranslatedValue('title') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Budget Range') }}</label>
                                                <select name="budget_range" class="form-select form-select-lg">
                                                    <option value="economy" {{ old('budget_range') == 'economy' ? 'selected' : '' }}>{{ __('translate.Economy (3-4 Stars)') }}</option>
                                                    <option value="luxury" {{ old('budget_range', 'luxury') == 'luxury' ? 'selected' : '' }}>{{ __('translate.Luxury (5 Stars)') }}</option>
                                                    <option value="ultra_luxury" {{ old('budget_range') == 'ultra_luxury' ? 'selected' : '' }}>{{ __('translate.Ultra Luxury (Premium)') }}</option>
                                                </select>
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
                                                <h5 class="mb-2">{{ __('translate.Guests & Cabins') }}</h5>
                                                <p class="text-muted mb-0">{{ __('translate.Review your details') }}</p>
                                            </div>
                                        </div>

                                        <div class="row g-3 g-lg-4">
                                            <div class="col-6">
                                                <label class="form-label">{{ __('translate.Adults') }} *</label>
                                                <input type="number" name="adults" class="form-control form-control-lg" value="{{ old('adults', 1) }}" min="1" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">{{ __('translate.Children') }}</label>
                                                <input type="number" name="children" class="form-control form-control-lg" value="{{ old('children', 0) }}" min="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('translate.Cabins Count') }} *</label>
                                                <input type="number" name="cabins_count" class="form-control form-control-lg" value="{{ old('cabins_count', 1) }}" min="1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">{{ __('translate.Need Airport Transfer') }}</label>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="need_airport_transfer" id="need_airport_transfer" value="1" {{ old('need_airport_transfer') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="need_airport_transfer">
                                                        {{ __('translate.Need Airport Transfer') }}
                                                    </label>
                                                </div>
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
                        <!-- Why Viva -->
                        <div class="why-viva why-viva--premium p-4 p-lg-5 text-white rounded-4">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                                <div>
                                    <h4 class="mb-2 text-white">{{ __('translate.Why Book With Us') }}</h4>
                                    <p class="mb-0 text-white-50">{{ __('translate.Why Book with VivaEgyptTravel') }}</p>
                                </div>
                            </div>

                            <div class="row g-3 g-lg-4">
                                @php
                                    $whyBookFallbackIcons = [
                                        'fas fa-award',
                                        'fas fa-ship',
                                        'fas fa-user-check',
                                    ];
                                @endphp
                                @forelse($whyBookFeatures as $feature)
                                    <div class="col-md-4">
                                        <div class="benefit-strip-card h-100">
                                            <div class="benefit-strip-card__icon">
                                                <i class="{{ $feature->icon_class ?: ($whyBookFallbackIcons[$loop->index] ?? 'fas fa-award') }}"></i>
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
                                        $fallbackWhyBook = [
                                            __('translate.Best Price Guarantee'),
                                            __('translate.Handpicked Ships'),
                                            __('translate.Trusted Local Experts'),
                                        ];
                                    @endphp
                                    @php
                                        $fallbackWhyBookIcons = [
                                            'fas fa-award',
                                            'fas fa-ship',
                                            'fas fa-user-check',
                                        ];
                                    @endphp
                                    @foreach($fallbackWhyBook as $item)
                                        <div class="col-md-4">
                                            <div class="benefit-strip-card h-100">
                                                <div class="benefit-strip-card__icon">
                                                    <i class="{{ $fallbackWhyBookIcons[$loop->index] ?? 'fas fa-award' }}"></i>
                                                </div>
                                                <div class="benefit-strip-card__body">
                                                    <h6 class="mb-0">{{ $item }}</h6>
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
    .route-card__media,
    .cabin-card__media {
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .route-card__media img,
    .cabin-card__media img {
        max-height: 180px;
        width: 100%;
        object-fit: cover;
    }
    .route-card__placeholder,
    .cabin-card__placeholder {
        min-height: 180px;
    }
    .included-section .nile-highlight-card {
        padding: 18px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid rgba(201, 33, 39, 0.14);
        box-shadow: 0 12px 30px rgba(17, 24, 39, 0.05);
        display: flex;
        gap: 14px;
        align-items: flex-start;
        height: 100%;
    }
    .included-section .nile-highlight-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(201, 33, 39, 0.08);
        color: #c92127;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
    }
    .included-section .nile-highlight-card__icon i {
        font-size: 16px;
    }
    .included-section .nile-highlight-card__body h6 {
        color: #111827;
        margin-bottom: 0;
    }
    .included-section .nile-highlight-card__body p {
        color: #6b7280;
        font-size: 13px;
        line-height: 1.6;
    }
    .why-viva--premium,
    .transfer-highlights--premium {
        background: linear-gradient(135deg, #c92127 0%, #a9151b 100%);
    }
    .why-viva--premium .benefit-strip-card,
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
    .why-viva--premium .benefit-strip-card__icon,
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
    .why-viva--premium .benefit-strip-card__icon i,
    .transfer-highlights--premium .benefit-strip-card__icon i {
        font-size: 18px;
    }
    .why-viva--premium .benefit-strip-card__body h6,
    .why-viva--premium .benefit-strip-card__body p,
    .transfer-highlights--premium .benefit-strip-card__body h6,
    .transfer-highlights--premium .benefit-strip-card__body p {
        color: #fff;
        margin-bottom: 0;
    }
    .why-viva--premium .benefit-strip-card__body p,
    .transfer-highlights--premium .benefit-strip-card__body p {
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
    .route-card .text-primary {
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
    });
</script>
@endpush
