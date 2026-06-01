@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Service Types') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Service Types') }}">
    <meta name="description" content="{{ __('translate.Explore our diverse range of services, including Tours, Transfers, Flight Reservations, and more.') }}">
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = __('translate.Our Services');
    @endphp
    @include('breadcrumb')

        <!-- Service Types Listing -->
        <section class="service-types-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    @foreach($serviceTypes as $type)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                            <div class="premium-service-card p-40 rounded bg-white border text-center shadow-sm h-100 transition-all d-flex flex-column">
                                <div class="icon-box-wrap mb-30 bg-primary-light rounded-circle d-inline-flex align-items-center justify-content-center mx-auto">
                                    @if($type->icon)
                                        <i class="{{ $type->icon }} fa-3x text-primary"></i>
                                    @elseif($type->image)
                                        <img src="{{ asset($type->image) }}" alt="{{ $type->localized_name }}" class="img-fluid rounded" style="max-height: 80px; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-suitcase-rolling fa-3x text-primary"></i>
                                    @endif
                                </div>
                                <h4 class="card-title font-weight-bold mb-15">
                                    <a href="{{ route('front.tourbooking.service-types.show', $type->slug) }}" class="text-dark hover-primary">{{ $type->localized_name }}</a>
                                </h4>
                                <p class="card-text text-muted small mb-25 flex-grow-1">
                                    {{ Str::limit(strip_tags($type->description), 120) }}
                                </p>
                                <div class="mt-auto">
                                    <a href="{{ route('front.tourbooking.service-types.show', $type->slug) }}" class="tg-btn btn-sm px-30">
                                        {{ __('translate.Explore') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($serviceTypes->hasPages())
                    <div class="row mt-40">
                        <div class="col-12">
                            <div class="pagination-wrap">
                                {{ $serviceTypes->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('style_section')
<style>
    /* Hero Styles */
    .destination-hero-section { overflow: hidden; }
    .destination-hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-size: cover; background-position: center;
    }
    .destination-hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
    }
    .destination-hero-content .title { font-size: 56px; line-height: 1.1; }
    .destination-hero-content .description { font-size: 18px; max-width: 600px; }

    /* Service Card Styles */
    .bg-primary-light { background-color: rgba(var(--tg-theme-primary-rgb), 0.1); }
    .icon-box-wrap { width: 100px; height: 100px; transition: all 0.3s ease; }
    
    .premium-service-card {
        transition: all 0.3s ease;
    }
    .premium-service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        border-color: var(--tg-theme-primary) !important;
    }
    .premium-service-card:hover .icon-box-wrap {
        transform: rotateY(180deg);
    }
    
    .hover-primary:hover { color: var(--tg-theme-primary) !important; }

    /* Responsive */
    @media (max-width: 991px) {
        .destination-hero-content .title { font-size: 40px; }
    }
    @media (max-width: 767px) {
        .destination-hero-content .title { font-size: 32px; }
        .destination-hero-content .description { font-size: 16px; }
        .destination-hero-content { padding-top: 100px; padding-bottom: 80px; }
    }
</style>
@endpush
