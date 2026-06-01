@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.SPA') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.SPA') }}">
    <meta name="description" content="{{ __('translate.Experience the ultimate relaxation with our luxury SPA services in Egypt.') }}">
@endsection

@section('front-content')
    <main>
        @php
            $breadcrumb_title = __('translate.SPA');
        @endphp
        @include('breadcrumb')

        <section class="spa-page-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-40">
                            <h2 class="title">{{ __('translate.Luxury Spa Experience') }}</h2>
                            <p>{{ __('translate.Relaxing Spa Services') }}</p>
                        </div>

                        @if($services->isNotEmpty())
                            <div class="row g-4 mb-5">
                                @foreach($services as $service)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="spa-service-card shadow-sm border-0 h-100">
                                            <div class="spa-service-img">
                                                @if($imageUrl = special_booking_image_url($service->image, asset('frontend/assets/img/special-booking/spa.png')))
                                                    <img src="{{ $imageUrl }}" alt="{{ $service->getTranslatedValue('title') }}" class="img-fluid">
                                                @else
                                                    <img src="{{ asset('frontend/assets/img/special-booking/spa.png') }}" alt="{{ $service->getTranslatedValue('title') }}" class="img-fluid">
                                                @endif
                                            </div>
                                            <div class="spa-service-body p-4">
                                                <h4 class="title mb-2">{{ $service->getTranslatedValue('title') }}</h4>
                                                <p class="text-muted small mb-3">{{ $service->getTranslatedValue('short_description') }}</p>
                                                <div class="spa-meta mb-3">
                                                    <span><i class="far fa-clock text-primary"></i> {{ $service->duration_minutes }} {{ __('translate.Minutes') }}</span>
                                                    @if($service->price)
                                                        <span class="ms-3"><i class="fas fa-tag text-primary"></i> {{ currency($service->price) }}</span>
                                                    @endif
                                                </div>
                                                @if($service->getTranslatedValue('price_note'))
                                                    <p class="small text-info mb-3"><i class="fas fa-info-circle"></i> {{ $service->getTranslatedValue('price_note') }}</p>
                                                @endif
                                                <div class="spa-availability mb-4">
                                                    <h6 class="small font-weight-bold mb-1">{{ __('translate.Available Days') }}:</h6>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @if($service->available_days)
                                                            @foreach($service->available_days as $day)
                                                                <span class="badge bg-light text-dark border">{{ __("translate.$day") }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary w-100 select-spa-service" data-id="{{ $service->id }}" data-title="{{ $service->getTranslatedValue('title') }}">
                                                    {{ __('translate.Book Now') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($services->isNotEmpty())
                            <div class="row justify-content-center mt-5">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div id="spa-booking-form" class="booking-form-card p-4 p-lg-5 bg-white shadow-sm rounded-4">
                                        <h4 class="mb-4 border-bottom pb-2">{{ __('translate.Book Your Session') }}</h4>

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

                                        <form action="{{ route('special-booking.spa.book') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('translate.Select Service') }} *</label>
                                                <select name="spa_service_id" id="spa_service_id" class="form-select" required>
                                                    <option value="">{{ __('translate.Choose a service') }}</option>
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}" {{ old('spa_service_id') == $service->id ? 'selected' : '' }}>{{ $service->getTranslatedValue('title') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.Preferred Date') }} *</label>
                                                    <input type="date" name="preferred_date" class="form-control" value="{{ old('preferred_date') }}" min="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.Preferred Time') }} *</label>
                                                    <input type="time" name="preferred_time" class="form-control" value="{{ old('preferred_time') }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.Guests Count') }} *</label>
                                                    <input type="number" name="guests_count" class="form-control" value="{{ old('guests_count', 1) }}" min="1" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.Gender Type') }} *</label>
                                                    <select name="gender_type" class="form-select" required>
                                                        <option value="both" {{ old('gender_type') == 'both' ? 'selected' : '' }}>{{ __('translate.Both') }}</option>
                                                        <option value="male" {{ old('gender_type') == 'male' ? 'selected' : '' }}>{{ __('translate.Male') }}</option>
                                                        <option value="female" {{ old('gender_type') == 'female' ? 'selected' : '' }}>{{ __('translate.Female') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('translate.Full Name') }} *</label>
                                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('translate.Email') }} *</label>
                                                <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.Phone') }} *</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translate.WhatsApp') }}</label>
                                                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">{{ __('translate.Notes') }}</label>
                                                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100 py-2">{{ __('translate.Submit Request') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-0 text-center py-4 mt-5">
                                <h5 class="mb-2">{{ __('translate.No SPA services are available right now.') }}</h5>
                            </div>
                        @endif

                        <div class="spa-why-book why-viva--premium p-4 p-lg-5 text-white rounded-4 mt-4">
                            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                                <div>
                                    <h4 class="mb-2 text-white">{{ __('translate.Why Book With Us') }}</h4>
                                    <p class="mb-0 text-white-50">{{ __('translate.Highlights') }}</p>
                                </div>
                            </div>

                            <div class="row g-3 g-lg-4">
                                @php
                                    $spaWhyBookItems = [
                                        ['text' => __('translate.Relaxing premium experience'), 'icon' => 'fas fa-spa'],
                                        ['text' => __('translate.Professional spa specialists'), 'icon' => 'fas fa-hands-helping'],
                                        ['text' => __('translate.Flexible booking times'), 'icon' => 'fas fa-clock'],
                                        ['text' => __('translate.Clean and comfortable environment'), 'icon' => 'fas fa-shield-alt'],
                                    ];
                                @endphp
                                @foreach($spaWhyBookItems as $item)
                                    <div class="col-md-6 col-lg-3">
                                        <div class="benefit-strip-card h-100">
                                            <div class="benefit-strip-card__icon">
                                                <i class="{{ $item['icon'] }}"></i>
                                            </div>
                                            <div class="benefit-strip-card__body">
                                                <h6 class="mb-0">{{ $item['text'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
    .spa-service-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: #fff;
    }
    .spa-service-card:hover {
        transform: translateY(-5px);
    }
    .spa-service-img img {
        height: 200px;
        width: 100%;
        object-fit: cover;
    }
    .spa-meta span {
        font-size: 13px;
        font-weight: 600;
    }
    .booking-form-card {
        position: relative;
        margin: 0 auto;
    }
    .spa-why-book {
        background: linear-gradient(135deg, #c92127 0%, #a9151b 100%);
    }
    .spa-why-book .benefit-strip-card {
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
    .spa-why-book .benefit-strip-card__icon {
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
    .spa-why-book .benefit-strip-card__icon i {
        font-size: 18px;
    }
    .spa-why-book .benefit-strip-card__body h6,
    .spa-why-book .benefit-strip-card__body p {
        color: #fff;
        margin-bottom: 0;
    }
    .spa-why-book .benefit-strip-card__body p {
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
    .spa-service-card .text-primary {
        color: #c92127 !important;
    }
</style>
@endpush

@push('js_section')
<script>
    $(document).ready(function() {
        $('.select-spa-service').on('click', function() {
            var serviceId = $(this).data('id');
            $('#spa_service_id').val(serviceId);
            $('html, body').animate({
                scrollTop: $('#spa-booking-form').offset().top - 120
            }, 500);
        });
    });
</script>
@endpush
