@php
    $theme6_hero = getContent('theme6_hero.content', true);
@endphp

<!-- tg-hero-area-start -->
<div class="tg-hero-area tg-hero-4-space fix p-relative include-bg" data-background="{{ asset(getSingleImage($theme6_hero, 'background_image'))}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tg-hero-4-content text-center">
                    <h4 class="tg-hero-3-subtitle tg-hero-4-subtitle">
                        {{ getTranslatedValue($theme6_hero, 'sub_title') }}
                    </h4>
                    <h2 class="tg-hero-3-title tg-hero-4-title">
                        {{ getTranslatedValue($theme6_hero, 'title') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    
    {{-- booking section --}}
    @include('theme::components.booking-form')

    <div class="tg-hero-bottom-shape d-none d-lg-block">
        <span>
            <svg width="432" height="298" viewBox="0 0 432 298" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="line-1" opacity="0.4"
                    d="M39.6062 428.345C4.4143 355.065 -24.2999 203.867 142.379 185.309C350.726 162.111 488.895 393.541 289.171 313.515C129.391 249.494 458.204 85.4772 642.582 11.4713"
                    stroke="white" stroke-width="24" />
            </svg>
        </span>
    </div>
    <div class="tg-hero-bottom-shape-2 d-none d-lg-block">
        <span>
            <svg width="154" height="321" viewBox="0 0 154 321" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="line-1" opacity="0.4"
                    d="M144.616 328.905C116.117 300.508 62.5986 230.961 76.5162 179.949C93.9132 116.184 275.231 7.44493 -65.0181 12.8762"
                    stroke="white" stroke-width="24" />
            </svg>
        </span>
    </div>
</div>
<!-- tg-hero-area-end -->
