@php
    use Modules\Testimonial\App\Models\Testimonial;

    $theme3_testimonial = getContent('theme3_testimonial.content', true);
    $testimonials = Testimonial::with('translate')->where('status', 'active')->latest()->get();
@endphp


@if ($testimonials->count() > 0)
    <!-- td-testimonial-area-start -->
    <div class="tg-testimonial-area tg-testimonial-su-wrap p-relative pt-160 pb-50">
        <img class="tg-testimonial-su-shape d-none d-xxl-block" src="{{ asset('frontend/assets/img/shape/hill-2.png') }}" alt="">
        <img class="tg-testimonial-su-shape-2 d-none d-lg-block" src="{{ asset('frontend/assets/img/shape/parasut-2.png') }}"
            alt="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="tg-testimonial-4-wrap">
                        <div class="row justify-content-center">
                            <div class="tg-testimonial-qoute-wrap text-center mb-25">
                                <span>
                                    <svg width="60" height="44" viewBox="0 0 60 44" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.28571 44H17.1429L25.7143 26.4V0H0V26.4H12.8571L4.28571 44ZM38.5714 44H51.4286L60 26.4V0H34.2857V26.4H47.1429L38.5714 44Z"
                                            fill="#7C37FF" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-10">
                                <div class="swiper-container tg-testimonial-4-thumb-active mb-25 fix p-relative">
                                    <div class="swiper-wrapper">
                                        @foreach ($testimonials as $key => $testimonial)
                                            <div class="swiper-slide">
                                                <div class="tg-testimonial-4-slider-thumb">
                                                    <img src="{{ $testimonial?->image }}" alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-container tg-testimonial-4-slide-active p-relative fix pb-20">
                            <div class="swiper-wrapper">
                                @foreach ($testimonials as $key => $testimonial)
                                    <div class="swiper-slide">
                                        <div class="tg-testimonial-4-content-wrap">
                                            <div class="tg-testimonial-4-clients text-center">
                                                <h5 class="tg-testimonial-4-name mb-0">
                                                    {{ $testimonial?->translate?->name }}</h5>
                                                <span
                                                    class="d-inline-block mb-10">{{ $testimonial?->translate?->designation }}</span>
                                                <div class="tg-ratting-star mb-20">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $testimonial->rating)
                                                            <span class="active"><i
                                                                    class="fa-sharp fa-solid fa-star"></i></span>
                                                            <!-- Filled star -->
                                                        @else
                                                            <span><i class="fa-sharp fa-solid fa-star"></i></span>
                                                            <!-- Empty star -->
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p>“ {{ $testimonial?->translate?->comment }} ”</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if (getTranslatedValue($theme3_testimonial, 'show_navigation') == '1')
                                <div class="tg-testimonial-4-slider-navigation">
                                    <button class="tg-testimonial-4-slide-next"><i
                                            class="fa-solid fa-arrow-right-long"></i></button>
                                    <button class="tg-testimonial-4-slide-prev"><i
                                            class="fa-solid fa-arrow-left-long"></i></button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- td-testimonial-area-end -->

    @push('style_section')
        <style>
            .tg-ratting-star span i {
                color: #ded9ce;
                font-size: 18px;
            }

            .tg-ratting-star span.active i {
                color: #ffb930;
            }

            .tg-testimonial-4-slider-thumb img {
                height: 65px;
            }
        </style>
    @endpush

@endif
