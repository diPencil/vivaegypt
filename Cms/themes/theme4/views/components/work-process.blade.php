@php
    $theme4_work_process = getContent('theme4_work_process.content', true);
    $translatedSlides = getTranslatedSlides($theme4_work_process, 'slides');
@endphp

@if ($theme4_work_process)
    <!-- tp-process-area-start -->
    <div class="tp-process-area include-bg pb-90 pt-120" data-background="{{ asset('frontend/assets/img/shape/work-bg.jpeg') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="tg-process-content mb-30 wow fadeInLeft" data-wow-delay=".4s" data-wow-duration=".9s">
                        <h5 class="tg-section-su-subtitle su-subtitle-2 mb-15">
                            {{ getTranslatedValue($theme4_work_process, 'sub_title') }}
                        </h5>
                        <h2 class="tg-section-su-title text-capitalize mb-15">
                            {!! strip_tags(clean(getTranslatedValue($theme4_work_process, 'title')), '<br>') !!}
                        </h2>
                        <p class="tg-section-su-para tg-section-su-para-2 mb-25">
                            {!! strip_tags(clean(getTranslatedValue($theme4_work_process, 'description')), '<br>') !!}
                        </p>
                        <a href="{{ getTranslatedValue($theme4_work_process, 'button_url') }}" class="tg-btn tg-btn-transparent">{{ getTranslatedValue($theme4_work_process, 'button_text') }}</a>
                    </div>
                </div>
                @if (count($translatedSlides) > 0)
                    <div class="col-lg-6">
                        <div class="tg-process-list mb-10 wow fadeInRight" data-wow-delay=".4s" data-wow-duration=".9s">
                            @foreach ($translatedSlides as $key => $slide)
                                <div class="tg-chose-list d-flex mb-20">
                                    @isset($slide['icon'])
                                        <span class="tg-chose-list-icon mr-20">
                                            <img src="{{ asset($slide['icon']) }}" alt="">
                                        </span>
                                    @endisset
                                    <div class="tg-chose-list-content">
                                        <h4 class="tg-chose-list-title mb-5">
                                            {{ $slide['title'] }}
                                        </h4>
                                        <p>
                                            {{ $slide['short_description'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- tp-process-area-end -->
@endif
