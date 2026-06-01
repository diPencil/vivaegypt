@php
    $theme4_cta = getContent('theme4_cta.content', true);
@endphp

@if (!empty($theme4_cta))
    <!-- tg-cta-area-start -->
    <div class="tg-cta-area-area tg-cta-su-2 tg-primary-bg p-relative z-index-1">
        <img class="shape-2 p-absolute d-none d-xl-block" src="assets/img/cta/su/shape-3.png" alt="">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="tg-cta-3-content tg-process-content pt-50 pb-50">
                        <h5 class="tg-section-su-subtitle su-subtitle-2 mb-15">
                            {{ getTranslatedValue($theme4_cta, 'sub_title') }}</h5>
                        <h2 class="tg-section-su-title text-capitalize mb-25">
                            {!! strip_tags(clean(getTranslatedValue($theme4_cta, 'title')), '<br>') !!}
                        </h2>
                        <div class="tg-cta-3-apps d-flex align-items-center">
                            <a class="d-inline-block mr-10"
                                href="{{ getTranslatedValue($theme4_cta, 'google_play_link') }}">
                                <img src="{{ asset('frontend/assets/img/shape/google.png') }}" alt=""></a>

                            <a class="d-inline-block" href="{{ getTranslatedValue($theme4_cta, 'apple_store_link') }}">
                                <img src="{{ asset('frontend/assets/img/shape/app.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="tg-cta-3-thumb p-relative z-index-1 text-end pt-90">
                        <img src="{{ asset(getSingleImage($theme4_cta, 'image')) }}" alt="">
                        <img class="shape p-absolute d-none d-xl-block" src="assets/img/cta/su/shape.png"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-cta-area-end -->
@endif
