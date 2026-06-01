@extends('layout_inner_page')

@section('title')
    <title>{{ $serviceType->localized_name }} - Viva Egypt Travel</title>
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = $serviceType->localized_name;
        $breadcrumb_parent = __('translate.Our Services');
        $breadcrumb_parent_url = route('front.tourbooking.service-types');
    @endphp
    @include('breadcrumb')

        <section class="service-type-details-area pt-100 pb-100">
            <div class="container">
                <!-- Intro Section -->
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section-title mb-60 text-center">
                            <span class="sub-title" style="color: var(--tg-theme-primary);">{{ __('translate.Our Offerings') }}</span>
                            <h2 class="title font-weight-bold">{{ $serviceType->localized_name }}</h2>
                            @if($serviceType->description)
                                <div class="description mt-20 text-muted">
                                    {!! $serviceType->translation?->description ?? $serviceType->description !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Category Specific Sections -->
                @if($serviceType->slug == 'transfers')
                    <div class="fleet-section mb-80">
                        <div class="row justify-content-center"><div class="col-12 text-center mb-50"><h3 class="font-weight-bold">{{ __('translate.Our Professional Fleet') }}</h3></div></div>
                        <div class="row">
                            @foreach([
                                ['icon' => 'fa-car-side', 'title' => 'Limousine', 'desc' => 'transfer_limousine_desc'],
                                ['icon' => 'fa-van-shuttle', 'title' => 'HIACE', 'desc' => 'transfer_hiace_desc'],
                                ['icon' => 'fa-bus-simple', 'title' => 'Coaster', 'desc' => 'transfer_coaster_desc'],
                                ['icon' => 'fa-bus', 'title' => 'Large Bus', 'desc' => 'transfer_bus_desc']
                            ] as $item)
                                <div class="col-lg-3 col-md-6 mb-30">
                                    <div class="fleet-card p-40 rounded bg-white border text-center shadow-sm h-100 transition-all">
                                        <div class="icon-box mb-25 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(var(--tg-theme-primary-rgb), 0.1);"><i class="fa-solid {{ $item['icon'] }} fa-2x" style="color: var(--tg-theme-primary);"></i></div>
                                        <h4 class="font-weight-bold mb-15">{{ __('translate.' . $item['title']) }}</h4>
                                        <p class="text-muted small mb-0">{{ __('translate.' . $item['desc']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($serviceType->slug == 'hotel-bookings')
                    <div class="hotel-levels-section mb-80">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center mb-50">
                                <h3 class="font-weight-bold">{{ __('translate.Accommodation Levels') }}</h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @foreach([
                                ['stars' => 3, 'title' => 'Standard Comfort', 'desc' => 'hotel_standard_desc'],
                                ['stars' => 5, 'title' => 'Luxury Experience', 'desc' => 'hotel_luxury_desc'],
                                ['stars' => 7, 'title' => 'Ultra Luxury', 'desc' => 'hotel_ultra_luxury_desc']
                            ] as $item)
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-10 mb-30">
                                    <div class="hotel-level-card p-30 rounded bg-white border text-center shadow-sm h-100 transition-all">
                                        <div class="stars mb-15 text-warning">
                                            @for($i=0; $i<$item['stars']; $i++) 
                                                <i class="fa-solid fa-star small"></i> 
                                            @endfor
                                        </div>
                                        <h4 class="font-weight-bold mb-15">{{ __('translate.' . $item['title']) }}</h4>
                                        <p class="text-muted mb-0 small-description">{{ __('translate.' . $item['desc']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($serviceType->slug == 'hajj-umrah')
                    <div class="support-section mb-80">
                        <div class="row justify-content-center"><div class="col-12 text-center mb-50"><h3 class="font-weight-bold">{{ __('translate.Travel Support & Services') }}</h3></div></div>
                        <div class="row">
                            @foreach([
                                ['icon' => 'fa-kaaba', 'title' => 'Guided Rituals', 'desc' => 'support_guided_rituals_desc'],
                                ['icon' => 'fa-hotel', 'title' => 'Haram Proximity', 'desc' => 'support_haram_proximity_desc'],
                                ['icon' => 'fa-passport', 'title' => 'Visa Assistance', 'desc' => 'support_visa_assistance_desc'],
                                ['icon' => 'fa-briefcase-medical', 'title' => 'Medical Support', 'desc' => 'support_medical_support_desc']
                            ] as $item)
                                <div class="col-lg-3 col-md-6 mb-30">
                                    <div class="support-card p-30 rounded bg-white border text-center shadow-sm h-100 transition-all">
                                        <div class="icon-box mb-20 text-primary"><i class="fa-solid {{ $item['icon'] }} fa-3x"></i></div>
                                        <h5 class="font-weight-bold mb-10">{{ __('translate.' . $item['title']) }}</h5>
                                        <p class="text-muted small mb-0">{{ __('translate.' . $item['desc']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($serviceType->slug == 'camping-adventure')
                    <div class="adventure-section mb-80">
                        <div class="row justify-content-center"><div class="col-12 text-center mb-50"><h3 class="font-weight-bold">{{ __('translate.Adventure Highlights') }}</h3></div></div>
                        <div class="row">
                            @foreach([
                                ['icon' => 'fa-tent', 'title' => 'Desert Camping', 'desc' => 'adventure_desert_camping_desc'],
                                ['icon' => 'fa-mountain-sun', 'title' => 'Mountain Trekking', 'desc' => 'adventure_mountain_trekking_desc'],
                                ['icon' => 'fa-person-swimming', 'title' => 'Water Sports', 'desc' => 'adventure_water_sports_desc'],
                                ['icon' => 'fa-fire-burner', 'title' => 'Traditional BBQ', 'desc' => 'adventure_traditional_bbq_desc']
                            ] as $item)
                                <div class="col-lg-3 col-md-6 mb-30">
                                    <div class="adventure-card p-30 rounded bg-white border text-center shadow-sm h-100 transition-all">
                                        <div class="icon-box mb-20" style="color: var(--tg-theme-primary);"><i class="fa-solid {{ $item['icon'] }} fa-2x"></i></div>
                                        <h5 class="font-weight-bold mb-10">{{ __('translate.' . $item['title']) }}</h5>
                                        <p class="text-muted small mb-0">{{ __('translate.' . $item['desc']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($serviceType->slug == 'activities')
                    <div class="activity-section mb-80">
                        <div class="row justify-content-center"><div class="col-12 text-center mb-50"><h3 class="font-weight-bold">{{ __('translate.Featured Activities') }}</h3></div></div>
                        <div class="row">
                            @foreach([
                                ['icon' => 'fa-camera-retro', 'title' => 'Photography Tours', 'desc' => 'activity_photography_desc'],
                                ['icon' => 'fa-utensils', 'title' => 'Culinary Tours', 'desc' => 'activity_culinary_desc'],
                                ['icon' => 'fa-masks-theater', 'title' => 'Cultural Shows', 'desc' => 'activity_cultural_desc'],
                                ['icon' => 'fa-shop', 'title' => 'Bazaar Shopping', 'desc' => 'activity_bazaar_desc']
                            ] as $item)
                                <div class="col-lg-3 col-md-6 mb-30">
                                    <div class="activity-card p-30 rounded bg-white border text-center shadow-sm h-100 transition-all">
                                        <div class="icon-box mb-20" style="color: var(--tg-theme-primary);"><i class="fa-solid {{ $item['icon'] }} fa-2x"></i></div>
                                        <h5 class="font-weight-bold mb-10">{{ __('translate.' . $item['title']) }}</h5>
                                        <p class="text-muted small mb-0">{{ __('translate.' . $item['desc']) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Services Listing Grid -->
                <div class="row">
                    <div class="col-12 mb-40">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-20">
                            <h3 class="font-weight-bold mb-0">{{ __('translate.Available') }} {{ $serviceType->localized_name }}</h3>
                            <a href="{{ route('front.tourbooking.services', ['service_type_id' => $serviceType->id]) }}" class="tg-btn">
                                {{ __('translate.Advanced Filter') }} <i class="fa-solid fa-filter ml-10"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse($services as $service)
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            @include('tourbooking::front.services.services-item-static', ['service' => $service])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-services-card p-60 text-center rounded bg-light border-dashed">
                                <div class="mb-20 opacity-25"><i class="fa-solid fa-magnifying-glass fa-5x"></i></div>
                                <h4 class="mb-15">{{ __('translate.Services are coming soon for') }} {{ $serviceType->localized_name }}</h4>
                                <p class="mb-30 text-muted">{{ __('translate.Our travel experts can still customize a trip for you. Contact us today for a tailor-made experience.') }}</p>
                                <div class="d-flex justify-content-center flex-wrap">
                                    <a href="{{ route('contact-us') }}" class="tg-btn mr-15 mb-10"><i class="fa-regular fa-envelope mr-10"></i> {{ __('translate.Contact Us') }}</a>
                                    <a href="{{ route('front.tourbooking.services') }}" class="tg-btn btn-outline mb-10">{{ __('translate.Explore All Tours') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                @php /** @var \Illuminate\Pagination\LengthAwarePaginator $services */ @endphp
                @if(method_exists($services, 'hasPages') && $services->hasPages())
                    <div class="row mt-40"><div class="col-12"><div class="pagination-wrap">{{ $services->links() }}</div></div></div>
                @endif

                <!-- Footer CTA -->
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="cta-banner-viva shadow-lg mt-80 mb-40">
                            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
                                <div class="cta-text-area text-center text-lg-start mb-20 mb-lg-0 pr-lg-20">
                                    <h3 class="text-white cta-banner-title mb-10">{{ __('translate.Ready to book your') }} {{ $serviceType->localized_name }}?</h3>
                                    <p class="text-white cta-banner-subtitle mb-0">{{ __('translate.Our travel experts are ready to assist you in planning the perfect trip.') }}</p>
                                </div>
                                <div class="cta-btn-area text-center text-lg-end flex-shrink-0">
                                    <a href="{{ route('contact-us') }}" class="btn btn-light text-primary font-weight-bold px-40 py-15 rounded-pill shadow-sm cta-btn">
                                        <i class="fa-regular fa-paper-plane mr-10"></i> {{ __('translate.Inquire Now') }}
                                    </a>
                                </div>
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
    /* Hero Styles */
    .destination-hero-section { overflow: hidden; }
    .destination-hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; transition: transform 0.8s ease; }
    .destination-hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 100%); }
    .destination-hero-content .title { font-size: 56px; line-height: 1.1; }
    .destination-hero-content .description { font-size: 18px; max-width: 600px; }

    /* Cards */
    .bg-primary-light { background-color: rgba(var(--tg-theme-primary-rgb), 0.1); }
    .transition-all { transition: all 0.3s ease; }
    .fleet-card:hover, .hotel-level-card:hover, .support-card:hover, .adventure-card:hover, .activity-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; border-color: var(--tg-theme-primary) !important; }
    
    /* Hotel Level Specific */
    .hotel-level-card {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 260px;
        border-radius: 15px !important;
        border: 1px solid #eee !important;
        padding: 35px 30px !important;
    }
    .hotel-level-card .stars {
        display: flex;
        gap: 4px;
        color: #ffb400 !important;
    }
    .hotel-level-card h4 {
        font-size: 20px;
        margin-top: 10px;
        color: #1a1a1a;
    }
    .hotel-level-card .small-description {
        max-width: 260px;
        margin: 0 auto;
        line-height: 1.6;
        font-size: 14px;
    }

    .icon-box { width: 70px; height: 70px; margin: 0 auto; display: inline-flex; align-items: center; justify-content: center; }

    /* CTA Banner Viva Style */
    .cta-banner-viva {
        position: relative;
        background-color: var(--tg-theme-primary);
        padding: 40px 48px;
        border-radius: 12px;
        overflow: hidden;
        z-index: 1;
    }
    .cta-banner-viva::before {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background-image: url("{{ asset('frontend/assets/img/shape/hill-4.png') }}");
        background-repeat: no-repeat;
        background-position: bottom right;
        background-size: contain;
        opacity: 0.12;
        z-index: -1;
        pointer-events: none;
    }
    .cta-banner-title { font-size: 30px; font-weight: 700; line-height: 1.3; }
    .cta-banner-subtitle { font-size: 16px; opacity: 0.9; line-height: 1.6; }
    .border-dashed { border: 2px dashed #ddd; }

    /* Responsive */
    @media (max-width: 991px) { 
        .destination-hero-content .title { font-size: 40px; } 
        .cta-banner-viva { padding: 32px 32px; }
        .cta-banner-viva::before { opacity: 0.08; width: 220px; }
    }
    @media (max-width: 767px) { 
        .destination-hero-content .title { font-size: 32px; } 
        .destination-hero-content .description { font-size: 16px; } 
        .destination-hero-content { padding-top: 100px; padding-bottom: 80px; } 
        
        .cta-banner-viva { padding: 24px; text-align: center; } 
        .cta-banner-viva::before { display: none; }
        .cta-banner-title { font-size: 24px; }
        .cta-banner-subtitle { font-size: 15px; }
        .cta-btn-area { width: 100%; margin-top: 20px; }
        .cta-btn-area .cta-btn { display: block; width: 100%; }
    }
</style>
@endpush
