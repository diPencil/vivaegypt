@php
    $theme3_why_choose = getContent('theme3_why_choose.content', true);
    $translatedSlides = getTranslatedSlides($theme3_why_choose, 'slides');
@endphp

@if ($theme3_why_choose)
    <!-- tg-chose-area-start -->
    <div class="tg-chose-area tg-chose-su-wrap pt-100 pb-105 p-relative z-index-9">
        <img class="tg-chose-2-shape d-none d-lg-block" src="{{ asset('frontend/assets/img/shape/brige.png') }}" alt="shape">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="tg-chose-section-title text-center mb-40">
                        <h5 class="tg-section-su-subtitle su-subtitle-2 mb-20 wow fadeInUp" data-wow-delay=".4s"
                            data-wow-duration=".9s">
                            {{ getTranslatedValue($theme3_why_choose, 'sub_title') }}
                        </h5>
                        <h2 class="tg-section-su-title text-capitalize wow fadeInUp mb-15" data-wow-delay=".5s"
                            data-wow-duration=".9s">
                            {{ getTranslatedValue($theme3_why_choose, 'title') }}
                        </h2>
                        <p class="tg-section-su-para tg-section-su-para-2 mb-10">
                            {!! strip_tags(clean(getTranslatedValue($theme3_why_choose, 'description')), '<br>') !!}
                        </p>
                    </div>
                </div>
            </div>
            @if (count($translatedSlides) > 0)
                <div class="row">
                    @foreach ($translatedSlides as $key => $slide)
                        @php
                            $delay = 0.4 + $key * 0.2;

                            if ($key == 0) {
                                $imageFade = 'fadeInLeft';
                                $boxFade = 'fadeInUp';
                            } elseif ($key == 1) {
                                $imageFade = 'fadeInRight';
                                $boxFade = 'fadeInLeft';
                            } elseif ($key == 2) {
                                $imageFade = 'fadeInUp';
                                $boxFade = 'fadeInRight';
                            } else {
                                $imageFade = 'fadeInLeft';
                                $boxFade = 'fadeInUp';
                            }

                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-25">
                            <div class="tg-chose-2-thumb h-100 wow {{ $imageFade }}"
                                data-wow-delay="{{ $delay }}s" data-wow-duration=".6s">
                                <img class="w-100 h-100" src="{{ asset($slide['image']) }}" alt="chose">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-25">
                            <div class="tg-chose-2-content p-relative text-center z-index-1 wow {{ $boxFade }}"
                                data-wow-delay="{{ $delay }}s" data-wow-duration=".6s">
                                <span class="tg-chose-2-box-shape">
                                    <svg width="62" height="57" viewBox="0 0 62 57" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M83.0149 6.0725L59.8978 44.6152M83.0149 6.0725L44.4722 29.1896M83.0149 6.0725L48.8307 40.2567M59.8978 44.6152L83.0149 83.158M59.8978 44.6152L62.248 48.7173L79.2974 44.6152L62.3762 40.3849L59.8978 44.6152ZM59.8978 44.6152L50.7108 44.6152M83.0149 83.158L44.4722 60.0409M83.0149 83.158L48.8307 48.9737M44.4722 60.0409L5.92945 83.158M44.4722 60.0409L48.5743 62.391L44.4722 79.4404L40.2419 62.5192L44.4722 60.0409ZM44.4722 60.0409L44.4722 50.8539M5.92945 83.158L29.0465 44.6152M5.92945 83.158L40.1137 48.9737M29.0465 44.6152L5.92944 6.07251M29.0465 44.6152L26.5682 40.3849L9.64698 44.6152L26.5682 48.8455L29.0465 44.6152ZM29.0465 44.6152L38.2335 44.6152M5.92944 6.07251L44.4722 29.1896M5.92944 6.07251L40.1137 40.2567M44.4722 29.1896L40.2419 26.7112L44.4722 9.79004L48.7025 26.7112L44.4722 29.1896ZM44.4722 29.1896L44.4722 38.3766M48.8307 40.2567C51.2236 42.6496 51.2449 46.5595 48.8307 48.9737M48.8307 40.2567C46.4378 37.8638 42.5066 37.8638 40.1137 40.2567M48.8307 48.9737C46.4378 51.3666 42.5279 51.388 40.1137 48.9737M40.1137 48.9737C37.7208 46.5808 37.6994 42.671 40.1137 40.2567M8.92057 67.9887C-0.394638 53.9304 -0.266448 35.4282 8.92056 21.2418M67.8456 80.1668C53.7874 89.482 35.2852 89.3539 21.0987 80.1668M80.0238 21.2418C89.339 35.3 89.2108 53.8022 80.0238 67.9887M21.0987 9.06363C35.157 -0.251579 53.6592 -0.123389 67.8456 9.06362"
                                            stroke="#E8E4F0" stroke-width="3.33289" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                @isset($slide['icon'])
                                    <div class="tg-chose-2-icon mb-20">
                                        <img src="{{ asset($slide['icon']) }}" alt="icon">
                                    </div>
                                @endisset
                                <h4 class="tg-chose-2-title mb-15">
                                    <a href="{{ $slide['link'] ?? '#' }}">
                                        {{ $slide['title'] }}
                                    </a>
                                </h4>
                                @isset($slide['description'])
                                    <p>{{ $slide['description'] }}</p>
                                @endisset
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- tg-chose-area-end -->
@endif

@push('style_section')
    <style>
        .tg-chose-2-icon img {
            width: 65px;
            height: 65px;
        }
    </style>
@endpush
