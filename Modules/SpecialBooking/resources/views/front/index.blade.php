@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Booking Services') }} - Viva Egypt Travel</title>
    <meta name="title" content="{{ __('translate.Booking Services') }}">
    <meta name="description" content="{{ __('translate.Explore our premium booking services including SPA, Flights, Transfers, and Nile Cruises.') }}">
@endsection

@section('front-content')
    <main>
        @php
            $breadcrumb_title = __('translate.Booking Services');
        @endphp
        @include('breadcrumb')

        <section class="booking-services-area pt-100 pb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-10">
                        <div class="section-title text-center mb-60">
                            <span class="sub-title">{{ __('translate.Explore Booking Services') }}</span>
                            <h2 class="title">{{ __('translate.Luxury Travel Experiences') }}</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- SPA Service Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                        <div class="tg-service-item style-3">
                            <div class="tg-service-thumb">
                                <a href="{{ route('special-booking.spa') }}">
                                    <img src="{{ asset('frontend/assets/img/special-booking/spa.png') }}" alt="{{ __('translate.SPA') }}">
                                </a>
                            </div>
                            <div class="tg-service-content">
                                <h3 class="title"><a href="{{ route('special-booking.spa') }}">{{ __('translate.SPA') }}</a></h3>
                                <p>{{ __('translate.Relaxing Spa Services') }}</p>
                                <div class="tg-service-btn">
                                    <a href="{{ route('special-booking.spa') }}" class="btn btn-primary w-100">{{ __('translate.Book Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flights Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                        <div class="tg-service-item style-3">
                            <div class="tg-service-thumb">
                                <a href="{{ route('special-booking.flights') }}">
                                    <img src="{{ asset('frontend/assets/img/special-booking/flights.png') }}" alt="{{ __('translate.Flights by Request') }}">
                                </a>
                            </div>
                            <div class="tg-service-content">
                                <h3 class="title"><a href="{{ route('special-booking.flights') }}">{{ __('translate.Flights by Request') }}</a></h3>
                                <p>{{ __('translate.Personalized flight booking requests') }}</p>
                                <div class="tg-service-btn">
                                    <a href="{{ route('special-booking.flights') }}" class="btn btn-primary w-100">{{ __('translate.Request Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transfers Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                        <div class="tg-service-item style-3">
                            <div class="tg-service-thumb">
                                <a href="{{ route('special-booking.transfers') }}">
                                    <img src="{{ asset('frontend/assets/img/special-booking/transfers.png') }}" alt="{{ __('translate.Transfers by Request') }}">
                                </a>
                            </div>
                            <div class="tg-service-content">
                                <h3 class="title"><a href="{{ route('special-booking.transfers') }}">{{ __('translate.Transfers by Request') }}</a></h3>
                                <p>{{ __('translate.Private and group transportation services') }}</p>
                                <div class="tg-service-btn">
                                    <a href="{{ route('special-booking.transfers') }}" class="btn btn-primary w-100">{{ __('translate.Request Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nile Cruises Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                        <div class="tg-service-item style-3">
                            <div class="tg-service-thumb">
                                <a href="{{ route('special-booking.nile-cruises') }}">
                                    <img src="{{ asset('frontend/assets/img/special-booking/nile_cruises.png') }}" alt="{{ __('translate.Nile Cruises') }}">
                                </a>
                            </div>
                            <div class="tg-service-content">
                                <h3 class="title"><a href="{{ route('special-booking.nile-cruises') }}">{{ __('translate.Nile Cruises') }}</a></h3>
                                <p>{{ __('translate.Luxurious Nile cruise experiences') }}</p>
                                <div class="tg-service-btn">
                                    <a href="{{ route('special-booking.nile-cruises') }}" class="btn btn-primary w-100">{{ __('translate.Book Now') }}</a>
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
    .tg-service-item.style-3 {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .tg-service-item.style-3:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .tg-service-thumb img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .tg-service-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .tg-service-content .title {
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: 700;
    }
    .tg-service-content p {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: #c92127;
        border-color: #c92127;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #a9151b;
        border-color: #a9151b;
    }
</style>
@endpush
