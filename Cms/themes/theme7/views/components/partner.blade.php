@php
    use Modules\Partner\App\Models\Partner;

    $partners = Partner::latest()->get();
@endphp

@if ($partners->count() > 0)

    <!-- brands-area-start -->
    <div class="tg-brand-area pb-115 z-index-1">
        <div class="container">
            <div class="row">
                <div class="tg-brand-wrap">
                    <div class="swiper-container tg-brand-slide fix">
                        <div class="swiper-wrapper slide-transtion">
                            @foreach ($partners as $key => $partner)
                                <div class="swiper-slide">
                                    <div class="tg-brand-items">
                                        <a href="{{ $partner?->link ?? '#' }}">
                                            <img src="{{ $partner?->logo }}" alt="logo">
                                        </a>
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
