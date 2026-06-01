@php
    $theme4_destination = getContent('theme4_destination.content', true);
    $home4_destination_items = popularDestinations(6, false);
@endphp

<!-- tg-location-area-start -->
<div class="tg-location-area tg-location-su-2-wrap fix pt-120 pb-90 p-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="tg-location-section-title-wrap text-center mb-40">
                    <h5 class="tg-section-su-subtitle su-subtitle-2 mb-15 wow fadeInUp" data-wow-delay=".4s"
                        data-wow-duration=".9s">
                        {{ getTranslatedValue($theme4_destination, 'sub_title') }}
                    </h5>
                    <h2 class="tg-section-su-title text-capitalize wow fadeInUp mb-15" data-wow-delay=".5s"
                        data-wow-duration=".9s">
                        {{ getTranslatedValue($theme4_destination, 'title') }}
                    </h2>
                </div>
            </div>
        </div>

        @if ($home4_destination_items->count() > 0)
            <div class="row gx-30">
                @foreach ($home4_destination_items as $key => $destination_item)
                    <div @class([
                        'col-lg-4 col-md-6 mb-30',
                        'col-xl-6' => $key == 2 || $key == 3,
                        'col-xl-3' => $key != 2 && $key != 3,
                    ])>
                        <div class="tg-location-3-wrap tg-location-su-wrap p-relative tg-round-25 wow fadeInUp"
                            data-wow-delay=".{{$key + 3}}s" data-wow-duration=".9s">
                            <div class="tg-location-thumb tg-round-25">
                                <img class="w-100 tg-round-25"
                                    src="{{ asset($destination_item->image) }}"
                                    alt="{{ $destination_item->localized_name }}">
                            </div>
                            <div class="tg-location-content tg-location-su-content">
                                <div class="content">
                                    <h3 class="tg-location-title mb-5"><a
                                            href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->localized_name]) }}">
                                            {{ $destination_item->localized_name }}
                                        </a>
                                    </h3>
                                </div>
                                <a class="icons"
                                    href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->localized_name]) }}">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 13.0969L13.0969 2M13.0969 2H2M13.0969 2V13.0969"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
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
        .tg-location-su-wrap .tg-location-thumb img {
            height: 324px;
        }
    </style>
@endpush
