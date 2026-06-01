<div class="tg-listing-card-item tg-listing-4-card-item mb-25">
    <div class="tg-listing-card-thumb tg-listing-2-card-thumb mb-15 fix p-relative">
        <a href="{{ route('front.tourbooking.services.show', ['slug' => $service?->slug]) }}">
            @if($service?->thumbnail?->file_path)
                <img class="tg-card-border w-100" src="{{ asset($service?->thumbnail?->file_path) }}" alt="{{ $service?->thumbnail?->caption ?? $service?->translation?->title }}">
            @elseif($service?->image)
                <img class="tg-card-border w-100" src="{{ asset($service?->image) }}" alt="{{ $service?->translation?->title }}">
            @else
                <img class="tg-card-border w-100" src="{{ asset('uploads/website-images/placeholder.png') }}" alt="{{ $service?->translation?->title }}">
            @endif
        </a>
        <div class="tg-listing-2-price">
            {!! $service->price_display !!}
        </div>
    </div>
    <div class="tg-listing-card-content p-relative">
        <h4 class="tg-listing-card-title mb-5">
            <a href="{{ route('front.tourbooking.services.show', ['slug' => $service?->slug]) }}">
                {{ Str::limit($service?->translation?->title, 45) }}
            </a>
        </h4>
        <span class="tg-listing-card-duration-map d-inline-block">
            <i class="fa-solid fa-location-dot"></i> {{ $service?->location }}
        </span>
        @include('tourbooking::front.services.ratting', [
            'avgRating' => $service?->active_reviews_avg_rating ?? 0,
            'ratingCount' => $service?->active_reviews_count ?? 0
        ])
    </div>
</div>
