@php
    $theme5_destination = getContent('theme5_destination.content', true);
    $home5_destination_items = popularDestinations(4, false);
@endphp

<!-- tg-location-area-start -->
<div class="tg-location-area p-relative pb-125 pt-135">
    <img class="tg-location-shape shape-3 d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/tower.png') }}"
        alt="shape">
    <img class="tg-testimonial-2-shape-1 p-absolute d-none d-lg-block"
        src="{{ asset('frontend/assets/img/shape/parasut.png') }}" alt="">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-9">
                <div class="tg-location-section-title mb-40">
                    <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                        {{ getTranslatedValue($theme5_destination, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme5_destination, 'title')), '<br>') !!}
                    </h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="tg-location-3-btn text-end wow fadeInUp mb-40" data-wow-delay=".6s" data-wow-duration=".9s">
                    <a href="{{ getTranslatedValue($theme5_destination, 'button_url') }}"
                        class="tg-btn tg-btn-gray tg-btn-switch-animation">
                        <span class="d-flex align-items-center justify-content-center">
                            <span class="btn-text">{{ getTranslatedValue($theme5_destination, 'button_text') }}</span>
                            <span class="btn-icon ml-5">
                                <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                        stroke="currentColor" stroke-width="1.77778" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="btn-icon ml-5">
                                <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.0017 8.00001H19.9514M19.9514 8.00001L12.9766 1.02515M19.9514 8.00001L12.9766 14.9749"
                                        stroke="currentColor" stroke-width="1.77778" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        @if ($home5_destination_items->count() > 0)
            <div class="row">
                @foreach ($home5_destination_items as $key => $destination_item)
                    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay=".{{ $key + 3 }}s"
                        data-wow-duration=".9s">
                        <div class="tg-location-3-wrap p-relative mb-30 tg-round-25">
                            <div class="tg-location-thumb tg-round-25">
                                <img class="w-100 tg-round-25"
                                    src="{{ asset($destination_item->image) }}"
                                    alt="{{ $destination_item->localized_name }}">
                            </div>
                            <div class="tg-location-content text-center">
                                <span class="tg-location-time">
                                    {{ $destination_item->services_count }}
                                    {{ $destination_item->services_count > 1 ? __('translate.Tours') : __('translate.Tour') }}</span>
                                <h3 class="tg-location-title mb-0"><a
                                        href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->localized_name]) }}">
                                        {{ $destination_item->localized_name }}
                                    </a>
                                </h3>
                            </div>
                            <div class="tg-location-border"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- tg-location-area-end -->

@push('style_section')
    <style>
        .tg-location-thumb {
            height: 340px;
        }
        .tg-location-thumb img{
            height: 100%;
        }
    </style>
@endpush
