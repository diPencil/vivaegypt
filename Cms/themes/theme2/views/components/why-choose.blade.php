@php
    $home2_why_choose = getContent('theme2_why_choose.content', true);
    $translatedSlides = getTranslatedSlides($home2_why_choose, 'slides');
@endphp

@if ($home2_why_choose)
    <!-- tg-chose-area-start -->
    <div class="tg-chose-area pt-135 pb-120 p-relative z-index-9">
        <img class="tg-chose-2-shape d-none d-lg-block" src="{{ asset('frontend/assets/img/shape/brige.png') }}" alt="shape">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tg-chose-section-title text-center mb-30">
                        <h5 class="tg-section-subtitle wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".6s">
                            {{ getTranslatedValue($home2_why_choose, 'sub_title') }}
                        </h5>
                        <h2 class="mb-15 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".7s">
                            {{ getTranslatedValue($home2_why_choose, 'title') }}
                        </h2>
                        <p class="text-capitalize wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".8s">
                            {!! strip_tags(clean(getTranslatedValue($home2_why_choose, 'description')), '<br>') !!}
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
                                <img class="tg-chose-2-box-shape"
                                    src="{{ asset('frontend/assets/img/shape/star-4.png') }}" alt="shape">

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
