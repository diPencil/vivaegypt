@php
    $theme6_banner = getContent('theme6_banner.content', true);
@endphp

<!-- tg-banner-area-start -->
<span class="tg-banner-transparent-bg tg-grey-bg"></span>
<div class="tg-banner-area tg-banner-space-3 p-relative z-index-9">
    <div class="container">
        <div class="row gx-0">
            <div class="col-lg-4">
                <div class="tg-banner-content tg-banner-3-content banner-3 p-relative z-index-1 text-center">
                    <img class="tg-banner-shape" src="{{ asset('frontend/assets/img/shape/star-3.png') }}" alt="shape">
                    <h4 class="tg-banner-subtitle mb-10">
                        {{ getTranslatedValue($theme6_banner, 'sub_title') }}
                    </h4>
                    <h2 class="tg-banner-title mb-25">
                        {!! strip_tags(clean(getTranslatedValue($theme6_banner, 'title')), '<br>') !!}
                    </h2>
                    <div class="tg-banner-btn">
                        <a href="{{ getTranslatedValue($theme6_banner, 'button_url') }}"
                            class="tg-btn tg-btn-switch-animation">
                            <span class="d-flex align-items-center justify-content-center">
                                <span class="btn-text">{{ getTranslatedValue($theme6_banner, 'button_text') }}</span>
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
                <div class="tg-banner-3-big-content banner-3 text-center include-bg"
                    data-background="{{ asset(getSingleImage($theme6_banner, 'background_image')) }}">
                    <h2>{{ getTranslatedValue($theme6_banner, 'right_side_title_1') }}</h2>
                    <span class="d-none d-sm-block">
                        <svg width="322" height="23" viewBox="0 0 322 23" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 15C25.5 12.6667 84.9106 17 108 17C186 17 266 32 320 2" stroke="currentColor"
                                stroke-width="4" stroke-linecap="round" />
                        </svg>
                    </span>
                    <h2>{{ getTranslatedValue($theme6_banner, 'right_side_title_2') }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tg-banner-area-end -->
