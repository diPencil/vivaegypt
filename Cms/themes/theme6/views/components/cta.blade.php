@php
    $theme6_cta = getContent('theme6_cta.content', true);
@endphp

@if (!empty($theme6_cta))
    <!-- tg-cta-area-start -->
    <div class="tg-cta-area-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="tg-cta-4-spacing tg-primary-bg p-relative z-index-1">
                        <img class="tg-cta-3-shape-2 d-none d-md-block" src="{{ asset('frontend/assets/img/shape/stadium-2.png') }}"
                            alt="">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <div class="tg-cta-4-thumb mr-25 p-relative z-index-1  pt-85 ">
                                    <img class="w-100" src="{{ asset(getSingleImage($theme6_cta, 'image')) }}" alt="">
                                    <img class="tg-cta-3-shape rotate-infinite" src="{{ asset('frontend/assets/img/shape/star-6.png') }}"
                                        alt="shape">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="tg-cta-4-content mb-20 pt-15">
                                    <h2 class="mb-15 tg-cta-title text-white text-capitalize mb-15">
                                        {!! strip_tags(clean(getTranslatedValue($theme6_cta, 'title')), '<br>') !!}
                                    </h2>
                                    <p class="text-white">
                                        {!! strip_tags(clean(getTranslatedValue($theme6_cta, 'short_description')), '<br>') !!}
                                    </p>
                                    <div class="tg-cta-3-apps pt-15 d-flex align-items-center">

                                        <a class="mb-10 d-inline-block mr-10"
                                            href="{{ getTranslatedValue($theme6_cta, 'google_play_link') }}">
                                            <img src="{{ asset('frontend/assets/img/shape/google.png') }}"
                                                alt=""></a>

                                        <a class="mb-10 d-inline-block"
                                            href="{{ getTranslatedValue($theme6_cta, 'apple_store_link') }}">
                                            <img src="{{ asset('frontend/assets/img/shape/app.png') }}" alt="">
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-cta-area-end -->
@endif
