@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Tour Booking') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Tour Booking') }}">
    <meta name="description" content="{{ __('translate.Book your dream vacation with Viva Egypt Travel. Explore tours, transfers, flights, and more.') }}">
@endsection

@section('front-content')
    <main>
    @php
        $breadcrumb_title = __('translate.Tour Booking');
    @endphp
    @include('breadcrumb')

        <!-- Tour Booking Home Content -->
        <section class="tour-booking-home pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-60">
                        <h2 class="section-title">{{ __('translate.Welcome to Tour Booking') }}</h2>
                        <p class="section-description">{{ __('translate.Discover amazing experiences and book your perfect trip with us.') }}</p>
                    </div>
                </div>

                <!-- Featured Services -->
                @if($featuredServices->count() > 0)
                    <div class="row mb-80">
                        <div class="col-12">
                            <h3 class="text-center mb-40">{{ __('translate.Featured Services') }}</h3>
                        </div>
                        @foreach($featuredServices as $service)
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                <div class="service-card">
                                    @if($service->thumbnail)
                                        <img src="{{ asset($service->thumbnail->file_path) }}" alt="{{ $service->title }}" class="img-fluid">
                                    @endif
                                    <h4><a href="{{ route('front.tourbooking.services.show', $service->slug) }}">{{ $service->title }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Service Types -->
                @if($serviceTypes->count() > 0)
                    <div class="row mb-80">
                        <div class="col-12">
                            <h3 class="text-center mb-40">{{ __('translate.Our Services') }}</h3>
                        </div>
                        @foreach($serviceTypes as $type)
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                <div class="service-type-card text-center">
                                    <h4><a href="{{ route('front.tourbooking.service-types.show', $type->slug) }}">{{ $type->localized_name }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Popular Destinations -->
                @if($popularDestinations->count() > 0)
                    <div class="row mb-80">
                        <div class="col-12">
                            <h3 class="text-center mb-40">{{ __('translate.Popular Destinations') }}</h3>
                        </div>
                        @foreach($popularDestinations as $destination)
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                <div class="destination-card">
                                    <h4><a href="{{ route('front.tourbooking.destinations.show', $destination->slug) }}">{{ $destination->localized_name }}</a></h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Latest Reviews -->
                @if($latestReviews->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center mb-40">{{ __('translate.Latest Reviews') }}</h3>
                        </div>
                        @foreach($latestReviews as $review)
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                                <div class="review-card">
                                    <p>{{ Str::limit($review->comment, 100) }}</p>
                                    <cite>{{ $review->user->name }}</cite>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection