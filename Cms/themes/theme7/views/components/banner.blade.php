@php
    $theme7_banner = getContent('theme7_banner.content', true);
@endphp

<!-- banner-area-start -->
<div class="tg-banner-area tg-banner-5-space fix  include-bg" data-background="{{ asset(getSingleImage($theme7_banner, 'background_image')) }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="tg-banner-5-content text-center">
                    <h2 class="tg-banner-5-title mb-15 wow fadeInUp" data-wow-delay=".4s" data-wow-duration="1s">
                        <span class="p-relative">
                            {{ getTranslatedValue($theme7_banner, 'sub_title') }}
                            <svg class="svgs d-none d-lg-block" width="483" height="35" viewBox="0 0 483 35"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.25 22.8999C37.75 19.3999 126.866 25.8999 161.5 25.8999C278.5 25.8999 398.5 48.3999 479.5 3.3999"
                                    stroke="white" stroke-width="6" stroke-linecap="round" />
                            </svg>
                        </span>
                        <span>
                            {{ getTranslatedValue($theme7_banner, 'title') }}
                        </span>
                    </h2>
                    <div class="tg-banner-5-btn text-center wow fadeInUp" data-wow-delay=".5s" data-wow-duration="1s">
                        <a href="{{ getTranslatedValue($theme7_banner, 'button_url') }}" class="tg-btn tg-btn-switch-animation">
                            <span class="d-flex align-items-center justify-content-center">
                                <span class="btn-text">
                                    {{ getTranslatedValue($theme7_banner, 'button_text') }}
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
<!-- banner-area-end -->
