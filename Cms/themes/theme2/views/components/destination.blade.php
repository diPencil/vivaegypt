@php
    $home2_destination = getContent('theme2_destination.content', true);
    $home2_destination_items = popularDestinations();
@endphp

<!-- tg-destination-area-start -->
<div class="tg-destination-area pt-60 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tg-destination-section-title text-center mb-40">
                    <h5 class="tg-section-subtitle wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".6s">
                        {{ getTranslatedValue($home2_destination, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".7s">
                        {{ getTranslatedValue($home2_destination, 'title') }}
                    </h2>
                    <p class="text-capitalize wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".8s">
                        {!! strip_tags(clean(getTranslatedValue($home2_destination, 'description')), '<br>') !!}
                    </p>
                </div>
            </div>
            @if ($home2_destination_items->count() > 0)
                @foreach ($home2_destination_items as $key => $destination_item)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="tg-destination-item mb-30 wow fadeInUp" data-wow-delay=".{{ $key + 3 }}s"
                            data-wow-duration=".6s">
                            <div class="tg-destination-thumb fix p-relative">
                                <img class="w-100"
                                    src="{{ asset($destination_item->image) }}"
                                    alt="{{ $destination_item->localized_name }}">
                                <div class="tg-listing-2-mask">
                                    <img class="w-100"
                                        src="{{ asset('frontend/assets/img/shape/destination-shape.png') }}">
                                </div>
                            </div>
                            <div class="tg-destination-content text-center">
                                <div class="tg-destination-meta">
                                    <a
                                        href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->localized_name]) }}">{{ $destination_item->localized_name }}</a>
                                </div>
                                @if ($destination_item->tags)
                                    <div class="tg-destination-tag">
                                        @foreach (explode(',', $destination_item->tags) as $key => $tag)
                                            <span>{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- tg-destination-area-end -->

@push('style_section')
    <style>
        .tg-destination-thumb {
            height: 203px;
        }

        .tg-listing-card-thumb {
            height: 180px;
        }
    </style>
@endpush
