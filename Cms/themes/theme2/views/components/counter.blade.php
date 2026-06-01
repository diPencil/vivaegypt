@php
    $theme2_counter = getContent('theme2_counter.content', true);
    $translatedSlides = getTranslatedSlides($theme2_counter, 'slides');
@endphp

@if (count($translatedSlides) > 0)
    <!-- tg-counter-area-start -->
    <div class="tg-counter-area pb-90">
        <div class="container">
            <div class="row">
                @foreach ($translatedSlides as $key => $slide)
                    <div class="col-lg-3 col-md-6 col-sm-6  mb-30">
                        <div class="tg-counter-item d-flex align-items-center">
                            @isset($slide['icon'])
                                <span class="tg-counter-icon d-inline-block mr-20">
                                    <img src="{{ asset($slide['icon']) }}" alt="">
                                </span>
                            @endisset
                            <div class="tg-counter-content p-relative">
                                <h2 class="tg-counter-title count"><span class="odometer" data-count="{{ $slide['number'] }}"></span>{{ $slide['number_suffix'] }}</h2>
                                <span class="tg-counter-subtitle">
                                    {{ $slide['title'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- tg-counter-area-end -->
@endif

