@php
    $theme5_why_choose = getContent('theme5_why_choose.content', true);
    $translatedSlides = getTranslatedSlides($theme5_why_choose, 'slides');
@endphp

@if ($theme5_why_choose)
    <!-- tg-chose-us-area-start -->
    <div class="tg-chose-area p-relative z-index-1  tg-grey-bg pt-115 pb-90">
        <img class="tg-chose-3-shape p-absolute" src="{{ asset('frontend/assets/img/shape/brige-2.png') }}" alt="shape">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="tg-chose-3-left p-relative mb-35">
                        <img class="tg-chose-3-map" src="{{ asset('frontend/assets/img/shape/map-shape-8.png') }}" alt="map">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="tg-chose-3-thumb">
                                    <div class="tg-chose-3-rounded p-relative mb-20">
                                        <img class="rotate-infinite-2" src="{{ asset('frontend/assets/img/shape/circle-text.png') }}"
                                            alt="">
                                        <img class="tg-chose-3-star" src="{{ asset('frontend/assets/img/shape/star.png') }}"
                                            alt="">
                                    </div>
                                    <img class="main-thumb" src="{{ asset(getSingleImage($theme5_why_choose, 'small_image')) }}" alt="thumb">
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-6">
                                <div class="tg-chose-3-thumb-inner p-relative">
                                    <div class="tg-chose-3-thumb-2">
                                        <img class="w-100 tg-round-15" src="{{ asset(getSingleImage($theme5_why_choose, 'big_image')) }}"
                                            alt="chose">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="tg-chose-content mb-35">
                        <div class="tg-chose-section-title mb-30">
                            <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".3s"
                                data-wow-duration=".1s">
                                {{ getTranslatedValue($theme5_why_choose, 'sub_title') }}
                            </h5>
                            <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                                {!! strip_tags(clean(getTranslatedValue($theme5_why_choose, 'title')), '<br>') !!}
                            </h2>
                            <p class="text-capitalize wow fadeInUp mb-10" data-wow-delay=".5s" data-wow-duration=".9s">
                                {!! strip_tags(clean(getTranslatedValue($theme5_why_choose, 'description')), '<br>') !!}
                            </p>
                        </div>
                        <div class="tg-chose-list-wrap">
                            @foreach ($translatedSlides as $key => $slide)
                                <div class="tg-chose-list d-flex mb-10 wow fadeInUp" data-wow-delay=".6s"
                                    data-wow-duration=".9s">
                                    @isset($slide['icon'])
                                        <span class="tg-chose-list-icon mr-20">
                                            <img src="{{ asset($slide['icon']) }}" alt="">
                                        </span>
                                    @endisset
                                    <div class="tg-chose-list-content">
                                        <h4 class="tg-chose-list-title mb-5">{{ $slide['title'] }}</h4>
                                        @isset($slide['short_description'])
                                            <p>
                                                {{ $slide['short_description'] }}
                                            </p>
                                        @endisset
                                    </div>
                                </div>
                            @endforeach
                            <div class="tg-chose-btn wow fadeInUp" data-wow-delay=".8s" data-wow-duration=".9s">
                                <a href="{{ getTranslatedValue($theme5_why_choose, 'button_url') }}"
                                    class="tg-btn tg-btn-switch-animation">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <span
                                            class="btn-text">{{ getTranslatedValue($theme5_why_choose, 'button_text') }}</span>
                                        <span class="btn-icon ml-5">
                                            <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                                    stroke="white" stroke-width="1.77778" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="btn-icon ml-5">
                                            <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                                    stroke="white" stroke-width="1.77778" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-chose-us-area-end -->
@endif
