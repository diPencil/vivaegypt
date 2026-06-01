@php
    $theme2_banner = getContent('theme2_banner.content', true);
@endphp


@if (!empty($theme2_banner))
    <!-- tg-banner-area-start -->
    <div class="tg-banner-area tg-banner-space p-relative z-index-9">
        <img class="tg-banner-3-shape d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/tree.png') }}"
            alt="">
        <div class="container">
            <div class="row gx-0">
                <div class="col-lg-4">
                    <div class="tg-banner-content tg-banner-3-content p-relative z-index-1 text-center">
                        <img class="tg-banner-shape" src="{{ asset('frontend/assets/img/shape/star-3.png') }}"
                            alt="shape">
                        <h4 class="tg-banner-subtitle mb-10">
                            {{ getTranslatedValue($theme2_banner, 'sub_title') }}
                        </h4>
                        <h2 class="tg-banner-title mb-25">
                            {{ getTranslatedValue($theme2_banner, 'title') }}
                        </h2>
                        <div class="tg-banner-btn">
                            <a href="{{ getTranslatedValue($theme2_banner, 'button_url') }}"
                                class="tg-btn tg-btn-switch-animation">
                                <span class="d-flex align-items-center justify-content-center">
                                    <span
                                        class="btn-text">{{ getTranslatedValue($theme2_banner, 'button_text') }}</span>
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
                <div class="col-lg-8">
                    <div class="tg-banner-3-big-content text-center include-bg"
                        data-background="{{ asset(getSingleImage($theme2_banner, 'background_image')) }}">
                        <h2>{{ getTranslatedValue($theme2_banner, 'right_side_title_1') }}</h2>
                        <span class="d-none d-sm-block">
                            <svg width="322" height="23" viewBox="0 0 322 23" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 15C25.5 12.6667 84.9106 17 108 17C186 17 266 32 320 2"
                                    stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                            </svg>
                        </span>
                        <h2>{{ getTranslatedValue($theme2_banner, 'right_side_title_2') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="tg-banner-transparent-bg"></span>
    <!-- tg-banner-area-end -->
@endif
