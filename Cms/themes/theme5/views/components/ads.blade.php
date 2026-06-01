@php
    $theme5_ads = getContent('theme5_ads.content', true);
    $theme5_ads_slides = getTranslatedSlides($theme5_ads, 'slides');
@endphp

@if (count($theme5_ads_slides) > 0)
    <!-- tg-ads-area-start -->
    <div class="tg-ads-area tg-ads-space p-relative z-index-1">
        <div class="container">
            <div class="row">
                @foreach ($theme5_ads_slides as $key => $slide)
                    @if ($key == 0)
                        <div class="col-lg-4 col-md-6 mb-30">
                            <div class="tg-ads-wrap include-bg fix" data-background="{{ asset($slide['image']) }}">
                                <div class="row">
                                    <div class="col-xl-6 col-4"></div>
                                    <div class="col-xl-6 col-8">
                                        <div class="tg-ads-content text-center ml-20">
                                            <div class="tg-ads-upto p-relative text-center mb-30">
                                                <h2 class="mb-0">
                                                    {!! strip_tags(clean($slide['title']), '<br>') !!}
                                                </h2>
                                                {!! $slide['description'] !!}
                                            </div>
                                            @if (isset($slide['button_text']) && isset($slide['button_url']))
                                                <div class="tg-ads-btn">
                                                    <a href="{{ $slide['button_url'] }}"
                                                        class="tg-btn tg-btn-switch-animation">
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <span class="btn-text">{{ $slide['button_text'] }}</span>
                                                            <span class="btn-icon ml-5">
                                                                <svg width="13" height="11" viewBox="0 0 13 11"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M0.998677 5.49986H12.3685M12.3685 5.49986L8.18359 1.31494M12.3685 5.49986L8.18359 9.68478"
                                                                        stroke="white" stroke-width="1.06667"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            <span class="btn-icon ml-5">
                                                                <svg width="13" height="11" viewBox="0 0 13 11"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M0.998677 5.49986H12.3685M12.3685 5.49986L8.18359 1.31494M12.3685 5.49986L8.18359 9.68478"
                                                                        stroke="white" stroke-width="1.06667"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($key == 1)
                        <div class="col-lg-4 col-md-6 mb-30">
                            <div class="tg-ads-wrap-2 include-bg fix" data-background="{{ asset($slide['image']) }}">
                                <div class="tg-ads-content-2 text-center">
                                    <h5 class="mb-0">
                                        {!! strip_tags(clean($slide['title']), '<br>') !!}
                                    </h5>
                                    <div class="tg-ads-discount-inner d-flex align-items-center justify-content-center">
                                        {!! $slide['description'] !!}
                                    </div>
                                    @if (isset($slide['button_text']) && isset($slide['button_url']))
                                        <a href="{{ $slide['button_url'] }}">
                                            {{ $slide['button_text'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($key == 2)
                        <div class="col-lg-4 col-md-6 mb-30">
                            <div class="tg-ads-wrap-3 include-bg fix" data-background="{{ asset($slide['image']) }}">
                                <div class="tg-ads-content-2">
                                    <div class="tg-ads-discount-inner mb-5">
                                        <h2 class="mb-0">{!! strip_tags(clean($slide['title']), '<br>') !!}</h2>
                                        <div class="tg-ads-discount">
                                            {!! $slide['description'] !!}
                                        </div>
                                    </div>
                                    @if (isset($slide['button_text']) && isset($slide['button_url']))
                                        <div class="tg-ads-btn">
                                            <a href="{{ $slide['button_url'] }}" class="tg-btn tg-btn-switch-animation">
                                                <span class="d-flex align-items-center justify-content-center">
                                                    <span class="btn-text">{{ $slide['button_text'] }}</span>
                                                    <span class="btn-icon ml-5">
                                                        <svg width="13" height="11" viewBox="0 0 13 11"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.998677 5.49986H12.3685M12.3685 5.49986L8.18359 1.31494M12.3685 5.49986L8.18359 9.68478"
                                                                stroke="white" stroke-width="1.06667"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                    <span class="btn-icon ml-5">
                                                        <svg width="13" height="11" viewBox="0 0 13 11"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.998677 5.49986H12.3685M12.3685 5.49986L8.18359 1.31494M12.3685 5.49986L8.18359 9.68478"
                                                                stroke="white" stroke-width="1.06667"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <span class="tg-banner-transparent-bg transparent-bg-2 d-none d-lg-block"></span>
    <!-- tg-ads-area-end -->
@endif
