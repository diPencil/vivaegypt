@php
    $theme7_why_choose = getContent('theme7_why_choose.content', true);
    $translatedSlides = getTranslatedSlides($theme7_why_choose, 'slides');
@endphp

@if ($theme7_why_choose)
    <!-- tg-chose-us-area-start -->
    <div class="tg-chose-area pt-140 pb-130 p-relative z-index-1">
        <img class="tg-chose-5-map-shape d-none d-lg-block" src="{{ asset('frontend/assets/img/shape/map-shape-9.png') }}" alt="">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="tg-chose-section-title mb-30">
                        <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".3s" data-wow-duration=".1s">
                            {{ getTranslatedValue($theme7_why_choose, 'sub_title') }}
                        </h5>
                        <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                            {!! strip_tags(clean(getTranslatedValue($theme7_why_choose, 'title')), '<br>') !!}
                        </h2>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="tg-chose-5-para">
                        <p class="text-capitalize wow fadeInUp mb-0" data-wow-delay=".5s" data-wow-duration=".9s">
                            {!! strip_tags(clean(getTranslatedValue($theme7_why_choose, 'description')), '<br>') !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 wow fadeInLeft" data-wow-delay=".4s" data-wow-duration="1s">
                    <div class="tg-chose-5-left mr-40">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="tg-chose-5-thumb">
                                    <img class="mb-20" src="{{ asset(getSingleImage($theme7_why_choose, 'image_1')) }}"
                                        alt="">
                                    <img src="{{ asset(getSingleImage($theme7_why_choose, 'image_2')) }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <div class="tg-chose-5-thumb-2 p-relative">
                                    <div class="tg-chose-5-text-round d-none d-sm-block">
                                        <div class="tg-chose-3-rounded p-relative mb-20">
                                            <img class="rotate-infinite-2"
                                                src="{{ asset('frontend/assets/img/shape/circle-text-2.png') }}"
                                                alt="">
                                            <img class="tg-chose-3-star rounded-circale"
                                                src="{{ asset('frontend/assets/img/shape/round-icon.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <img src="{{ asset(getSingleImage($theme7_why_choose, 'image_3')) }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="tg-chose-list-wrap tg-chose-5-list-wrap pt-40">
                        @foreach ($translatedSlides as $key => $slide)
                            <div class="tg-chose-list d-flex mb-20 wow fadeInUp" data-wow-delay=".{{ $key + 6 }}s"
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
                            <a href="{{ getTranslatedValue($theme7_why_choose, 'button_url') }}" class="tg-btn tg-btn-switch-animation">
                                <span class="d-flex align-items-center justify-content-center">
                                    <span class="btn-text">
                                        {{ getTranslatedValue($theme7_why_choose, 'button_text') }}
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
    <!-- tg-chose-us-area-end -->
@endif
