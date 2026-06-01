@php
    $theme3_ads = getContent('theme3_ads.content', true);
@endphp

<!-- tg-ads-area-start -->
<div class="tg-ads-area tg-ads-su-space p-relative z-index-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-30 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".6s">
                <div class="tg-ads-wrap-3 tg-ads-su-wrapper include-bg fix"
                    data-background="{{ asset(getTranslatedValue($theme3_ads, 'left_side_image')) }}">
                    <div class="tg-ads-content-2">
                        <div class="tg-ads-discount-inner mb-20">
                            <span class="travel">{{ getTranslatedValue($theme3_ads, 'sub_title') }}</span>
                            <div class="tg-ads-discount d-flex align-items-center">
                                <h2 class="mb-0 mr-5">{{ getTranslatedValue($theme3_ads, 'title') }}</h2>
                                <div>
                                    {!! getTranslatedValue($theme3_ads, 'description', '<p></p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="tg-ads-btn">
                            <a href="{{ getTranslatedValue($theme3_ads, 'button_url') }}" class="tg-btn">
                                {{ getTranslatedValue($theme3_ads, 'button_text') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-30 wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".6s">
                <div class="tg-ads-su-wrap h-100">
                    <img class="w-100 h-100" src="{{ asset(getTranslatedValue($theme3_ads, 'right_side_image')) }}"
                        alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- tg-ads-area-end -->
