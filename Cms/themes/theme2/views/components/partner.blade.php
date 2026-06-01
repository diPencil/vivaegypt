@php
    use Modules\Partner\App\Models\Partner;

    $partners = Partner::latest()->get();
@endphp


@if ($partners->count() > 0)
    <!-- brands-area-start -->
    <div class="tg-brand-area tg-grey-bg pb-80 p-relative z-index-1">
        <img class="tg-brand-shape" src="{{ asset('frontend/assets/img/shape/pyramid-2.png') }}" alt="">
        <img class="tg-brand-shape-2" src="{{ asset('frontend/assets/img/shape/hill.png') }}" alt="">
        <div class="container">
            <div class="row">
                <div class="tg-brand-wrap">
                    <div class="swiper-container tg-brand-slide fix">
                        <div class="swiper-wrapper slide-transtion">
                            @foreach ($partners as $key => $partner)
                                <div class="swiper-slide">
                                    <div class="tg-brand-items">
                                        <a href="{{ $partner?->link ?? '#' }}"><img src="{{ $partner?->logo }}"
                                                alt="logo"></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brands-area-end -->
@endif
