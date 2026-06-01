@extends('layout_inner_page')

@section('title')
    <title>{{ $title }} - {{ __('translate.Services') }}</title>
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = $title;
    @endphp
    @include('breadcrumb')

        <section class="services-by-type-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    @forelse($services as $service)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                            @include('tourbooking::front.services.services-item-static', ['service' => $service])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-services-card p-60 text-center rounded bg-light border-dashed">
                                <div class="mb-20 opacity-25">
                                    <i class="fa-solid fa-magnifying-glass fa-5x"></i>
                                </div>
                                <h4 class="mb-15">{{ __('translate.No services found.') }}</h4>
                                <p class="mb-30 text-muted">{{ __('translate.Please check back soon or explore our other travel categories.') }}</p>
                                <a href="{{ route('front.tourbooking.services') }}" class="tg-btn">
                                    {{ __('translate.Browse All Services') }}
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($services->hasPages())
                    <div class="row mt-40">
                        <div class="col-12">
                            <div class="pagination-wrap">
                                {{ $services->links() }}
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
    .destination-hero-content .title { font-size: 48px; line-height: 1.1; }

    /* Empty State */
    .border-dashed { border: 2px dashed #ddd; }

    /* Responsive */
    @media (max-width: 767px) {
        .destination-hero-content .title { font-size: 32px; }
        .destination-hero-content { padding-top: 100px; padding-bottom: 80px; }
    }
</style>
@endpush
