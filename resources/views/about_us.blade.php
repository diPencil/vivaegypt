@php
    $page_title = __('brand.about_us');
@endphp

@extends('layout_inner_page')

@section('title')
    <title>{{ $page_title }}</title>
    <meta name="title" content="{{ $page_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection

@section('front-content')
    @include('breadcrumb', ['page_title' => $page_title])

    <!-- tg-about-us-area-start -->
    <div class="tg-about-area p-relative z-index-1 pt-140 pb-105">
        <img class="tg-about-details-shape p-absolute d-none d-lg-block"
            src="{{ asset('frontend/assets/img/shape/hill.png') }}" alt="shape">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="tg-about-details-left p-relative mb-15">
                        <img class="tg-about-details-map p-absolute"
                            src="{{ asset('frontend/assets/img/shape/map-shape.png') }}" alt="map">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="tg-about-details-thumb p-relative z-index-9">
                                    <img class="main-thumb tg-round-15 w-100 mb-20"
                                        src="{{ asset(getSingleImage($about_us, 'about_image_one')) }}" alt="thumb">
                                    <img class="main-thumb tg-round-15 w-100 mb-20"
                                        src="{{ asset(getSingleImage($about_us, 'about_image_two')) }}" alt="thumb">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="tg-about-details-thumb-2 p-relative">
                                    <div class="tg-chose-3-rounded p-relative mb-30">
                                        <img class="rotate-infinite-2"
                                            src="{{ asset('frontend/assets/img/shape/circle-text.png') }}" alt="">
                                        <img class="tg-chose-3-star" src="{{ asset('frontend/assets/img/shape/star.png') }}"
                                            alt="">
                                    </div>
                                    <img class="w-100 tg-round-15"
                                        src="{{ asset(getSingleImage($about_us, 'about_image_three')) }}" alt="chose">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tg-chose-content mb-35 ml-60">
                        <div class="tg-section-title-3 mb-30">
                            <span class="tg-section-subtitle">{{ __('brand.about_hero_subtitle') }}</span>
                            <h2 class="tg-section-title">{{ __('brand.about_hero_title') }}</h2>
                        </div>
                        <p class="tg-about-3-text mb-20">
                            {{ __('brand.about_hero_desc_1') }}
                        </p>
                        <p class="tg-about-3-text mb-35">
                            {{ __('brand.about_hero_desc_2') }}
                        </p>
                        <div class="tg-about-3-btn">
                            <a href="{{ route('tours') }}" class="tg-btn-3">
                                <span>{{ __('brand.plan_trip') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- What We Do Section -->
    <div class="tg-chose-area tg-grey-bg pt-140 pb-70 p-relative z-index-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="tg-section-title-3 text-center mb-60">
                        <span class="tg-section-subtitle">{{ __('brand.about_what_we_do_subtitle') }}</span>
                        <h2 class="tg-section-title">{{ __('brand.about_what_we_do_title') }}</h2>
                        <p class="mt-20">{{ __('brand.about_what_we_do_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center">
                        <div class="tg-chose-6-icon mb-20 d-flex justify-content-center align-items-center mx-auto" style="height: 50px;">
                            <i class="fas fa-map-marked-alt fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title">{{ __('brand.about_tailor_made') }}</h4>
                            <p>{{ __('brand.about_tailor_made_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center">
                        <div class="tg-chose-6-icon mb-20 d-flex justify-content-center align-items-center mx-auto" style="height: 50px;">
                            <i class="fas fa-handshake fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title">{{ __('brand.about_trusted_services') }}</h4>
                            <p>{{ __('brand.about_trusted_services_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center">
                        <div class="tg-chose-6-icon mb-20 d-flex justify-content-center align-items-center mx-auto" style="height: 50px;">
                            <i class="fas fa-headset fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title">{{ __('brand.about_support_all_way') }}</h4>
                            <p>{{ __('brand.about_support_all_way_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="tg-chose-6-area pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="tg-section-title-3 text-center mb-60">
                        <span class="tg-section-subtitle">{{ __('brand.about_why_choose_subtitle') }}</span>
                        <h2 class="tg-section-title">{{ __('brand.about_why_choose_title') }}</h2>
                        <p class="mt-20">{{ __('brand.about_why_choose_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center shadow-sm">
                        <div class="tg-chose-6-icon mb-25 d-flex justify-content-center align-items-center mx-auto">
                            <i class="fas fa-globe-africa fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title mb-15">{{ __('brand.about_local_global_expertise') }}</h4>
                            <p>{{ __('brand.about_local_global_expertise_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center shadow-sm">
                        <div class="tg-chose-6-icon mb-25 d-flex justify-content-center align-items-center mx-auto">
                            <i class="fas fa-calendar-check fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title mb-15">{{ __('brand.about_flexible_planning') }}</h4>
                            <p>{{ __('brand.about_flexible_planning_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center shadow-sm">
                        <div class="tg-chose-6-icon mb-25 d-flex justify-content-center align-items-center mx-auto">
                            <i class="fas fa-handshake fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title mb-15">{{ __('brand.about_trusted_partners') }}</h4>
                            <p>{{ __('brand.about_trusted_partners_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="tg-chose-6-wrap mb-30 text-center shadow-sm">
                        <div class="tg-chose-6-icon mb-25 d-flex justify-content-center align-items-center mx-auto">
                            <i class="fas fa-headset fa-2x" style="color: #e31c2d;"></i>
                        </div>
                        <div class="tg-chose-6-content">
                            <h4 class="tg-chose-6-title mb-15">{{ __('brand.about_support_anytime') }}</h4>
                            <p>{{ __('brand.about_support_anytime_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Travel Services Grid -->
    <div class="tg-service-area tg-grey-bg-2 pt-120 pb-90">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="tg-section-title-3 text-center mb-60">
                        <span class="tg-section-subtitle">{{ __('brand.about_our_services_subtitle') }}</span>
                        <h2 class="tg-section-title">{{ __('brand.about_our_services_title') }}</h2>
                        <p class="mt-20">{{ __('brand.about_our_services_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gx-20">
                @php
                    $services = [
                        ['icon' => 'fas fa-bus', 'title' => __('brand.about_service_tours')],
                        ['icon' => 'fas fa-hotel', 'title' => __('brand.about_service_hotels')],
                        ['icon' => 'fas fa-car', 'title' => __('brand.about_service_transfers')],
                        ['icon' => 'fas fa-campground', 'title' => __('brand.about_service_camping')],
                        ['icon' => 'fas fa-kaaba', 'title' => __('brand.about_service_hajj')],
                        ['icon' => 'fas fa-passport', 'title' => __('brand.about_service_essentials')],
                        ['icon' => 'fas fa-plane', 'title' => __('brand.about_service_worldwide')],
                        ['icon' => 'fas fa-suitcase', 'title' => __('brand.about_service_custom')],
                    ];
                @endphp
                @foreach($services as $service)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="tg-service-item mb-30 p-4 bg-white tg-round-15 text-center shadow-sm">
                        <div class="icon mb-15 d-flex justify-content-center align-items-center mx-auto" style="height: 50px;">
                            <i class="{{ $service['icon'] }} text-danger fs-3"></i>
                        </div>
                        <h5 class="mb-0">{{ $service['title'] }}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Our Promise Section -->
    <div class="tg-promise-area pt-120 pb-120">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="tg-promise-content">
                        <div class="tg-section-title-3 mb-35">
                            <span class="tg-section-subtitle">{{ __('brand.about_our_promise_subtitle') }}</span>
                            <h2 class="tg-section-title">{{ __('brand.about_our_promise_title') }}</h2>
                        </div>
                        <p class="mb-40">{{ __('brand.about_our_promise_desc') }}</p>
                        <div class="tg-promise-list">
                            <ul class="list-wrap">
                                <li class="d-flex align-items-center mb-20">
                                    <i class="fas fa-check-circle text-danger mr-15 fs-5"></i>
                                    <span class="fw-semibold">{{ __('brand.about_promise_1') }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-20">
                                    <i class="fas fa-check-circle text-danger mr-15 fs-5"></i>
                                    <span class="fw-semibold">{{ __('brand.about_promise_2') }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-20">
                                    <i class="fas fa-check-circle text-danger mr-15 fs-5"></i>
                                    <span class="fw-semibold">{{ __('brand.about_promise_3') }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-20">
                                    <i class="fas fa-check-circle text-danger mr-15 fs-5"></i>
                                    <span class="fw-semibold">{{ __('brand.about_promise_4') }}</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-danger mr-15 fs-5"></i>
                                    <span class="fw-semibold">{{ __('brand.about_promise_5') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tg-promise-img text-center p-relative ml-40">
                         <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80" alt="Our Promise" class="tg-round-15 shadow-lg w-100">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Travel with Confidence CTA -->
    <div class="tg-confidence-area pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="tg-confidence-wrap p-5 text-center tg-round-20 shadow-lg" style="background-color: #e31c2d;">
                        <div class="py-3">
                            <h2 class="text-white mb-25">{{ __('brand.about_ready_to_plan_title') }}</h2>
                            <p class="text-white opacity-75 mb-40 fs-5">{{ __('brand.about_ready_to_plan_desc') }}</p>
                            <div class="tg-confidence-btns">
                                <a href="{{ route('tours') }}" class="tg-btn tg-btn-black mr-20 shadow">{{ __('brand.explore_tours') }}</a>
                                <a href="{{ route('contact-us') }}" class="tg-btn tg-btn-transparent shadow">{{ __('brand.contact_us') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tg-banner-area-start -->
    <div class="tg-banner-area tg-grey-bg tg-banner-4-spacing"
        data-background="{{ asset(getSingleImage($about_cta, 'section_bg_image')) }}">
        <div class="container">
            <div class="col-lg-12">
                <div class="tg-banner-2-content tg-banner-4-content tg-banner-6-content text-center">
                    <div class="tg-about-section-title mb-25">
                        <h5 class="tg-section-subtitle mb-20 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                            {{ __('brand.home_dest_label') }}
                        </h5>
                        <h2 class="tg-section-title-white mb-30 wow fadeInUp" data-wow-delay=".5s"
                            data-wow-duration=".9s">
                            {!! strip_tags(clean(__('brand.home_dest_title')), '<br>') !!}
                        </h2>
                    </div>
                    <div class="tp-banner-btn-wrap wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".9s">
                        <a href="{{ getTranslatedValue($about_cta, 'section_button_link') }}"
                             class="tg-btn tg-btn-transparent tg-btn-switch-animation">
                            <span class="d-flex align-items-center justify-content-center">
                                <span class="btn-text">{{ __('brand.explore_tours') }}</span>
                                <span class="btn-icon ml-5">
                                    <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                            stroke="currentColor" stroke-width="1.77778" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="btn-icon ml-5">
                                    <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                            stroke="currentColor" stroke-width="1.77778" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tg-banner-bottom pb-190">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tg-banner-2-big-title text-center wow fadeInUp" data-wow-delay=".5s"
                            data-wow-duration=".9s">
                            <h2>{{ __('brand.home_wave_overlay') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-banner-area-end -->
@endsection
