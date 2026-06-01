@php
    $theme2_package = getContent('theme2_package.content', true);
    $theme2_popular_services = popularServices();
@endphp


<!-- tg-listing-area-start -->
<div class="tg-listing-area tg-grey-bg pt-140 pb-130 p-relative z-index-9">
    <img class="tg-listing-2-shape d-none d-sm-block" src="{{ asset('frontend/assets/img/shape/map-shape-5.png') }}"
        alt="">
    <img class="tg-listing-2-shape-2 d-none d-xl-block" src="{{ asset('frontend/assets/img/shape/stachu.png') }}"
        alt="">
    <img class="tg-listing-2-shape-3 d-none d-sm-block" src="{{ asset('frontend/assets/img/shape/map-shape-6.png') }}"
        alt="">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tg-listing-section-title text-center mb-35">
                    <h5 class="tg-section-subtitle wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".6s">
                        {{ getTranslatedValue($theme2_package, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".7s">
                        {{ getTranslatedValue($theme2_package, 'title') }}
                    </h2>
                    <p class="text-capitalize wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".8s">
                        {!! strip_tags(clean(getTranslatedValue($theme2_package, 'description')), '<br>') !!}
                    </p>
                </div>
            </div>
        </div>
        @if ($theme2_popular_services->count() > 0)
            <div class="row">
                @foreach ($theme2_popular_services as $key => $service)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow fadeInUp"
                        data-wow-delay=".{{ $key + 3 }}s">
                        <div class="tg-listing-card-item tg-listing-2-card-item mb-25">
                            <div class="tg-listing-card-thumb tg-listing-2-card-thumb fix p-relative">
                                <a href="{{ route('front.tourbooking.services.show', ['slug' => $service?->slug]) }}">
                                    <img class="tg-card-border w-100"
                                        src="{{ asset($service?->thumbnail?->file_path) }}"
                                        alt="{{ $service?->thumbnail?->caption ?? $service?->translation?->title }}">

                                    @if ($service?->discount_price || $service?->is_new == 1 || $service?->is_featured == 1)
                                        <div class="tg-listing-2-thumb-badges">
                                            @if ($service?->discount_price)
                                                <span
                                                    class="tg-listing-item-price-discount shape-2"
                                                    style="background-image: url('{{ asset('frontend/assets/img/shape/offter.png') }}')"> {{ __('translate.Sale offer') }} </span>
                                            @endif

                                            @if ($service?->is_new == 1)
                                                <span
                                                    class="tg-listing-item-price-discount shape"
                                                    style="background-image: url('{{ asset('frontend/assets/img/shape/price-shape-2.png') }}')">{{ __('translate.New') }}</span>
                                            @endif

                                            @if ($service?->is_featured == 1)
                                                <span
                                                    class="tg-listing-item-price-discount shape-3"
                                                    style="background-image: url('{{ asset('frontend/assets/img/shape/featured.png') }}')">
                                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.60156 1L0.601562 8.2H6.00156L5.40156 13L11.4016 5.8H6.00156L6.60156 1Z"
                                                            stroke="white" stroke-width="0.857143" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                    {{ __('translate.Featured') }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                </a>
                                <div class="tg-listing-2-mask">
                                    <img class="w-100" src="{{ asset('frontend/assets/img/shape/bottom-round.png') }}">
                                </div>
                                <div @class([
                                    'tg-listing-item-wishlist',
                                    'active' => $service?->my_wishlist_exists == 1,
                                ]) data-url="{{ route('user.wishlist.store') }}"
                                    onclick="addToWishlist({{ $service->id }}, this, 'service')">
                                    <a href="javascript:void(0);">
                                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.5167 16.3416C10.2334 16.4416 9.76675 16.4416 9.48341 16.3416C7.06675 15.5166 1.66675 12.075 1.66675 6.24165C1.66675 3.66665 3.74175 1.58331 6.30008 1.58331C7.81675 1.58331 9.15841 2.31665 10.0001 3.44998C10.8417 2.31665 12.1917 1.58331 13.7001 1.58331C16.2584 1.58331 18.3334 3.66665 18.3334 6.24165C18.3334 12.075 12.9334 15.5166 10.5167 16.3416Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="tg-listing-card-content p-relative">
                                <div class="tg-listing-2-price-wrap text-center">
                                    <div class="tg-listing-2-price">
                                        {!! $service->price_display !!}
                                    </div>
                                </div>
                                <h4 class="tg-listing-card-title">
                                    <a
                                        href="{{ route('front.tourbooking.services.show', ['slug' => $service?->slug]) }}">
                                        {{ Str::limit($service?->translation?->title, 45) }}
                                    </a>
                                </h4>
                                @include('tourbooking::front.services.ratting', [
                                    'avgRating' => $service?->active_reviews_avg_rating ?? 0,
                                    'ratingCount' => $service?->active_reviews_count ?? 0,
                                    'ratingClass' => 'tg-listing-card-review mb-5',
                                ])
                                <div class="tg-listing-card-duration-tour">

                                    @if ($service?->location)
                                        <span class="tg-listing-card-duration-map mb-5">
                                            <svg width="13" height="16" viewBox="0 0 13 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.3329 6.7071C12.3329 11.2324 6.55512 15.1111 6.55512 15.1111C6.55512 15.1111 0.777344 11.2324 0.777344 6.7071C0.777344 5.16402 1.38607 3.68414 2.46962 2.59302C3.55316 1.5019 5.02276 0.888916 6.55512 0.888916C8.08748 0.888916 9.55708 1.5019 10.6406 2.59302C11.7242 3.68414 12.3329 5.16402 12.3329 6.7071Z"
                                                    stroke="currentColor" stroke-width="1.15556" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M6.55512 8.64649C7.61878 8.64649 8.48105 7.7782 8.48105 6.7071C8.48105 5.636 7.61878 4.7677 6.55512 4.7677C5.49146 4.7677 4.6292 5.636 4.6292 6.7071C4.6292 7.7782 5.49146 8.64649 6.55512 8.64649Z"
                                                    stroke="currentColor" stroke-width="1.15556" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            {{ $service?->location }}
                                        </span>
                                    @endif

                                    @if ($service?->duration)
                                        <span class="tg-listing-card-duration-time">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.00175 3.73329V7.99996L10.8462 9.42218M15.1128 8.00003C15.1128 11.9274 11.9291 15.1111 8.00174 15.1111C4.07438 15.1111 0.890625 11.9274 0.890625 8.00003C0.890625 4.07267 4.07438 0.888916 8.00174 0.888916C11.9291 0.888916 15.1128 4.07267 15.1128 8.00003Z"
                                                    stroke="currentColor" stroke-width="1.06667" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            {{ $service?->duration }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- tg-listing-area-end -->

@push('style_section')
    <style>

        .tg-listing-card-review i {
            font-size: 12px;
            color: gray;
        }

        .tg-listing-item-wishlist.active {
            color: var(--tg-theme-primary);
        }
    </style>
@endpush

@push('js_section')
    <script src="{{ asset('frontend/assets/js/cart.js') }}"></script>
@endpush
