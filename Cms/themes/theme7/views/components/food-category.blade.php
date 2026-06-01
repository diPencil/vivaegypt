@php
    $theme7_food_category = getContent('theme7_food_category.content', true);
    $home7_destination_items = popularDestinations(4, false);
@endphp

<!-- tg-foods-area-start -->
<div class="tg-foods-area pt-135 fix pb-90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tg-about-section-title text-center mb-45">
                    <h5 class="tg-section-subtitle wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".6s">
                        {{ getTranslatedValue($theme7_food_category, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".7s">
                        {!! strip_tags(clean(getTranslatedValue($theme7_food_category, 'title')), '<br>') !!}
                    </h2>
                </div>
            </div>
        </div>
        <div
            class="row gx-30 row-cols-xl-5 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center align-items-center">
            @if ($home7_destination_items != null && $home7_destination_items->count() > 0)
                @foreach ($home7_destination_items as $key => $destination_item)
                    <div class="col wow fadeInUp" data-wow-delay=".7s" data-wow-duration="1s">
                        <div class="tg-foods-wrap text-center mb-30">
                            <div class="fix tg-foods-thumb mb-15">
                                <img src="{{ asset($destination_item->image) }}"
                                    alt="{{ $destination_item->name }}">
                            </div>
                            <h3 class="w-100 tg-foods-title">
                                <a
                                    href="{{ route('front.tourbooking.services', ['destination_id' => $destination_item->id, 'destination' => $destination_item->name]) }}">
                                    {{ $destination_item->name }}
                                    <span>({{ $destination_item->services_count }})</span>
                                </a>
                            </h3>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
<!-- tg-foods-area-end -->

@push('style_section')
    <style>
        .tg-foods-thumb img {
            height: 201px;
            width: 201px;
        }
    </style>
@endpush
