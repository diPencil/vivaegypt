@php
    $theme3_about = getContent('theme3_about.content', true);
    $translatedSlides = getTranslatedSlides($theme3_about, 'slides');
@endphp

@if (!empty($theme3_about))
    <!-- tg-about-area-start -->
    <div class="tg-about-area p-relative z-index-1 pb-80">
        <img class="tg-about-su-right-shape d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/many-shape.png') }}" alt="">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-5">
                    <div class="tg-about-su-thumb p-relative mb-40 wow fadeInLeft" data-wow-delay=".4s"
                        data-wow-duration=".6s">
                        <div class="tg-about-su-shape-2">
                            <img src="{{ asset('frontend/assets/img/shape/camera.png') }}" alt="">
                        </div>
                        <div class="tg-about-su-shape">
                            <img src="{{ asset('frontend/assets/img/shape/cap.png') }}" alt="">
                        </div>
                        <img src="{{ asset(getTranslatedValue($theme3_about, 'left_side_image')) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="tg-about-su-content-wrap ml-80 mb-30 wow fadeInRight" data-wow-delay=".4s"
                        data-wow-duration=".6s">
                        <div class="tg-location-section-title mb-30" dir="auto">
                            <h5 class="tg-section-su-subtitle mb-15">
                                {{ getTranslatedValue($theme3_about, 'sub_title') }}
                            </h5>
                            <h2 class="tg-section-su-title text-capitalize mb-15">
                                {{ getTranslatedValue($theme3_about, 'title') }}
                            </h2>
                            <p class="tg-section-su-para mb-10">
                                {!! strip_tags(clean(getTranslatedValue($theme3_about, 'description')), '<br>') !!}
                            </p>
                        </div>
                        @if (count($translatedSlides) > 0)
                            <div class="tg-about-su-funfact-wrap mb-40">
                                @foreach ($translatedSlides as $key => $slide)
                                    <div class="tg-about-su-funfact-item mb-15">
                                        @isset($slide['image'])
                                            <div class="tg-about-su-funfact-icon mb-20">
                                                <img src="{{ asset($slide['image']) }}" alt="">
                                            </div>
                                        @endisset
                                        <div class="tg-about-su-funfact-text" dir="auto">
                                            @isset($slide['title'])
                                                <h3 class="mb-0">{{ $slide['title'] }}</h3>
                                            @endisset

                                            @isset($slide['sub_title'])
                                                <span>{{ $slide['sub_title'] }}</span>
                                            @endisset
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="tg-about-su-author-wrap">
                            <div class="mr-30 mb-10 tg-about-su-cta-wrap">
                                <a class="tg-btn tg-btn-hover tg-btn-switch-animation"
                                    href="{{ getTranslatedValue($theme3_about, 'button_url') }}">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <span class="btn-text">{{ getTranslatedValue($theme3_about, 'button_text') }}</span>
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
                            <div class="tg-about-su-author d-flex align-items-center mb-10">
                                <div class="tg-about-su-author-avatar mr-10">
                                    <img src="{{ asset(getTranslatedValue($theme3_about, 'author_image')) }}"
                                        alt="">
                                </div>
                                <div class="tg-about-su-author-info">
                                    <h5>{{ getTranslatedValue($theme3_about, 'author_title') }}</h5>
                                    <span>{{ getTranslatedValue($theme3_about, 'author_sub_title') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-about-area-end -->
@endif
