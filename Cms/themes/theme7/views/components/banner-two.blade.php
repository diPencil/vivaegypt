@php
    $theme6_banner_2 = getContent('theme6_banner_2.content', true);
@endphp

<!-- tg-banner-area-start -->
<div class="tg-banner-area tg-banner-4-spacing"
    data-background="{{ asset(getSingleImage($theme6_banner_2, 'background_image')) }}">
    <div class="container">
        <div class="col-lg-12">
            <div class="tg-banner-2-content tg-banner-4-content text-center">
                <div class="tg-about-section-title mb-25">
                    <h5 class="tg-section-subtitle mb-20 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                        {{ getTranslatedValue($theme6_banner_2, 'sub_title') }}
                    </h5>
                    <h2 class="tg-section-title-white mb-30 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme6_banner_2, 'title')), '<br>') !!}
                    </h2>
                </div>
                <div class="tp-banner-btn-wrap wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".9s">
                    <a href="{{ getTranslatedValue($theme6_banner_2, 'button_url') }}"
                        class="tg-btn tg-btn-transparent tg-btn-switch-animation">
                        <span class="d-flex align-items-center justify-content-center">
                            <span class="btn-text">{{ getTranslatedValue($theme6_banner_2, 'button_text') }}</span>
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
    <div class="tg-banner-bottom pb-150">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tg-banner-2-big-title text-center wow fadeInUp" data-wow-delay=".5s"
                        data-wow-duration=".9s">
                        <h2>{{ getTranslatedValue($theme6_banner_2, 'big_title') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tg-banner-area-end -->
