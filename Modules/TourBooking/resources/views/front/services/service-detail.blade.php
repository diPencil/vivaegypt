@extends('layout_inner_page2')

@section('title')
    <title>{{ $service?->translation?->seo_title ?? $service?->translation?->title ?? $service?->title }}</title>
    <meta name="title" content="{{ $service?->translation?->seo_title ?? $service?->translation?->title ?? $service?->title }}">
    <meta name="description" content="{!! $service?->translation?->seo_description ?? $service?->translation?->short_description ?? $service?->short_description !!}">
    <meta name="keyword" content="{!! $service?->translation?->seo_keywords ?? $service?->translation?->title ?? $service?->title !!}">
@endsection

@section('front-content')
    <!-- main-area -->
    <main class="tg-service-detail-page">
        @php
            $serviceTypeSlug = $service?->serviceType?->slug;
            $isHotel = str_contains($serviceTypeSlug, 'hotel');
            $isHajj = $serviceTypeSlug == 'hajj';
            $isUmrah = $serviceTypeSlug == 'umrah';
            $isFlight = $serviceTypeSlug == 'flights';

            $aboutTitle = __('translate.About This Tour');
            $planTitle = __('translate.Tour Plan');

            if ($isHotel) {
                $aboutTitle = __('translate.Hotel Accommodation');
                $planTitle = __('translate.Hotel Details');
            } elseif ($isHajj) {
                $aboutTitle = __('translate.About Hajj');
                $planTitle = __('translate.Program Itinerary');
            } elseif ($isUmrah) {
                $aboutTitle = __('translate.About Umrah');
                $planTitle = __('translate.Program Itinerary');
            } elseif ($isFlight) {
                $aboutTitle = __('translate.About This Flight');
                $planTitle = __('translate.Flight Details');
            }
        @endphp


        <!-- tg-tour-details-area-start -->
        <div class="tg-tour-details-area pt-35 pb-25">
            <div class="container">
                <div class="row align-items-end mb-35">
                    <div class="col-xl-9 col-lg-8">
                        <div class="tg-tour-details-video-title-wrap">
                            <div class="service-detail-inline-breadcrumb mb-15">
                                <a href="{{ route('home') }}">{{ __('translate.Home') }}</a>
                                <span class="separator">&gt;</span>
                                <a href="{{ route('front.tourbooking.services') }}">{{ __('translate.Services') }}</a>
                                <span class="separator">&gt;</span>
                                <span class="current">{{ $service?->translation?->title ?? $service?->title }}</span>
                            </div>
                            <h2 class="tg-tour-details-video-title mb-15">
                                {{ $service?->translation?->title }}
                            </h2>
                            <div class="tg-tour-details-video-location d-flex flex-wrap">

                                @if ($service?->location)
                                    <span class="mr-25"><i class="fa-regular fa-location-dot"></i>
                                        {{ $service?->location }}
                                    </span>
                                @endif

                                <div class="tg-tour-details-video-ratings">
                                    @foreach (range(1, 5) as $star)
                                        <i
                                            class="fa-sharp fa-solid fa-star @if ($avgRating >= $star) active @endif"></i>
                                    @endforeach
                                    <span class="review">
                                        (
                                        {{ __($reviews->count()) }}
                                        {{ __($reviews->count() > 1 ? __('translate.Reviews') : __('translate.Review')) }}
                                        )
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="tg-tour-details-video-share text-end">
                            <a class="d-none" href="#">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.87746 9.03227L10.7343 11.8625M10.7272 4.05449L5.87746 6.88471M14.7023 2.98071C14.7023 4.15892 13.7472 5.11405 12.569 5.11405C11.3908 5.11405 10.4357 4.15892 10.4357 2.98071C10.4357 1.80251 11.3908 0.847382 12.569 0.847382C13.7472 0.847382 14.7023 1.80251 14.7023 2.98071ZM6.16901 7.95849C6.16901 9.1367 5.21388 10.0918 4.03568 10.0918C2.85747 10.0918 1.90234 9.1367 1.90234 7.95849C1.90234 6.78029 2.85747 5.82516 4.03568 5.82516C5.21388 5.82516 6.16901 6.78029 6.16901 7.95849ZM14.7023 12.9363C14.7023 14.1145 13.7472 15.0696 12.569 15.0696C11.3908 15.0696 10.4357 14.1145 10.4357 12.9363C10.4357 11.7581 11.3908 10.8029 12.569 10.8029C13.7472 10.8029 14.7023 11.7581 14.7023 12.9363Z"
                                        stroke="currentColor" stroke-width="0.977778" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                {{ __('translate.Share') }}
                            </a>
                            <a @class([
                                'tg-listing-item-wishlist ml-25',
                                'active' => $service?->my_wishlist_exists == 1,
                            ]) data-url="{{ route('user.wishlist.store') }}"
                                onclick="addToWishlist({{ $service->id }}, this, 'service')" href="javascript:void(0);">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.2606 10.7831L10.2878 10.8183L10.2606 10.7831L10.2482 10.7928C10.0554 10.9422 9.86349 11.0909 9.67488 11.2404C9.32643 11.5165 9.01846 11.7565 8.72239 11.9304C8.42614 12.1044 8.19324 12.1804 7.99978 12.1804C7.80633 12.1804 7.57342 12.1044 7.27718 11.9304C6.9811 11.7565 6.67312 11.5165 6.32472 11.2404C6.13618 11.091 5.94436 10.9423 5.75159 10.7929L5.73897 10.7831C4.90868 10.1397 4.06133 9.48294 3.36178 8.6911C2.51401 7.73157 1.92536 6.61544 1.92536 5.16811C1.92536 3.75448 2.71997 2.57143 3.80086 2.07481C4.84765 1.59384 6.26028 1.71692 7.61021 3.12673L7.64151 3.09675L7.61021 3.12673C7.7121 3.23312 7.85274 3.2933 7.99978 3.2933C8.14682 3.2933 8.28746 3.23312 8.38936 3.12673L8.35868 3.09736L8.38936 3.12673C9.73926 1.71692 11.1519 1.59384 12.1987 2.07481C13.2796 2.57143 14.0742 3.75448 14.0742 5.16811C14.0742 6.61544 13.4856 7.73157 12.6378 8.69109L12.668 8.71776L12.6378 8.6911C11.9382 9.48294 11.0909 10.1397 10.2606 10.7831ZM5.10884 11.6673L5.13604 11.6321L5.10884 11.6673L5.10901 11.6674C5.29802 11.8137 5.48112 11.9554 5.65523 12.0933C5.99368 12.3616 6.35981 12.6498 6.73154 12.8682L6.75405 12.8298L6.73154 12.8682C7.10315 13.0864 7.53174 13.2667 7.99978 13.2667C8.46782 13.2667 8.89641 13.0864 9.26802 12.8682L9.24552 12.8298L9.26803 12.8682C9.63979 12.6498 10.0059 12.3615 10.3443 12.0933C10.5185 11.9553 10.7016 11.8136 10.8907 11.6673L10.8907 11.6673L10.8926 11.6659C11.7255 11.0212 12.6722 10.2884 13.4463 9.41228L13.413 9.38285L13.4463 9.41227C14.4145 8.31636 15.1553 6.95427 15.1553 5.16811C15.1553 3.34832 14.1308 1.76808 12.6483 1.08693C11.2517 0.445248 9.53362 0.635775 7.99979 1.99784C6.46598 0.635775 4.74782 0.445248 3.35124 1.08693C1.86877 1.76808 0.844227 3.34832 0.844227 5.16811C0.844227 6.95427 1.58502 8.31636 2.55325 9.41227C3.32727 10.2883 4.27395 11.0211 5.10682 11.6657L5.10884 11.6673Z"
                                        fill="currentColor" stroke="currentColor" stroke-width="0.0888889" />
                                </svg>
                                <span class="wishlist_change_text">
                                    @if ($service?->my_wishlist_exists == 1)
                                        {{ __('translate.Remove from Wishlist') }}
                                    @else
                                        {{ __('translate.Add to Wishlist') }}
                                    @endif
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                @php
                    $thumbnails = $service->media->where('is_thumbnail', 1)->sortBy('display_order')->values();
                    $nonThumbnails = $service->media->where('is_thumbnail', 0)->sortBy('display_order')->values();
                @endphp

@php
                    $galleryAll  = $thumbnails->merge($nonThumbnails);
                    $galleryExtra = max(0, $galleryAll->count() - 4);
                @endphp

                <div class="service-mobile-gallery d-lg-none mb-25">
                    <div class="swiper service-mobile-gallery-main">
                        <div class="swiper-wrapper">
                            @forelse ($galleryAll as $media)
                                <div class="swiper-slide">
                                    <div class="tg-tour-details-video-thumb" style="overflow:hidden;">
                                        <a href="{{ asset($media->file_path) }}"
                                           class="glightbox service-gal-item"
                                           data-gallery="sg-{{ $service->id }}"
                                           style="display:block;">
                                            <img class="w-100 service-gal-img" src="{{ asset($media->file_path) }}"
                                                alt="{{ $media->caption ?? '' }}">
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="tg-tour-details-video-thumb" style="overflow:hidden;">
                                        <img class="w-100" src="{{ asset('frontend/assets/img/shape/placeholder.png') }}"
                                            alt="default">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <button class="service-mobile-gallery-prev" type="button" aria-label="Previous image">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="service-mobile-gallery-next" type="button" aria-label="Next image">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    @if ($galleryAll->count() > 1)
                        <div class="swiper service-mobile-gallery-thumbs mt-15">
                            <div class="swiper-wrapper">
                                @foreach ($galleryAll as $media)
                                    <div class="swiper-slide">
                                        <div class="service-mobile-thumb-wrap">
                                            <img class="w-100" src="{{ asset($media->file_path) }}"
                                                alt="{{ $media->caption ?? '' }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Desktop: fixed bento grid; images use object-fit:cover so any source size keeps layout --}}
                <div class="service-desktop-gallery mb-25">
                    <div class="service-desktop-gallery__hero">
                        <div class="service-desktop-gallery__thumb tg-tour-details-video-thumb p-relative">
                            @if (isset($thumbnails[0]))
                                <a href="{{ asset($thumbnails[0]->file_path) }}"
                                   class="glightbox service-gal-item service-desktop-gallery__link"
                                   data-gallery="sg-{{ $service->id }}">
                                    <img class="service-gal-img service-desktop-gallery__img"
                                        src="{{ asset($thumbnails[0]->file_path) }}"
                                        alt="{{ $thumbnails[0]->caption }}">
                                </a>
                            @else
                                <img class="service-desktop-gallery__img"
                                    src="{{ asset('frontend/assets/img/shape/placeholder.png') }}" alt="default">
                            @endif
                        </div>
                    </div>

                    <div class="service-desktop-gallery__stack">
                        <div class="service-desktop-gallery__stack-top">
                            <div class="service-desktop-gallery__thumb tg-tour-details-video-thumb p-relative">
                                @if (isset($nonThumbnails[0]))
                                    <a href="{{ asset($nonThumbnails[0]->file_path) }}"
                                       class="glightbox service-gal-item service-desktop-gallery__link"
                                       data-gallery="sg-{{ $service->id }}">
                                        <img class="service-gal-img service-desktop-gallery__img"
                                            src="{{ asset($nonThumbnails[0]->file_path) }}"
                                            alt="{{ $nonThumbnails[0]->caption }}">
                                    </a>
                                    @if ($service->video_url)
                                        <div class="tg-tour-details-video-inner text-center">
                                            <a class="tg-video-play tg-pulse-border glightbox service-gal-item"
                                                data-gallery="sg-{{ $service->id }}"
                                                data-type="video"
                                                href="{{ $service->video_url }}">
                                                <span class="p-relative z-index-11">
                                                    <svg width="19" height="21" viewBox="0 0 19 21" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.3616 8.34455C19.0412 9.31425 19.0412 11.7385 17.3616 12.7082L4.13504 20.3445C2.45548 21.3142 0.356021 20.1021 0.356021 18.1627L0.356022 2.89C0.356022 0.950609 2.45548 -0.261512 4.13504 0.708185L17.3616 8.34455Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="service-desktop-gallery__stack-bottom">
                            @for ($i = 1; $i <= 2; $i++)
                                @if (isset($nonThumbnails[$i]))
                                    <div class="service-desktop-gallery__thumb tg-tour-details-video-thumb p-relative">
                                        <a href="{{ asset($nonThumbnails[$i]->file_path) }}"
                                           class="glightbox service-gal-item service-desktop-gallery__link"
                                           data-gallery="sg-{{ $service->id }}">
                                            <img class="service-gal-img service-desktop-gallery__img"
                                                src="{{ asset($nonThumbnails[$i]->file_path) }}"
                                                alt="{{ $nonThumbnails[$i]->caption }}">
                                            @if ($i === 2 && $galleryExtra > 0)
                                                <span class="service-gal-more">+{{ $galleryExtra }}</span>
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Hidden anchors for extra gallery images not shown in the grid --}}
                @if ($galleryExtra > 0)
                    <div style="display:none;" aria-hidden="true">
                        @foreach ($galleryAll->skip(4) as $m)
                            <a href="{{ asset($m->file_path) }}" class="glightbox service-gal-item" data-gallery="sg-{{ $service->id }}">·</a>
                        @endforeach
                    </div>
                @endif

                <div class="tg-tour-details-feature-list-wrap">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="tg-tour-details-video-feature-list">
                                <ul>

                                    @if ($service?->duration)
                                        <li>
                                            <span class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.00001 4.19992V8.99992L12.2 10.5999M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z"
                                                        stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="title">{{ __('translate.Duration') }}</span>
                                                <span class="duration">{{ $service?->duration }}</span>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($service?->serviceType?->localized_name)
                                        <li>
                                            <span class="icon">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11.5 6.52684L4.5 2.64944M1.21001 4.70401L8.00001 8.47683L14.79 4.70401M8 16V8.46931M15 11.4578V5.48102C14.9997 5.21899 14.9277 4.96165 14.7912 4.7348C14.6547 4.50794 14.4585 4.31956 14.2222 4.18855L8.77778 1.20018C8.5413 1.06904 8.27306 1 8 1C7.72694 1 7.4587 1.06904 7.22222 1.20018L1.77778 4.18855C1.54154 4.31956 1.34532 4.50794 1.2088 4.7348C1.07229 4.96165 1.00028 5.21899 1 5.48102V11.4578C1.00028 11.7198 1.07229 11.9771 1.2088 12.204C1.34532 12.4308 1.54154 12.6192 1.77778 12.7502L7.22222 15.7386C7.4587 15.8697 7.72694 15.9388 8 15.9388C8.27306 15.9388 8.5413 15.8697 8.77778 15.7386L14.2222 12.7502C14.4585 12.6192 14.6547 12.4308 14.7912 12.204C14.9277 11.9771 14.9997 11.7198 15 11.4578Z"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="title">{{ __('translate.Type') }}</span>
                                                <span class="duration">{{ $service?->serviceType?->localized_name }}</span>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($service?->group_size)
                                        <li>
                                            <span class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M1.7 17.2C1.5 17.2 1.3 17.1 1.2 17C1.1 16.8 1 16.7 1 16.5C1 15.1 1.4 13.7 2.1 12.4C2.8 11.2 3.9 10.1 5.1 9.4C4.6 8.8 4.2 8 4 7.2C3.9 6.4 3.9 5.5 4.1 4.8C4.3 4 4.8 3.2 5.3 2.6C5.9 2 6.6 1.5 7.3 1.3C7.9 1.1 8.5 1 9.1 1C9.3 1 9.6 1 9.8 1C10.6 1.1 11.4 1.4 12.1 1.9C12.8 2.4 13.3 3 13.7 3.7C14.1 4.4 14.3 5.2 14.3 6.1C14.3 7.3 13.9 8.5 13.1 9.4C13.7 9.8 14.3 10.2 14.9 10.7C15.7 11.5 16.2 12.3 16.7 13.3C17.1 14.3 17.3 15.3 17.3 16.4C17.3 16.6 17.2 16.8 17.1 16.9C17 17 16.8 17.1 16.6 17.1C16.5 17.1 16.4 17.1 16.3 17C16.2 17 16.1 16.9 16.1 16.8C16 16.7 16 16.7 15.9 16.6C15.9 16.5 15.8 16.4 15.8 16.3C15.8 15.4 15.6 14.6 15.3 13.8C15 13 14.5 12.3 13.8 11.7C13.2 11.2 12.6 10.7 11.9 10.4C11.1 10.9 10.2 11.2 9.1 11.2C8.1 11.2 7.1 10.9 6.3 10.4C5.2 10.9 4.2 11.7 3.5 12.8C2.8 13.9 2.4 15.1 2.4 16.4C2.4 16.6 2.3 16.8 2.2 16.9C2.1 17.1 1.9 17.2 1.7 17.2ZM9.1 2.5C8.4 2.5 7.7 2.7 7.1 3.1C6.4 3.5 6 4.1 5.7 4.7C5.4 5.4 5.3 6.1 5.5 6.9C5.6 7.6 6 8.3 6.5 8.8C7 9.3 7.7 9.7 8.4 9.8C8.6 9.8 8.9 9.9 9.1 9.9C9.6 9.9 10.1 9.8 10.5 9.6C11.2 9.3 11.7 8.9 12.2 8.2C12.6 7.6 12.8 6.9 12.8 6.2C12.8 5.2 12.4 4.3 11.7 3.6C11 2.8 10.1 2.5 9.1 2.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="title">{{ __('translate.Group Size') }}</span>
                                                <span class="duration">{{ $service?->group_size }}</span>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($service?->languages && is_array($service?->languages) && count($service?->languages) > 0)
                                        <li class="languages-item">
                                            <span class="icon">
                                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16 8.5C16 12.6421 12.6421 16 8.5 16M16 8.5C16 4.35786 12.6421 1 8.5 1M16 8.5H1M8.5 16C4.35786 16 1 12.6421 1 8.5M8.5 16C10.376 13.9462 11.4421 11.281 11.5 8.5C11.4421 5.71903 10.376 3.05376 8.5 1M8.5 16C6.62404 13.9462 5.55794 11.281 5.5 8.5C5.55794 5.71903 6.62404 3.05376 8.5 1M1 8.5C1 4.35786 4.35786 1 8.5 1"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <div>
                                                <span class="title">{{ __('translate.Languages') }}</span>
                                                <span class="duration">
                                                    @foreach ($service?->languages as $language)
                                                        {{ $language }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="tg-tour-details-video-feature-price mb-15 text-right">
                                @if ($service?->is_per_person)
                                    <p> {{ __('translate.From') }}
                                        <span>{{ currency($service?->price_per_person) }}</span> /
                                        {{ __('translate.Person') }}
                                    </p>
                                @else
                                    <div class="service-price_display">
                                        {!! $service->price_display !!}
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tg-tour-details-area-end -->

        <!-- tg-tour-about-start -->
        <div class="tg-tour-about-area tg-tour-about-border pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="tg-tour-about-wrap mr-55">
                            <div class="tg-tour-about-content">
                                <div class="tg-tour-about-inner mb-25">
                                    <h4 class="tg-tour-about-title mb-15">
                                        {{ $aboutTitle }}
                                    </h4>
                                    <div class="text-capitalize lh-28">
                                        {!! $service?->translation?->short_description !!}
                                    </div>
                                </div>

                                @if ($service?->translation?->description)
                                    <div class="tg-tour-about-inner mb-40">
                                        {!! $service?->translation?->description !!}
                                    </div>
                                    <div class="tg-tour-about-border mb-40"></div>
                                @endif

                                @php
                                    $serviceListValue = function ($value) {
                                        if (is_array($value)) {
                                            return array_values(array_filter($value, fn ($item) => filled($item)));
                                        }

                                        if (is_string($value) && $value !== '') {
                                            $decoded = json_decode($value, true);

                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                return array_values(array_filter($decoded, fn ($item) => filled($item)));
                                            }

                                            return [$value];
                                        }

                                        return [];
                                    };

                                    $facilities = $serviceListValue($service?->translation?->facilities);
                                    $rules = $serviceListValue($service?->translation?->rules);
                                    $safety = $serviceListValue($service?->translation?->safety);
                                    $includedItems = $serviceListValue($service?->translation?->included);
                                    $excludedItems = $serviceListValue($service?->translation?->excluded);

                                    if (count($facilities) === 0) {
                                        $facilities = $serviceListValue($service?->facilities);
                                    }

                                    if (count($rules) === 0) {
                                        $rules = $serviceListValue($service?->rules);
                                    }

                                    if (count($safety) === 0) {
                                        $safety = $serviceListValue($service?->safety);
                                    }

                                    if (count($includedItems) === 0) {
                                        $includedItems = $serviceListValue($service?->included);
                                    }

                                    if (count($excludedItems) === 0) {
                                        $excludedItems = $serviceListValue($service?->excluded);
                                    }

                                    $ticketText = $service?->ticket;
                                    if (app()->getLocale() === 'ar' && $ticketText === 'Mobile voucher accepted') {
                                        $ticketText = __('translate.Mobile voucher accepted');
                                    }

                                    $hasAdditionalInfo = filled($service?->ticket) || filled($service?->phone) || filled($service?->website) || count($facilities) > 0 || count($rules) > 0 || count($safety) > 0;
                                @endphp

                                @if ($hasAdditionalInfo)
                                    <div class="tg-tour-about-inner mb-40">
                                        @if ($service?->ticket || $service?->phone || $service?->website)
                                            <h4 class="tg-tour-about-title mb-20">{{ __('translate.Additional Information') }}</h4>
                                            <div class="tg-tour-about-list tg-tour-about-list-2 mb-30">
                                                <ul>
                                                    @if ($service?->ticket)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-ticket fa-fw"></i></span>
                                                            <span class="text"><strong>{{ __('translate.Ticket / Voucher') }}:</strong> {{ $ticketText }}</span>
                                                        </li>
                                                    @endif

                                                    @if ($service?->phone)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-phone fa-fw"></i></span>
                                                            <span class="text"><strong>{{ __('translate.Phone') }}:</strong> <a href="tel:{{ $service?->phone }}">{{ $service?->phone }}</a></span>
                                                        </li>
                                                    @endif

                                                    @if ($service?->website)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-globe fa-fw"></i></span>
                                                            <span class="text"><strong>{{ __('translate.Website') }}:</strong> <a href="{{ getLink($service?->website) }}" target="_blank" rel="noopener">{{ $service?->website }}</a></span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif

                                        @if (count($facilities) > 0)
                                            <h4 class="tg-tour-about-title mb-20">{{ __('translate.What to Bring') }}</h4>
                                            <div class="tg-tour-about-list tg-tour-about-list-2 mb-30">
                                                <ul>
                                                    @foreach ($facilities as $item)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-check fa-fw"></i></span>
                                                            <span class="text">{{ $item }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if (count($rules) > 0)
                                            <h4 class="tg-tour-about-title mb-20">{{ __('translate.Important Notes') }}</h4>
                                            <div class="tg-tour-about-list tg-tour-about-list-2 mb-30">
                                                <ul>
                                                    @foreach ($rules as $item)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-circle-info fa-fw"></i></span>
                                                            <span class="text">{{ $item }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        @if (count($safety) > 0)
                                            <h4 class="tg-tour-about-title mb-20">{{ __('translate.Not Suitable For') }}</h4>
                                            <div class="tg-tour-about-list tg-tour-about-list-2 disable mb-30">
                                                <ul>
                                                    @foreach ($safety as $item)
                                                        <li>
                                                            <span class="icon mr-10"><i class="fa-sharp fa-solid fa-triangle-exclamation fa-fw"></i></span>
                                                            <span class="text">{{ $item }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tg-tour-about-border mb-40"></div>
                                @endif

                                @if (count($includedItems) > 0 || count($excludedItems) > 0)
                                    <div class="tg-tour-about-inner mb-40">
                                        <h4 class="tg-tour-about-title mb-20">{{ __('translate.Included/Exclude') }}</h4>
                                        <div class="row">
                                            @if (count($includedItems) > 0)
                                                <div class="col-lg-5">
                                                    <div class="tg-tour-about-list  tg-tour-about-list-2">
                                                        <ul>
                                                            @foreach ($includedItems as $item)
                                                                <li>
                                                                    <span class="icon mr-10"><i
                                                                            class="fa-sharp fa-solid fa-check fa-fw"></i></span>
                                                                    <span class="text">{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (count($excludedItems) > 0)
                                                <div class="col-lg-7">
                                                    <div class="tg-tour-about-list tg-tour-about-list-2 disable">
                                                        <ul>
                                                            @foreach ($excludedItems as $item)
                                                                <li>
                                                                    <span class="icon mr-10"><i
                                                                            class="fa-sharp fa-solid fa-xmark"></i></span>
                                                                    <span class="text">
                                                                        {{ $item }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tg-tour-about-border mb-40"></div>
                                @endif

                                <div class="tg-tour-faq-wrap mb-70">
                                    <h4 class="tg-tour-about-title mb-15">
                                        {{ $planTitle }}
                                    </h4>

                                    @if ($service?->tour_plan_sub_title)
                                        <p class="text-capitalize lh-28 mb-20">
                                            {{ $service?->tour_plan_sub_title }}
                                        </p>
                                    @endif
                                    <div class="tg-tour-about-faq-inner">
                                        <div class="tg-tour-about-faq" id="accordionExample">
                                            @foreach ($service?->itineraries as $itinerary)
                                                @php
                                                    $itineraryTitle = $itinerary->translated('title');
                                                    $itineraryDescription = $itinerary->translated('description');
                                                    $itineraryLocation = $itinerary->translated('location');
                                                    $itineraryMealIncluded = $itinerary->translated('meal_included');
                                                @endphp
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button @class(['accordion-button', 'collapsed' => !$loop->first]) class="accordion-button"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_{{ $itinerary->id }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_{{ $itinerary->id }}">
                                                            <span>{{ __('translate.Day-') }}{{ $itinerary?->day_number }}</span>
                                                            {{ $itineraryTitle }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse_{{ $itinerary->id }}" @class(['accordion-collapse collapse', 'show' => $loop->first])
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row pb-5">
                                                                @if ($itinerary?->image)
                                                                    <div class="col-md-4 mb-5">
                                                                        <a href="{{ asset($itinerary->image) }}"
                                                                            class="glightbox service-gal-item itinerary-image-link"
                                                                            data-gallery="itinerary-{{ $service->id }}">
                                                                            <img src="{{ asset($itinerary->image) }}"
                                                                                alt="{{ $itineraryTitle }}"
                                                                                class="itinerary-image">
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                <div @class([
                                                                    'col-12 mb-5' => !$itinerary?->image,
                                                                    'col-md-8 mb-5' => $itinerary?->image,
                                                                ])>

                                                                    @if ($itineraryDescription)
                                                                        <div>
                                                                            {!! $itineraryDescription !!}
                                                                        </div>
                                                                    @endif

                                                                    @if ($itineraryLocation)
                                                                        <div class="itinerary-meta-row mt-3">
                                                                            <strong class="itinerary-meta-label"><i class="fa fa-map-marker"></i>
                                                                                {{ __('translate.Location') }}:</strong>
                                                                            <span class="itinerary-meta-value">{{ $itineraryLocation }}</span>
                                                                        </div>
                                                                    @endif

                                                                    @if ($itinerary?->duration)
                                                                        <div class="itinerary-meta-row mt-3">
                                                                            <strong class="itinerary-meta-label"><i
                                                                                    class="fa-solid fa-business-time"></i>
                                                                                {{ __('translate.Duration') }}:</strong>
                                                                            <span class="itinerary-meta-value">{{ $itinerary?->duration }}</span>
                                                                        </div>
                                                                    @endif

                                                                    @if ($itineraryMealIncluded)
                                                                        <div class="itinerary-meta-row mt-2">
                                                                            <strong class="itinerary-meta-label"><i class="fa fa-utensils"></i>
                                                                                {{ __('translate.Meal Included') }}:</strong>
                                                                            <span class="badge bg-success itinerary-meta-badge">
                                                                                {{ $itineraryMealIncluded }}
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if (($availabilityCalendarJson ?? collect())->isNotEmpty())
                                        <div class="tg-tour-availability-calendar-section mt-40 pt-25 border-top">
                                            <h4 class="tg-tour-about-title mb-10">
                                                {{ __('translate.Service Availability') }}
                                            </h4>
                                            <p class="text-capitalize lh-28 mb-20" style="font-size: 14px; color: #6b7280;">
                                                {{ __('translate.Availability calendar hint') }}
                                            </p>
                                            <div class="tg-tour-cal-legend d-flex flex-wrap align-items-center gap-3 mb-20">
                                                <span class="tg-tour-cal-legend-item"><i class="tg-tour-cal-dot tg-tour-cal-dot--available"></i>
                                                    {{ __('translate.Available') }}</span>
                                                <span class="tg-tour-cal-legend-item"><i class="tg-tour-cal-dot tg-tour-cal-dot--limited"></i>
                                                    {{ __('translate.Limited Spots') }}</span>
                                                <span class="tg-tour-cal-legend-item"><i class="tg-tour-cal-dot tg-tour-cal-dot--unavailable"></i>
                                                    {{ __('translate.Unavailable') }}</span>
                                            </div>
                                            <div id="tour-availability-calendar"
                                                class="tour-availability-calendar-root"
                                                data-currency-icon="{{ e(default_currency()['currency_icon'] ?? '$') }}"
                                                data-base-price="{{ $service->is_per_person ? (float) $service->price_per_person : (float) ($service->discount_price ?? $service->full_price) }}">
                                                {{-- Flatpickr inline requires an input + appendTo; binding to a bare div shows nothing --}}
                                                <input type="text" id="tour-availability-calendar-input"
                                                    class="tour-availability-calendar-input-hidden" readonly
                                                    tabindex="-1" autocomplete="off" aria-hidden="true">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="tg-tour-about-border mb-45"></div>
                                <div class="tg-tour-about-map mb-40">
                                    <h4 class="tg-tour-about-title mb-15">
                                        {{ __('translate.Location') }}
                                    </h4>
                                    @if ($service?->google_map_sub_title)
                                        <p class="text-capitalize lh-28">
                                            {{ $service?->google_map_sub_title }}
                                        </p>
                                    @endif

                                    @if ($service?->google_map_url)
                                        <div class="tg-tour-about-map h-100">
                                            @if (str_contains($service?->google_map_url, '<iframe'))
                                                {!! $service?->google_map_url !!}
                                            @else
                                                <iframe src="{{ $service?->google_map_url }}" width="100%" height="450"
                                                    style="border:0;" allowfullscreen="" loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                    title="{{ $service?->google_map_sub_title ?? $service?->translation?->title }}"></iframe>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="tg-tour-about-border mb-45"></div>
                                <div class="tg-tour-about-review-wrap mb-45">
                                    <h4 class="tg-tour-about-title mb-15">
                                        {{ __('translate.Customer Reviews') }}
                                    </h4>

                                    @if ($reviews->count() > 0)
                                        <div class="tg-tour-about-review">
                                            <div class="head-reviews">
                                                <div class="review-left">
                                                    <div class="review-info-inner">
                                                        <h2>
                                                            {{ number_format($avgRating, 1) }}
                                                        </h2>
                                                        <p>{{ __('translate.Based On') }}
                                                            {{ __($reviews->count()) }}
                                                            {{ __($reviews->count() > 1 ? __('translate.Reviews') : __('translate.Review')) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="review-right">
                                                    <div class="review-progress">
                                                        @foreach ($averageRatings as $item)
                                                            <div class="item-review-progress">
                                                                <div class="text-rv-progress">
                                                                    <p>{{ __('translate.' . $item['category']) }}</p>
                                                                </div>
                                                                <div class="bar-rv-progress">
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                            style="width: {{ $item['percent'] }}%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-avarage">
                                                                    <p>{{ $item['average'] }}/5</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="tg-tour-about-border mb-35"></div>
                                <div class="tg-tour-about-cus-review-wrap mb-25">
                                    <h4 class="tg-tour-about-title mb-40">
                                        {{ __($reviews->count()) }}
                                        {{ __($reviews->count() > 1 ? __('translate.Reviews') : __('translate.Review')) }}
                                    </h4>
                                    <ul>
                                        @forelse ($paginatedReviews as $review)
                                            <li>
                                                <div class="tg-tour-about-cus-review d-flex mb-40">
                                                    <div class="tg-tour-about-cus-review-thumb">
                                                        <img src="{{ asset($review->user->image ?? 'frontend/assets/img/shape/placeholder.png') }}"
                                                            alt="{{ $review->user->name }}">
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="tg-tour-about-cus-name mb-5 d-flex align-items-center justify-content-between flex-wrap">
                                                            <h6 class="mr-10 mb-10 d-inline-block">
                                                                {{ $review->user->name }}
                                                                <span>-
                                                                    {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y . h:i A') }}
                                                                </span>
                                                            </h6>
                                                            <span
                                                                class="tg-tour-about-cus-review-star mb-10 d-inline-block">
                                                                @foreach (range(1, 5) as $star)
                                                                    <i
                                                                        class="fa-sharp fa-solid fa-star @if ($review->rating >= $star) active @endif"></i>
                                                                @endforeach

                                                            </span>
                                                        </div>
                                                        <p class="text-capitalize lh-28 mb-10">
                                                            {{ $review->review }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="tg-tour-about-border mb-40"></div>
                                            </li>
                                        @empty
                                            <h5 class="text-center">{{ __('translate.No Review Found') }}</h5>
                                        @endforelse
                                    </ul>
                                    @include('components.front.custom-pagination', [
                                        'items' => $paginatedReviews,
                                    ])
                                </div>
                                <div id="reviewForm" x-data="reviewForm()"
                                    class="tg-tour-about-review-form-wrap mb-45">
                                    <h4 class="tg-tour-about-title mb-5">{{ __('translate.Leave a Reply') }}</h4>
                                    <div class="tg-tour-about-rating-category mb-20">
                                        <ul>
                                            <template x-for="(category, index) in categories" :key="category.name">
                                                <li>
                                                    <label x-text="category.name + ' :'" class="mr-2"></label>
                                                    <div class="rating-icon flex space-x-1">
                                                        <template x-for="star in 5" :key="star">
                                                            <i class="fa-sharp fa-solid fa-star cursor-pointer"
                                                                :class="star <= category.rating ? 'active' :
                                                                    ''"
                                                                @click="setRating(index, star)"
                                                                @mouseover="hoverRating = star; hoverIndex = index"
                                                                @mouseleave="hoverRating = 0; hoverIndex = null"
                                                                :class="(hoverIndex === index && star <= hoverRating) ?
                                                                'text-yellow-300' : ''"></i>
                                                        </template>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <div class="tg-tour-about-review-form">
                                        <form @submit.prevent="submitForm" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <textarea x-model="message" class="textarea mb-5" placeholder="{{ __('translate.Write Message') }}"></textarea>
                                                    <button type="submit" class="tg-btn tg-btn-switch-animation">
                                                        {{ __('translate.Submit Review') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div x-data="bookingForm()" id="book-now-sidebar"
                            class="tg-tour-about-sidebar top-sticky mb-50">
                            <form action="{{ route('front.tourbooking.book.checkout.view') }}">
                                <h4 class="tg-tour-about-title title-2" style="margin-bottom: 6px;">{{ __('translate.Book Now') }}</h4>
                                <p class="mb-15" style="font-size: 14px; line-height: 1.3; color: #6b7280; margin-top: 0;">
                                    {{ $service->translation->title ?? $service->title }}
                                </p>

                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <div class="tg-booking-form-parent-inner mb-10">
                                    <div class="tg-tour-about-date p-relative">
                                        <input required class="input" name="check_in_date" type="text"
                                            placeholder="{{ __('translate.Check in') }}" value="{{ now()->format('Y-m-d') }}">
                                        <span class="calender">
                                            <!-- calendar icon -->
                                        </span>
                                        <span class="angle"><i class="fa-sharp fa-solid fa-angle-down"></i></span>
                                        <input type="hidden" name="availability_id" id="selected-availability-id">
                                    </div>
                                    <!-- Availability information will be displayed here -->
                                    <div id="availability-info" class="mt-2" style="display: none;"></div>
                                </div>

                                @if ($service->is_per_person)
                                    <div class="tg-tour-about-time d-flex align-items-center mb-10">
                                        <span class="time">{{ __('translate.Time') }}:</span>
                                        <div class="form-check mr-15">
                                            <input type="hidden" name="check_in_time_hidden"
                                                value="{{ $service->check_in_time }}">
                                            <input class="form-check-input" name="check_in_time" type="radio"
                                                id="time1">
                                            <label class="form-check-label" for="time1">
                                                {{ $service->check_in_time }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" name="check_out_time_hidden"
                                                value="{{ $service->check_out_time }}">
                                            <input class="form-check-input" name="check_out_time" type="radio"
                                                id="time2">
                                            <label class="form-check-label" for="time2">
                                                {{ $service->check_out_time }}
                                            </label>
                                        </div>
                                    </div>


                                    <div class="tg-tour-about-border-doted mb-15"></div>
                                    <div class="tg-tour-about-tickets-wrap mb-15">
                                        <span class="tg-tour-about-sidebar-title">{{ __('translate.Tickets') }}:</span>

                                        <div class="tg-tour-about-tickets mb-10">
                                            <div class="tg-tour-about-tickets-adult">
                                                <span>{{ __('translate.Person') }}</span>
                                                <p class="mb-0">{{ __('translate.(18+ years)') }}
                                                    <span>{{ currency($service->price_per_person) }}</span>
                                                </p>
                                            </div>
                                            <div class="tg-tour-about-tickets-quantity">
                                                <select name="person" class="item-first custom-select"
                                                    x-model.number="tickets.person">
                                                    <template x-for="i in 8" :key="i">
                                                        <option :value="i" x-text="i"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="tg-tour-about-tickets mb-10">
                                            <div class="tg-tour-about-tickets-adult">
                                                <span>{{ __('translate.Children') }} </span>
                                                <p class="mb-0">{{ __('translate.(13-17 years)') }} </span>
                                                    <span>{{ currency($service->child_price) }}</span>
                                                </p>
                                            </div>
                                            <div class="tg-tour-about-tickets-quantity">
                                                <select name="children" class="item-first custom-select"
                                                    x-model.number="tickets.children">
                                                    <template x-for="i in 8" :key="i">
                                                        <option :value="i - 1" x-text="i - 1"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tg-tour-about-border-doted mb-15"></div>

                                    @if ($service->extraCharges->count() > 0)
                                        <div class="tg-tour-about-extra mb-10">
                                            <span class="tg-tour-about-sidebar-title mb-10 d-inline-block">{{ __('translate.Add Extra:') }}</span>
                                            <div class="tg-filter-list">
                                                <ul>
                                                    @foreach ($service->extraCharges as $key => $extra)
                                                        <li>
                                                            <div class="checkbox d-flex">
                                                                <input name="extras[]" value="{{ $extra->id }}"
                                                                    class="tg-checkbox" type="checkbox"
                                                                    x-model="extras.charge_{{ $key }}"
                                                                    id="charge_{{ $key }}">
                                                                <label for="charge_{{ $key }}" class="tg-label">
                                                                    {{ $extra->translated('name') }}
                                                                </label>
                                                            </div>
                                                            <span class="quantity">{{ currency($extra->price) }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tg-tour-about-border-doted mb-15"></div>
                                    @endif

                                @endif

                                @if ($service->is_per_person)
                                    <div
                                        class="tg-tour-about-coast d-flex align-items-center flex-wrap justify-content-between mb-20">
                                        <span class="tg-tour-about-sidebar-title d-inline-block">{{ __('translate.Total Cost:') }}</span>
                                        <h5 class="total-price"
                                            x-text="`{{ default_currency()['currency_icon'] }}${ {{ default_currency()['currency_rate'] }} * totalCost}`">
                                        </h5>

                                    </div>
                                @else
                                    <div
                                        class="mt-4 tg-tour-about-coast d-flex align-items-center flex-wrap justify-content-between mb-20">
                                        <span class="tg-tour-about-sidebar-title d-inline-block">{{ __('translate.Total Cost:') }}</span>
                                        <h5 class="total-price">
                                            {{ currency($service->discount_price ?? $service->full_price) }}</h5>
                                    </div>
                                @endif

                                <button type="submit" class="tg-btn tg-btn-switch-animation w-100">{{ __('translate.Book now') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tg-tour-about-end -->

        @include('tourbooking::front.services.popular-services')

        <div class="tg-mobile-sticky-booking-bar d-lg-none">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="sticky-price">
                            @if ($service?->is_per_person)
                                {{ __('translate.From') }} <span>{{ currency($service?->price_per_person) }}</span>
                            @else
                                {!! $service->price_display !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:void(0);" onclick="scrollToBooking()" class="tg-btn sticky-book-btn">
                            {{ __('translate.Check Availability') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main-area-end -->
@endsection

@push('js_section')
    <script>
        function scrollToBooking() {
            const el = document.getElementById('book-now-sidebar');
            if (el) {
                const header = document.querySelector('.tg-header-area.sticky-menu');
                const headHeight = header ? header.offsetHeight : 80;
                const elementPosition = el.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - headHeight - 15;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        }

        document.addEventListener('scroll', function() {
            const bar = document.querySelector('.tg-mobile-sticky-booking-bar');
            const bookingSidebar = document.getElementById('book-now-sidebar');
            if (bar && bookingSidebar) {
                const sidebarPos = bookingSidebar.getBoundingClientRect().top;
                // Show bar if the booking sidebar is not visible (scrolled past)
                if (window.scrollY > 500 && sidebarPos > window.innerHeight) {
                    bar.classList.add('show');
                } else {
                    bar.classList.remove('show');
                }
            }
        });
    </script>
@endpush


@push('js_section')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                document.querySelectorAll('.timepicker').forEach(function(el) {
                    flatpickr(el, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        time_24hr: true
                    });
                });

                const availabilities = @json($availabilityCalendarJson ?? collect());
                const availabilityMap = {};
                availabilities.forEach(item => {
                    availabilityMap[item.date] = {
                        spots: item.available_spots,
                        special_price: item.special_price,
                        notes: item.notes,
                        start_time: item.start_time,
                        end_time: item.end_time,
                        is_available: item.is_available
                    };
                });

                const bookableDates = availabilities.filter(a => a.is_available && (a.available_spots === null || a
                    .available_spots > 0)).map(a => a.date);

                function scrollToBookNow() {
                    const el = document.getElementById('book-now-sidebar');
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }

                function formatYmd(date) {
                    const y = date.getFullYear();
                    const m = String(date.getMonth() + 1).padStart(2, '0');
                    const d = String(date.getDate()).padStart(2, '0');
                    return `${y}-${m}-${d}`;
                }

                function isDateDisabled(date) {
                    const ymd = formatYmd(date);
                    const rec = availabilities.find(a => a.date === ymd);
                    if (!rec) {
                        return true;
                    }
                    if (!rec.is_available) {
                        return true;
                    }
                    if (rec.available_spots !== null && rec.available_spots <= 0) {
                        return true;
                    }
                    return false;
                }

                const calEl = document.getElementById('tour-availability-calendar');
                const calInput = document.getElementById('tour-availability-calendar-input');
                const currencyIcon = calEl ? (calEl.getAttribute('data-currency-icon') || '') : '';
                const basePrice = calEl ? parseFloat(calEl.getAttribute('data-base-price') || '0') : 0;

                function decorateDay(dayElem, fp) {
                    dayElem.classList.remove('tg-cal-unavailable', 'tg-cal-limited', 'tg-cal-available');
                    const dObj = dayElem && dayElem.dateObj;
                    if (!dObj || !(dObj instanceof Date) || isNaN(dObj.getTime())) {
                        return;
                    }
                    const ymd = fp.formatDate(dObj, 'Y-m-d');
                    const rec = availabilityMap[ymd];
                    dayElem.querySelectorAll('.tg-cal-cell-price').forEach(n => n.remove());
                    if (!rec) {
                        return;
                    }
                    if (!rec.is_available || (rec.spots !== null && rec.spots <= 0)) {
                        dayElem.classList.add('tg-cal-unavailable');
                        return;
                    }
                    if (rec.spots !== null && rec.spots > 0 && rec.spots <= 5) {
                        dayElem.classList.add('tg-cal-limited');
                    } else {
                        dayElem.classList.add('tg-cal-available');
                    }
                    const priceVal = rec.special_price != null ? rec.special_price : basePrice;
                    const span = document.createElement('span');
                    span.className = 'tg-cal-cell-price';
                    span.textContent = currencyIcon + (Number.isFinite(priceVal) ? Number(priceVal).toFixed(0) : '');
                    dayElem.appendChild(span);
                }

                const hasRules = availabilities.length > 0;
                let sidebarPicker = null;
                let inlinePicker = null;

                const fpShared = {
                    dateFormat: 'Y-m-d',
                    disableMobile: true,
                    minDate: 'today',
                    /* Flatpickr 4: (selectedDates, dateStr, instance, dayElement) — date is on dayElem.dateObj */
                    onDayCreate: function(_selectedDates, _dateStr, instance, dayElem) {
                        decorateDay(dayElem, instance);
                    }
                };
                if (hasRules) {
                    fpShared.disable = [isDateDisabled];
                }

                let initialDate = $('input[name="check_in_date"]').val();
                if (hasRules && bookableDates.length) {
                    if (!bookableDates.includes(initialDate)) {
                        initialDate = bookableDates[0];
                        $('input[name="check_in_date"]').val(initialDate);
                    }
                    fpShared.defaultDate = initialDate;
                }

                function bindBookNowDatePicker() {
                    const el = document.querySelector('#book-now-sidebar input[name="check_in_date"]');
                    if (!el || typeof flatpickr !== 'function') {
                        return;
                    }
                    if (el._flatpickr) {
                        el._flatpickr.destroy();
                    }
                    sidebarPicker = flatpickr(el, Object.assign({}, fpShared, {
                        clickOpens: true,
                        allowInput: true,
                        onChange: function(selectedDates, dateStr) {
                            if (inlinePicker) {
                                inlinePicker.setDate(dateStr, false);
                            }
                            updateAvailabilityInfo(dateStr);
                        }
                    }));
                }

                bindBookNowDatePicker();

                const bookNowDateWrap = document.querySelector('#book-now-sidebar .tg-tour-about-date');
                if (bookNowDateWrap && !bookNowDateWrap.dataset.fpOpenBound) {
                    bookNowDateWrap.dataset.fpOpenBound = '1';
                    bookNowDateWrap.addEventListener('click', function(ev) {
                        if (ev.target.closest('.flatpickr-calendar')) {
                            return;
                        }
                        const inp = this.querySelector('input[name="check_in_date"]');
                        if (inp && inp._flatpickr) {
                            inp._flatpickr.open();
                        }
                    });
                }

                window.setTimeout(function() {
                    bindBookNowDatePicker();
                }, 200);

                if (calEl && calInput && hasRules) {
                    inlinePicker = flatpickr(calInput, Object.assign({}, fpShared, {
                        inline: true,
                        appendTo: calEl,
                        clickOpens: false,
                        onChange: function(selectedDates, dateStr) {
                            if (sidebarPicker) {
                                sidebarPicker.setDate(dateStr, false);
                            }
                            $('input[name="check_in_date"]').val(dateStr);
                            updateAvailabilityInfo(dateStr);
                            scrollToBookNow();
                        }
                    }));
                }

                // Function to update availability information when a date is selected
                function updateAvailabilityInfo(dateStr) {
                    const availInfo = $('#availability-info');
                    const bookBtn = $('button[type="submit"]');
                    const availabilityInput = $('#selected-availability-id');

                    if (dateStr && availabilityMap[dateStr]) {
                        const info = availabilityMap[dateStr];
                        const availId = availabilities.find(a => a.date === dateStr)?.id;

                        // Store the selected availability ID
                        availabilityInput.val(availId || '');

                        // Create information display
                        let html = '<div class="alert alert-info mt-2 mb-0">';

                        if (info.spots !== null) {
                            html += `<p class="mb-1"><strong>{{ __('translate.Available spots') }}:</strong> ${info.spots}</p>`;

                            // Disable booking if no spots available
                            if (info.spots <= 0) {
                                html += '<p class="text-danger mb-0">{{ __('translate.No spots available for this date!') }}</p>';
                                bookBtn.prop('disabled', true);
                            } else {
                                bookBtn.prop('disabled', false);
                            }
                        } else {
                            html += '<p class="mb-1">{{ __('translate.Spots available for booking') }}</p>';
                            bookBtn.prop('disabled', false);
                        }

                        if (info.start_time && info.end_time) {
                            html +=
                                `<p class="mb-1"><strong>{{ __('translate.Time') }}:</strong> ${info.start_time.substring(0,5)} - ${info.end_time.substring(0,5)}</p>`;
                        }

                        if (info.special_price) {
                            html +=
                                `<p class="mb-1"><strong>{{ __('translate.Special price') }}:</strong> $${info.special_price}</p>`;
                        }

                        if (info.notes) {
                            html += `<p class="mb-0"><strong>{{ __('translate.Notes') }}:</strong> ${info.notes}</p>`;
                        }

                        html += '</div>';
                        availInfo.html(html).show();
                    } else {
                        availInfo.hide().html('');
                        availabilityInput.val('');
                        bookBtn.prop('disabled', false);
                    }
                }

                // Initial call in case a date is pre-selected
                // Initial call in case a date is pre-selected
                if (initialDate) {
                    updateAvailabilityInfo(initialDate);
                }

            });
        })(jQuery);
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function reviewForm() {
            return {
                categories: [{
                        name: "{{ __('translate.Location') }}",
                        rating: 0
                    },
                    {
                        name: "{{ __('translate.Price') }}",
                        rating: 0
                    },
                    {
                        name: "{{ __('translate.Amenities') }}",
                        rating: 0
                    },
                    {
                        name: "{{ __('translate.Rooms') }}",
                        rating: 0
                    },
                    {
                        name: "{{ __('translate.Services') }}",
                        rating: 0
                    }
                ],
                hoverRating: 0,
                hoverIndex: null,
                message: '',
                saveInfo: false,

                setRating(index, rating) {
                    this.categories[index].rating = rating;
                },

                submitForm() {
                    // Collect all form data
                    const data = {
                        service_id: `{{ $service->id }}`,
                        message: this.message,
                        ratings: this.categories.map(c => ({
                            category: c.name,
                            rating: c.rating
                        }))
                    };

                    if (!data.message.trim()) {
                        toastr.error('{{ __('Please write your review before submitting.') }}');
                        return;
                    }

                    if (data.ratings.some(c => c.rating === 0)) {
                        toastr.error('{{ __('Please select a rating before submitting.') }}');
                        return;
                    }

                    // Simulate form submission
                    this.ajaxSubmitForm(data);
                },

                resetForm() {
                    this.name = '';
                    this.email = '';
                    this.message = '';
                    this.saveInfo = false;
                    this.categories.forEach(c => c.rating = 0);
                },

                ajaxSubmitForm(data) {
                    fetch(`{{ route('front.tourbooking.reviews.store') }}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                toastr.success(data.message);
                                this.resetForm();
                            } else {
                                toastr.error(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('{{ __('An error occurred. Please try again later.') }}');
                        });
                }
            };
        }

        function bookingForm() {
            return {
                tickets: {
                    person: 1,
                    children: 0
                },
                pricePerPerson: {{ $service->price_per_person ?? 0 }},
                pricePerChild: {{ $service->child_price ?? 0 }},
                extras: {
                    @foreach ($service->extraCharges as $key => $extra)
                        charge_{{ $key }}: false,
                    @endforeach
                },
                extrasPrice: {
                    @foreach ($service->extraCharges as $key => $extra)
                        charge_{{ $key }}: {{ $extra->price ?? 0 }},
                    @endforeach
                },
                get totalCost() {
                    let total = 0;
                    total += this.tickets.person * this.pricePerPerson;
                    total += this.tickets.children * this.pricePerChild;
                    for (let key in this.extras) {
                        if (this.extras[key]) {
                            total += this.extrasPrice[key];
                        }
                    }
                    return total.toFixed(2);
                }
            };
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            GLightbox({ selector: '.service-gal-item', loop: true });

            if (window.Swiper && document.querySelector('.service-mobile-gallery-main')) {
                let mobileThumbs = null;
                const thumbsEl = document.querySelector('.service-mobile-gallery-thumbs');

                if (thumbsEl) {
                    mobileThumbs = new Swiper('.service-mobile-gallery-thumbs', {
                        slidesPerView: 3,
                        spaceBetween: 10,
                        watchSlidesProgress: true,
                        breakpoints: {
                            480: {
                                slidesPerView: 4
                            }
                        }
                    });
                }

                new Swiper('.service-mobile-gallery-main', {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.service-mobile-gallery-next',
                        prevEl: '.service-mobile-gallery-prev'
                    },
                    thumbs: mobileThumbs ? { swiper: mobileThumbs } : undefined
                });
            }
        });
    </script>
@endpush

@push('style_section')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <style>
        a.tg-listing-item-wishlist.active {
            color: var(--tg-theme-primary);
        }

        .tg-tour-about-cus-review-thumb img {
            height: 128px;
        }

        .tg-tour-details-video-ratings i {
            color: #a6a6a6;
        }

        .tg-tour-details-video-ratings i.active {
            color: var(--tg-common-yellow);
        }

        @media (max-width: 767.98px) {
            .tg-tour-details-video-feature-list ul {
                gap: 6px;
            }

            .tg-tour-details-video-feature-price {
                margin-top: 12px;
            }

            .tg-tour-details-video-feature-list ul li {
                margin-bottom: 4px;
                padding: 2px 0;
            }

            .tg-tour-details-video-feature-list ul li .icon {
                width: 32px;
                height: 32px;
                min-width: 32px;
                border-radius: 6px;
                margin-inline-end: 7px;
            }

            .tg-tour-details-video-feature-list ul li .icon svg {
                width: 13px;
                height: 13px;
            }

            .tg-tour-details-video-feature-list ul li .title {
                font-size: 14px;
                line-height: 1.2;
            }

            .tg-tour-details-video-feature-list ul li .duration {
                font-size: 12px;
                line-height: 1.25;
            }
        }

        .custom-select {
            min-width: 60px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #d6d6d6;
            border-radius: 24px;
            padding: 1px 14px;
            font-weight: 400;
            font-size: 16px;
            color: var(--tg-grey-1);
        }

        .custom-select:focus {
            outline: none;
            border-color: #C62828;
        }

        .calender-active.open .flatpickr-innerContainer .flatpickr-days .flatpickr-day.today,
        .flatpickr-calendar.open .flatpickr-innerContainer .flatpickr-days .flatpickr-day.selected {
            color: var(--tg-common-white) !important;
            background-color: var(--tg-theme-primary) !important;
        }
        /* Gallery hover effect */
        .service-gal-item { cursor: zoom-in; }
        .service-gal-img { transition: transform 0.35s ease; }
        .service-gal-item:hover .service-gal-img { transform: scale(1.04); }

        /* Tour plan / itinerary: open full image in GLightbox */
        .itinerary-image-link {
            display: block;
            overflow: hidden;
            border-radius: 8px;
        }

        .itinerary-image-link .itinerary-image {
            transition: transform 0.3s ease;
        }

        .itinerary-image-link:hover .itinerary-image {
            transform: scale(1.03);
        }

        /* Desktop (lg+): fixed bento grid — layout size stable; any image dimensions use cover */
        .service-desktop-gallery {
            display: none;
        }

        @media (min-width: 992px) {
            .service-desktop-gallery {
                display: grid;
                grid-template-columns: minmax(0, 7fr) minmax(0, 5fr);
                gap: 15px;
                align-items: stretch;
                width: 100%;
                min-height: 460px;
            }

            .service-desktop-gallery__hero {
                min-width: 0;
                min-height: 0;
                display: flex;
                flex-direction: column;
            }

            .service-desktop-gallery__stack {
                display: flex;
                flex-direction: column;
                gap: 15px;
                min-width: 0;
                min-height: 460px;
            }

            .service-desktop-gallery__stack-top {
                flex: 1 1 0;
                min-height: 0;
                display: flex;
                flex-direction: column;
            }

            .service-desktop-gallery__stack-bottom {
                flex: 1 1 0;
                min-height: 0;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
            }

            .service-desktop-gallery__stack-bottom:empty {
                display: none;
            }

            .service-desktop-gallery__stack:has(.service-desktop-gallery__stack-bottom:empty) .service-desktop-gallery__stack-top {
                flex: 1 1 auto;
                min-height: 460px;
            }

            .service-desktop-gallery__stack-bottom .service-desktop-gallery__thumb:only-child {
                grid-column: 1 / -1;
            }

            .service-desktop-gallery__thumb {
                border-radius: 14px;
                overflow: hidden;
                margin-bottom: 0 !important;
                position: relative;
            }

            .service-desktop-gallery__hero .service-desktop-gallery__thumb {
                flex: 1 1 auto;
                min-height: 460px;
                height: 100%;
            }

            .service-desktop-gallery__stack-top .service-desktop-gallery__thumb {
                flex: 1 1 0;
                min-height: 200px;
                height: 100%;
            }

            .service-desktop-gallery__stack-bottom .service-desktop-gallery__thumb {
                min-height: 200px;
                height: 100%;
            }

            .service-desktop-gallery__link {
                display: block;
                width: 100%;
                height: 100%;
            }

            .service-desktop-gallery__img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
                display: block;
            }
        }
        .service-gal-more {
            position: absolute; bottom: 10px; right: 10px;
            background: rgba(0,0,0,0.55); color: #fff;
            font-size: 14px; font-weight: 600;
            padding: 4px 10px; border-radius: 4px;
            pointer-events: none;
        }

        .service-mobile-gallery-main {
            position: relative;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
            border-radius: 12px;
        }

        .service-mobile-gallery-main .swiper-wrapper {
            align-items: stretch;
        }

        .service-mobile-gallery-main .swiper-slide {
            width: 100%;
            max-width: 100%;
            flex-shrink: 0;
        }

        .service-mobile-gallery-main .tg-tour-details-video-thumb {
            margin-bottom: 0;
            border-radius: 12px;
            overflow: hidden;
            height: 230px;
        }

        .service-mobile-gallery-main .service-gal-img,
        .service-mobile-gallery-main .tg-tour-details-video-thumb > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .service-mobile-gallery-main .service-mobile-gallery-prev,
        .service-mobile-gallery-main .service-mobile-gallery-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.45);
            color: #fff;
            z-index: 5;
        }

        .service-mobile-gallery-main .service-mobile-gallery-prev {
            left: 10px;
        }

        .service-mobile-gallery-main .service-mobile-gallery-next {
            right: 10px;
        }

        .service-mobile-thumb-wrap {
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
        }

        .service-mobile-gallery-thumbs .swiper-slide-thumb-active .service-mobile-thumb-wrap {
            border-color: #c62828;
        }

        .service-mobile-gallery-thumbs img {
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .service-mobile-gallery-thumbs .service-mobile-thumb-wrap {
            height: 72px;
        }

        .service-mobile-gallery-thumbs {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .service-mobile-gallery-thumbs .swiper-slide {
            opacity: 0.75;
        }

        .service-mobile-gallery-thumbs .swiper-slide-thumb-active {
            opacity: 1;
        }

        @media (max-width: 575.98px) {
            .service-mobile-gallery-main .tg-tour-details-video-thumb {
                height: 210px;
            }

            .service-mobile-gallery-main .service-mobile-gallery-prev,
            .service-mobile-gallery-main .service-mobile-gallery-next {
                width: 30px;
                height: 30px;
            }

            .service-mobile-gallery-thumbs .service-mobile-thumb-wrap {
                height: 64px;
            }
        }
    </style>
@endpush
