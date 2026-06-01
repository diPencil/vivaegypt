@php
    $theme4_why_choose = getContent('theme4_why_choose.content', true);
    $translatedSlides = getTranslatedSlides($theme4_why_choose, 'slides');
@endphp

@if ($theme4_why_choose)
    <!-- tg-chose-area-start -->
    <div class="tg-chose-area tg-chose-su-2-wrap pt-130 pb-60 p-relative z-index-9 fix">
        <img class="tg-chose-su-2-bg-shape p-absolute" src="{{ asset('frontend/assets/img/shape/map-shape-7.png') }}"
            alt="">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-xl-9 col-lg-8 col-md-8">
                            <div class="tg-chose-section-title mb-20">
                                <h5 class="tg-section-su-subtitle su-subtitle-2 mb-20 wow fadeInUp" data-wow-delay=".4s"
                                    data-wow-duration=".9s">
                                    {{ getTranslatedValue($theme4_why_choose, 'sub_title') }}
                                </h5>
                                <h2 class="tg-section-su-title text-capitalize wow fadeInUp mb-15" data-wow-delay=".5s"
                                    data-wow-duration=".9s">
                                    {{ getTranslatedValue($theme4_why_choose, 'title') }}
                                </h2>
                                <p class="tg-section-su-para tg-section-su-para-2 mb-0">
                                    {!! strip_tags(clean(getTranslatedValue($theme4_why_choose, 'description')), '<br>') !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                            <div class="tg-chose-su-2-thumb mb-25">
                                <img class="w-100"
                                    src="{{ asset(getSingleImage($theme4_why_choose, 'left_side_image')) }}"
                                    alt="">
                            </div>
                        </div>
                        @if (count($translatedSlides) > 0)
                            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                                <div class="tg-chose-list-wrap ml-30">
                                    @foreach ($translatedSlides as $key => $slide)
                                        <div class="tg-chose-list d-flex mb-10">
                                            @isset($slide['icon'])
                                                <span class="tg-chose-list-icon mr-20">
                                                    <img src="{{ asset($slide['icon']) }}" alt="">
                                                </span>
                                            @endisset
                                            <div class="tg-chose-list-content">
                                                <h4 class="tg-chose-list-title mb-15">
                                                    {{ $slide['title'] }}
                                                </h4>
                                                @isset($slide['short_description'])
                                                    <p>
                                                        {{ $slide['short_description'] }}
                                                    </p>
                                                @endisset
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-5 col-lg-8">
                    <div class="tg-chose-su-2-main-thumb text-end p-relative wow fadeInUp" data-wow-delay=".6s"
                        data-wow-duration=".9s">
                        <img class="tg-chose-su-2-main-shape d-none d-sm-block"
                            src="{{ asset('frontend/assets/img/shape/star-5.png') }}" alt="">
                        <img class="w-100" src="{{ asset(getSingleImage($theme4_why_choose, 'right_side_image')) }}"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-chose-area-end -->
@endif
