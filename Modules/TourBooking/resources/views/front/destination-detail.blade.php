@extends('layout_inner_page')

@section('title')
    <title>{{ $destination->localized_name }} - {{ __('translate.Destinations') }}</title>
    <meta name="title" content="{{ $destination->meta_title ?? $destination->localized_name }}">
    <meta name="description" content="{{ $destination->meta_description ?? strip_tags($destination->description) }}">
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = $destination->localized_name;
        $breadcrumb_parent = __('translate.Destinations');
        $breadcrumb_parent_url = route('front.tourbooking.destinations');
    @endphp
    @include('breadcrumb')

        <!-- Destination Main Content Area -->
        <section class="destination-details-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="destination-main-wrapper mr-20">
                            <!-- About Section -->
                            <div class="content-section mb-60">
                                <div class="section-title mb-30">
                                    <span class="sub-title text-primary">{{ __('translate.Discover') }}</span>
                                    <h2 class="title font-weight-bold">{{ __('translate.About') }} {{ $destination->localized_name }}</h2>
                                </div>
                                <div class="rich-text-content">
                                    {!! $destination->translation?->description ?? $destination->description !!}
                                </div>
                            </div>

                            <!-- Highlights / Experiences -->
                            @if($destination->tags)
                                <div class="content-section mb-60">
                                    <h3 class="section-title-two mb-30 font-weight-bold">{{ __('translate.Top Experiences & Highlights') }}</h3>
                                    <div class="experience-grid row">
                                        @foreach(explode(',', $destination->tags) as $tag)
                                            <div class="col-md-6 mb-20">
                                                <div class="experience-card p-25 rounded bg-white border d-flex align-items-center shadow-sm h-100">
                                                    <div class="icon-wrap mr-15 bg-primary-light rounded-circle text-center">
                                                        <i class="fa-solid fa-star text-primary"></i>
                                                    </div>
                                                    <span class="experience-text font-weight-medium text-dark">{{ trim($tag) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Featured Tours Grid -->
                            <div id="explore-services" class="content-section mb-60">
                                <div class="d-flex justify-content-between align-items-end mb-40">
                                    <h3 class="section-title-two mb-0 font-weight-bold">{{ __('translate.Popular Activities in') }} {{ $destination->localized_name }}</h3>
                                </div>
                                <div class="row">
                                    @forelse($services as $service)
                                        <div class="col-md-6">
                                            @include('tourbooking::front.services.services-item-static', ['service' => $service])
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="empty-services-card p-60 text-center rounded bg-light border-dashed">
                                                <div class="mb-20 opacity-25">
                                                    <i class="fa-solid fa-map-location-dot fa-5x"></i>
                                                </div>
                                                <h4 class="mb-15">{{ __('translate.Services are coming soon in') }} {{ $destination->localized_name }}</h4>
                                                <p class="mb-30 text-muted">{{ __('translate.Our travel experts can still customize a trip for you. Contact us today for a tailor-made experience.') }}</p>
                                                <div class="d-flex justify-content-center flex-wrap">
                                                    <a href="{{ route('contact-us') }}" class="tg-btn mr-15 mb-10">
                                                        <i class="fa-regular fa-envelope mr-10"></i> {{ __('translate.Contact Us') }}
                                                    </a>
                                                    <a href="{{ route('front.tourbooking.services') }}" class="btn btn-outline-dark mb-10">
                                                        {{ __('translate.Explore All Tours') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Footer CTA Banner -->
                            <div class="cta-banner-viva shadow-lg mb-40">
                                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
                                    <div class="cta-text-area text-center text-lg-start mb-20 mb-lg-0 pr-lg-20">
                                        <h3 class="text-white cta-banner-title mb-10">{{ __('translate.Ready to explore') }} {{ $destination->localized_name }}?</h3>
                                        <p class="text-white cta-banner-subtitle mb-0">{{ __('translate.Discover the best tours, transfers, and activities tailored for your trip.') }}</p>
                                    </div>
                                    <div class="cta-btn-area text-center text-lg-end flex-shrink-0">
                                        <a href="{{ route('front.tourbooking.services', ['destination' => $destination->name, 'destination_id' => $destination->id]) }}" class="btn btn-light text-primary font-weight-bold px-40 py-15 rounded-pill shadow-sm cta-btn">
                                            {{ __('translate.View Tours') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <aside class="destination-sidebar-sticky top-sticky">
                            <!-- Info Card -->
                            <div class="destination-info-card bg-white p-35 rounded shadow-sm border mb-40">
                                <h4 class="card-title mb-25 font-weight-bold pb-15 border-bottom">{{ __('translate.Destination Info') }}</h4>
                                <ul class="info-list list-wrap">
                                    <li class="d-flex align-items-center mb-15">
                                        <i class="fa-solid fa-earth-africa text-primary mr-15"></i>
                                        <div>
                                            <span class="d-block text-muted text-xs uppercase">{{ __('translate.Country') }}</span>
                                            <span class="font-weight-bold">{{ $destination->country }}</span>
                                        </div>
                                    </li>
                                    @if($destination->region)
                                        <li class="d-flex align-items-center mb-15">
                                            <i class="fa-solid fa-map-pin text-primary mr-15"></i>
                                            <div>
                                                <span class="d-block text-muted text-xs">{{ __('translate.Region') }}</span>
                                                <span class="font-weight-bold">{{ $destination->region }}</span>
                                            </div>
                                        </li>
                                    @endif
                                    <li class="d-flex align-items-center mb-25">
                                        <i class="fa-solid fa-person-walking-luggage text-primary mr-15"></i>
                                        <div>
                                            <span class="d-block text-muted text-xs">{{ __('translate.Travel Style') }}</span>
                                            <span class="font-weight-bold">{{ $destination->is_popular ? 'Top Rated' : 'Exploring' }}</span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="card-actions mt-20">
                                    <a href="{{ route('front.tourbooking.services', ['destination' => $destination->name, 'destination_id' => $destination->id]) }}" class="tg-btn w-100 mb-15 py-12 text-center">
                                        {{ __('translate.Browse Services') }}
                                    </a>
                                    <a href="{{ route('contact-us') }}" class="btn btn-outline-dark w-100 py-12">
                                        <i class="fa-regular fa-paper-plane mr-10"></i> {{ __('translate.Contact Us') }}
                                    </a>
                                </div>
                            </div>

                            @if($destination->is_popular)
                                <div class="badge-card bg-primary p-30 rounded text-center text-white shadow-sm">
                                    <div class="mb-15"><i class="fa-solid fa-award fa-3x"></i></div>
                                    <h5 class="font-weight-bold">{{ __('translate.Top Rated Destination') }}</h5>
                                    <p class="mb-0 text-white-50">{{ __('translate.This is one of our most loved destinations by travelers.') }}</p>
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('style_section')
<style>
    /* Hero Styles */
    .destination-hero-section {
        overflow: hidden;
    }
    .destination-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.8s ease;
    }
    .destination-hero-section:hover .destination-hero-bg {
        transform: scale(1.05);
    }
    .destination-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 100%);
    }
    .destination-hero-content .breadcrumb-item, 
    .destination-hero-content .breadcrumb-item a {
        color: rgba(255,255,255,0.7);
        font-size: 14px;
    }
    .destination-hero-content .breadcrumb-item.active {
        color: #fff;
    }
    .destination-hero-content .title {
        font-size: 56px;
        line-height: 1.1;
    }
    .destination-hero-content .description {
        font-size: 18px;
        max-width: 600px;
    }

    /* Content Styles */
    .rich-text-content {
        color: #555;
        line-height: 1.8;
        font-size: 16px;
    }
    .text-xs { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
    .py-12 { padding-top: 12px; padding-bottom: 12px; }
    
    .bg-primary-light { background-color: rgba(var(--tg-theme-primary-rgb), 0.1); }
    .icon-wrap { width: 45px; height: 45px; line-height: 45px; }
    
    .experience-card {
        transition: all 0.3s ease;
    }
    .experience-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        border-color: var(--tg-theme-primary) !important;
    }

    /* Sidebar Sticky */
    .top-sticky {
        position: sticky;
        top: 100px;
    }

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

    /* Empty State */
    .border-dashed {
        border: 2px dashed #ddd;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .destination-hero-content .title { font-size: 40px; }
        .destination-sidebar-sticky { margin-top: 50px; }
        .destination-main-wrapper { margin-right: 0; }
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
