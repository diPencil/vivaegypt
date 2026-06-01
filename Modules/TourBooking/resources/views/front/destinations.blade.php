@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Destinations') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Destinations') }}">
    <meta name="description" content="{{ __('translate.Explore the most beautiful destinations across Egypt and beyond with Viva Egypt Travel.') }}">
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = __('translate.Destinations');
    @endphp
    @include('breadcrumb')

        <!-- Destinations Listing -->
        <section class="destinations-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    @foreach($destinations as $destination)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                            <div class="premium-destination-card rounded overflow-hidden shadow-sm h-100 transition-all bg-white border d-flex flex-column">
                                <div class="card-thumb p-relative fix">
                                    <a href="{{ route('front.tourbooking.destinations.show', $destination->slug) }}">
                                        @if($destination->image)
                                            <img src="{{ asset($destination->image) }}" alt="{{ $destination->localized_name }}" class="w-100 transition-all">
                                        @else
                                            <img src="{{ asset('uploads/website-images/placeholder.png') }}" alt="{{ $destination->localized_name }}" class="w-100">
                                        @endif
                                    </a>
                                    <div class="card-tag text-white px-15 py-5 rounded-pill position-absolute" style="background-color: var(--tg-theme-primary);">
                                        {{ $destination->is_popular ? __('translate.Popular') : __('translate.Explore') }}
                                    </div>
                                </div>
                                <div class="card-body p-30 d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-10">
                                        <span class="country-label text-xs font-weight-bold" style="color: var(--tg-theme-primary);"><i class="fa-solid fa-earth-africa mr-5"></i> {{ $destination->country }}</span>
                                    </div>
                                    <h4 class="card-title font-weight-bold mb-15">
                                        <a href="{{ route('front.tourbooking.destinations.show', $destination->slug) }}" class="text-dark hover-primary">{{ $destination->localized_name }}</a>
                                    </h4>
                                    <p class="card-text text-muted small mb-20 flex-grow-1">
                                        {{ Str::limit(html_entity_decode(strip_tags($destination->description)), 100) }}
                                    </p>
                                    <a href="{{ route('front.tourbooking.destinations.show', $destination->slug) }}" class="btn-link text-primary font-weight-bold mt-auto">
                                        {{ __('translate.Explore Now') }} <i class="fa-solid fa-arrow-right ml-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($destinations->hasPages())
                    <div class="row mt-40">
                        <div class="col-12">
                            <div class="pagination-wrap">
                                {{ $destinations->links() }}
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

    /* Card Styles */
    .premium-destination-card {
        transition: all 0.3s ease;
    }
    .premium-destination-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .premium-destination-card .card-thumb { overflow: hidden; }
    .premium-destination-card .card-thumb img { height: 250px; object-fit: cover; }
    .premium-destination-card:hover .card-thumb img { transform: scale(1.1); }
    
    .card-tag { top: 20px; right: 20px; font-size: 12px; z-index: 2; }
    .text-xs { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
    
    .hover-primary:hover { color: var(--tg-theme-primary) !important; }
    .btn-link:hover { text-decoration: underline; }

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
