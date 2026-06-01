@php
    $theme7_destination = getContent('theme7_destination.content', true);
    $home7_destination_items = popularDestinations(8, false);
@endphp

<!-- tg-location-area-start -->
<div class="tg-location-area pt-135 pb-130 tg-grey-bg p-relative z-index-1">
    <img class="tg-location-shape d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/tower.png') }}"
        alt="">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-9">
                <div class="tg-location-section-title mb-40">
                    <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                        {{ getTranslatedValue($theme7_destination, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme7_destination, 'title')), '<br>') !!}
                    </h2>
                </div>
            </div>

            @if (getTranslatedValue($theme7_destination, 'show_navigation') == '1')
                <div class="col-lg-3">
                    <div class="tg-listing-5-slider-navigation text-end mb-50 wow fadeInUp" data-wow-delay=".4s"
                        data-wow-duration="1s">
                        <button class="tg-listing-5-slide-prev"><i class="fa-solid fa-arrow-left-long"></i></button>
                        <button class="tg-listing-5-slide-next"><i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
            @endif
        </div>
        @if ($home7_destination_items != null && $home7_destination_items->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container tg-location-5-slider p-relative fix">
                        <div class="swiper-wrapper">
                            @foreach ($home7_destination_items as $key => $destination_item)
                                <div class="swiper-slide">
                                    <div class="tg-location-5-wrap p-relative">
                                        <div class="tg-location-5-thumb bg-white p-relative rounded-circale">

                                            <img class="w-100"
                                                src="{{ asset($destination_item->image) }}"
                                                alt="{{ $destination_item->localized_name }}">

                                            <span class="tg-location-5-bottom-bg"></span>
                                            <div class="tg-location-5-inner p-absolute">
                                                <div class="tg-location-5-content text-center">
                                                    <h4 class="mb-0 lh-1">
                                                        <a
                                                            href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->localized_name]) }}">
                                                            {{ $destination_item->localized_name }}
                                                        </a>
                                                    </h4>
                                                    <span>
                                                        {{ $destination_item->services_count }}
                                                        {{ $destination_item->services_count > 1 ? __('translate.Tours') : __('translate.Tour') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- tg-location-area-end -->

@push('style_section')
    <style>
        .tg-location-5-thumb {

            height: 270px;
            width: 270px;
        }
    </style>
@endpush
