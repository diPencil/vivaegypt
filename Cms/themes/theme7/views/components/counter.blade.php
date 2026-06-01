@php
    $theme7_counter = getContent('theme7_counter.content', true);
    $translatedSlides = getTranslatedSlides($theme7_counter, 'slides');
@endphp

@if (count($translatedSlides) > 0)

    <!-- tg-counter-area-start -->
    <div class="tg-counter-area tg-counter-5-border pb-65 pt-95">
        <div class="container">
            <div class="row">
                @foreach ($translatedSlides as $key => $slide)
                    <div class="col-lg-3 col-md-6 col-sm-6  mb-30">
                        <div class="tg-counter-item d-flex align-items-center">
                            <span class="tg-counter-icon d-inline-block mr-20">
                                @isset($slide['icon'])
                                    <img src="{{ asset($slide['icon']) }}" alt="">
                                @endisset
                            </span>
                            <div class="tg-counter-content p-relative">
                                <h2 class="tg-counter-title count"><span class="odometer"
                                        data-count="{{ $slide['number'] }}"></span>{{ $slide['number_suffix'] }}</h2>
                                <span class="tg-counter-subtitle">{{ $slide['title'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- tg-counter-area-end -->

@endif
