@php
    $theme3_hero = getContent('theme3_hero.content', true);
    $theme3_destinations = destinations();
@endphp

@if ($theme3_hero)
    <!-- tg-hero-area-start -->
    <div class="tg-hero-area tg-hero-tu-wrapper include-bg"
        data-background="{{ asset(getSingleImage($theme3_hero, 'background_image')) }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="tg-hero-content text-center">
                        <div class="tg-hero-title-box mb-30">
                            <h2 class="tg-hero-title wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".5s">
                                {{ getTranslatedValue($theme3_hero, 'title') }}
                            </h2>
                            <h3 class="tg-hero-tu-title wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".7s">
                                {{ getTranslatedValue($theme3_hero, 'sub_title') }}
                            </h3>
                        </div>
                        <div class="tg-hero-tu-avatar-wrap d-flex justify-content-center flex-wrap align-items-center wow fadeInUp"
                            data-wow-delay=".4s" data-wow-duration=".9s">
                            <span class="tg-hero-tu-avatar d-inline-block mr-10 mb-15">
                                <img src="{{ asset(getSingleImage($theme3_hero, 'peoples_image')) }}" alt="">
                            </span>
                            <span class="tg-hero-tu-avatar-text d-inline-block mr-10 p-relative mb-15">
                                {!! strip_tags(clean(getTranslatedValue($theme3_hero, 'description')), '<br>') !!}
                                <span class="tg-hero-tu-svg d-none d-md-block">
                                    <svg width="176" height="47" viewBox="0 0 176 47" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.2 7.99977C0.2 10.6507 2.34903 12.7998 5 12.7998C7.65097 12.7998 9.8 10.6507 9.8 7.99977C9.8 5.3488 7.65097 3.19977 5 3.19977C2.34903 3.19977 0.2 5.3488 0.2 7.99977ZM171.655 46.8313C172.114 47.022 172.64 46.8045 172.831 46.3454L175.938 38.8651C176.129 38.4061 175.911 37.8794 175.452 37.6887C174.993 37.4981 174.467 37.7156 174.276 38.1746L171.514 44.8238L164.865 42.0618C164.406 41.8712 163.879 42.0887 163.689 42.5477C163.498 43.0068 163.715 43.5335 164.174 43.7241L171.655 46.8313ZM5.25268 8.86357C5.86624 8.68409 6.48787 8.50783 7.11731 8.33483L6.64027 6.5992C6.0016 6.77473 5.37053 6.95367 4.74732 7.13596L5.25268 8.86357ZM10.9388 7.34766C12.198 7.04219 13.4836 6.74895 14.794 6.46825L14.4169 4.70818C13.0914 4.99215 11.7899 5.28897 10.5144 5.5984L10.9388 7.34766ZM18.6405 5.69357C19.9143 5.45278 21.2083 5.2233 22.5209 5.00537L22.2261 3.22968C20.9006 3.44974 19.5935 3.68155 18.3061 3.92489L18.6405 5.69357ZM26.4308 4.39835C27.7191 4.21188 29.0229 4.03616 30.3411 3.87141L30.1179 2.08531C28.7884 2.25147 27.473 2.42874 26.173 2.61692L26.4308 4.39835ZM34.2545 3.41905C35.5551 3.28069 36.8679 3.15277 38.1916 3.03546L38.0327 1.24249C36.6986 1.36071 35.3753 1.48966 34.0641 1.62915L34.2545 3.41905ZM42.1291 2.72024C43.432 2.62694 44.7442 2.54379 46.0644 2.47093L45.9652 0.673669C44.6353 0.747057 43.3134 0.830832 42.0005 0.924837L42.1291 2.72024ZM50.0167 2.28468C51.3255 2.23346 52.641 2.1923 53.9622 2.16134L53.92 0.361835C52.5894 0.393013 51.2645 0.434469 49.9463 0.486055L50.0167 2.28468ZM57.9102 2.09948C59.2248 2.08905 60.544 2.08871 61.8667 2.09861L61.8802 0.298661C60.5482 0.288691 59.2198 0.28903 57.8959 0.299533L57.9102 2.09948ZM65.8116 2.15842C67.126 2.18844 68.4429 2.22861 69.7614 2.27908L69.8302 0.480398C68.5025 0.429573 67.1763 0.389115 65.8527 0.358886L65.8116 2.15842ZM73.7083 2.46086C75.022 2.53162 76.3362 2.6127 77.6501 2.70424L77.7752 0.908592C76.4518 0.81639 75.1281 0.734727 73.8051 0.663463L73.7083 2.46086ZM81.5885 3.01027C82.9008 3.12285 84.2117 3.24603 85.5204 3.37994L85.7036 1.58929C84.385 1.45437 83.0643 1.33027 81.7424 1.21685L81.5885 3.01027ZM89.4468 3.81494C90.7544 3.971 92.0588 4.138 93.359 4.31607L93.6032 2.53271C92.2926 2.35322 90.9779 2.1849 89.6601 2.02762L89.4468 3.81494ZM97.2704 4.88737C98.5741 5.08985 99.8725 5.30374 101.165 5.5292L101.474 3.75599C100.171 3.52857 98.8612 3.31286 97.5467 3.1087L97.2704 4.88737ZM105.042 6.24447C106.341 6.49711 107.631 6.76181 108.914 7.0387L109.293 5.27925C107.999 4.99972 106.696 4.73256 105.386 4.47762L105.042 6.24447ZM112.756 7.91137C114.041 8.21805 115.317 8.53748 116.582 8.86982L117.039 7.12892C115.761 6.79302 114.472 6.47027 113.173 6.1605L112.756 7.91137ZM120.387 9.91877C121.655 10.2849 122.91 10.6647 124.152 11.0582L124.696 9.34233C123.439 8.94403 122.169 8.5598 120.887 8.18946L120.387 9.91877ZM127.893 12.3007C129.144 12.7358 130.379 13.1857 131.598 13.6505L132.239 11.9688C131.004 11.4974 129.752 11.0413 128.484 10.6005L127.893 12.3007ZM135.244 15.1088C136.464 15.6197 137.664 16.1466 138.843 16.6898L139.596 15.0549C138.397 14.5027 137.178 13.9673 135.94 13.4486L135.244 15.1088ZM142.388 18.4052C143.566 19.004 144.72 19.6203 145.849 20.2546L146.731 18.6854C145.58 18.0384 144.403 17.4102 143.203 16.8005L142.388 18.4052ZM149.214 22.247C150.336 22.9475 151.428 23.6675 152.489 24.4073L153.519 22.9309C152.432 22.1729 151.314 21.4361 150.167 20.7201L149.214 22.247ZM155.64 26.7371C156.676 27.55 157.676 28.3845 158.638 29.2409L159.835 27.8964C158.844 27.0142 157.816 26.1559 156.751 25.3209L155.64 26.7371ZM161.46 31.9276C162.376 32.8626 163.249 33.8214 164.077 34.8042L165.453 33.6444C164.595 32.626 163.692 31.634 162.746 30.668L161.46 31.9276ZM166.463 37.8796C167.218 38.9402 167.923 40.0265 168.576 41.1389L170.128 40.2274C169.448 39.0685 168.714 37.9381 167.93 36.8359L166.463 37.8796ZM170.385 44.5676C170.66 45.1529 170.921 45.7449 171.168 46.3438L172.832 45.6566C172.574 45.0314 172.301 44.4133 172.014 43.8025L170.385 44.5676Z"
                                            fill="white" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <div class="tg-booking-form-item tg-booking-tu-wrapper mt-15">
                            <form x-data="bookingForm()" @submit.prevent="submitForm">
                                <div class="tg-booking-form-input-group d-flex align-items-end justify-content-between">
                                    <div class="tg-booking-form-parent-inner tg-hero-quantity p-relative mr-15 mb-10">
                                        <span class="tg-booking-form-title">{{ __('translate.Location:') }}</span>
                                        <div class="tg-booking-add-input-field tg-booking-quantity-toggle">
                                            <span class="location">
                                                <svg width="13" height="16" viewBox="0 0 13 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.3329 6.7071C12.3329 11.2324 6.55512 15.1111 6.55512 15.1111C6.55512 15.1111 0.777344 11.2324 0.777344 6.7071C0.777344 5.16402 1.38607 3.68414 2.46962 2.59302C3.55316 1.5019 5.02276 0.888916 6.55512 0.888916C8.08748 0.888916 9.55708 1.5019 10.6406 2.59302C11.7242 3.68414 12.3329 5.16402 12.3329 6.7071Z"
                                                        stroke="currentColor" stroke-width="1.15556"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M6.55512 8.64649C7.61878 8.64649 8.48105 7.7782 8.48105 6.7071C8.48105 5.636 7.61878 4.7677 6.55512 4.7677C5.49146 4.7677 4.6292 5.636 4.6292 6.7071C4.6292 7.7782 5.49146 8.64649 6.55512 8.64649Z"
                                                        stroke="currentColor" stroke-width="1.15556"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>

                                            <span x-show="destination" x-text="destination"
                                                class="tg-booking-title-value">
                                                {{ __('translate.Select location') }}
                                            </span>
                                            <span x-show="!destination" class="tg-booking-title-value">
                                                {{ __('translate.Select location') }}
                                            </span>

                                            <span class="angle-down">
                                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6665 1L6.99984 6.33333L12.3332 1" stroke="#353844"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tg-booking-form-location-list tg-booking-quantity-active">
                                            <ul class="scrool-bar scrool-height pr-5">
                                                @foreach ($theme3_destinations as $key => $destination)
                                                    <li
                                                        @click="selectDestination(`{{ $destination->id }}`, `{{ $destination->localized_name }}`)">
                                                        <i class="fa-regular fa-location-dot"></i>
                                                        <span>{{ $destination->localized_name }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tg-booking-form-parent-inner mr-15 mb-10">
                                        <span class="tg-booking-form-title">{{ __('translate.Check in:') }}</span>
                                        <div class="tg-booking-add-input-date p-relative">
                                            <span>
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.76501 0.777771V3.26668M4.23413 0.777771V3.26668M0.777344 5.75548H13.2218M2.16006 2.02211H11.8391C12.6027 2.02211 13.2218 2.57927 13.2218 3.26656V11.9778C13.2218 12.6651 12.6027 13.2222 11.8391 13.2222H2.16006C1.39641 13.2222 0.777344 12.6651 0.777344 11.9778V3.26656C0.777344 2.57927 1.39641 2.02211 2.16006 2.02211Z"
                                                        stroke="currentColor" stroke-width="0.977778"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <input x-model="check_in" class="input datepicker" name="datetime-local"
                                                type="text" placeholder="{{ __("translate.Select Date") }}">
                                            <span class="angle-down">
                                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6665 1L6.99984 6.33333L12.3332 1" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="tg-booking-form-parent-inner mr-15 mb-10">
                                        <span class="tg-booking-form-title">{{ __('translate.Check in:') }}</span>
                                        <div class="tg-booking-add-input-date p-relative">
                                            <span>
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.76501 0.777771V3.26668M4.23413 0.777771V3.26668M0.777344 5.75548H13.2218M2.16006 2.02211H11.8391C12.6027 2.02211 13.2218 2.57927 13.2218 3.26656V11.9778C13.2218 12.6651 12.6027 13.2222 11.8391 13.2222H2.16006C1.39641 13.2222 0.777344 12.6651 0.777344 11.9778V3.26656C0.777344 2.57927 1.39641 2.02211 2.16006 2.02211Z"
                                                        stroke="currentColor" stroke-width="0.977778"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <input x-model="check_out" class="input datepicker" name="datetime-local"
                                                type="text" placeholder="{{ __("translate.Select Date") }}">
                                            <span class="angle-down">
                                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6665 1L6.99984 6.33333L12.3332 1" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="tg-booking-form-parent-inner tg-hero-quantity p-relative mr-15 mb-10">
                                        <span class="tg-booking-form-title">{{ __('translate.Guest:') }}</span>
                                        <div class="tg-booking-add-input-field tg-booking-quantity-toggle">
                                            <span class="location">
                                                <svg width="16" height="16" viewBox="0 0 16 16"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_53_98)">
                                                        <path
                                                            d="M1.51285 15.2889C1.33507 15.2889 1.15729 15.2 1.0684 15.1111C0.979514 14.9334 0.890625 14.8445 0.890625 14.6667C0.890625 13.4222 1.24618 12.1778 1.8684 11.0222C2.49063 9.95558 3.4684 8.9778 4.53507 8.35558C4.09062 7.82225 3.73507 7.11114 3.55729 6.40003C3.4684 5.68892 3.4684 4.88892 3.64618 4.26669C3.82396 3.55558 4.2684 2.84447 4.71285 2.31114C5.24618 1.7778 5.8684 1.33336 6.49063 1.15558C7.02396 0.977805 7.55729 0.888916 8.09063 0.888916C8.2684 0.888916 8.53507 0.888916 8.71285 0.888916C9.42396 0.977805 10.1351 1.24447 10.7573 1.68892C11.3795 2.13336 11.824 2.66669 12.1795 3.28892C12.5351 3.91114 12.7128 4.62225 12.7128 5.42225C12.7128 6.48892 12.3573 7.55558 11.6462 8.35558C12.1795 8.71114 12.7128 9.06669 13.2462 9.51114C13.9573 10.2222 14.4017 10.9334 14.8462 11.8222C15.2017 12.7111 15.3795 13.6 15.3795 14.5778C15.3795 14.7556 15.2906 14.9334 15.2017 15.0222C15.1128 15.1111 14.9351 15.2 14.7573 15.2C14.6684 15.2 14.5795 15.2 14.4906 15.1111C14.4017 15.1111 14.3128 15.0222 14.3128 14.9334C14.224 14.8445 14.224 14.8445 14.1351 14.7556C14.1351 14.6667 14.0462 14.5778 14.0462 14.4889C14.0462 13.6889 13.8684 12.9778 13.6017 12.2667C13.3351 11.5556 12.8906 10.9334 12.2684 10.4C11.7351 9.95558 11.2017 9.51114 10.5795 9.24447C9.8684 9.68892 9.0684 9.95558 8.09063 9.95558C7.20174 9.95558 6.31285 9.68892 5.60174 9.24447C4.62396 9.68892 3.73507 10.4 3.11285 11.3778C2.49063 12.3556 2.13507 13.4222 2.13507 14.5778C2.13507 14.7556 2.04618 14.9334 1.95729 15.0222C1.8684 15.2 1.69062 15.2889 1.51285 15.2889ZM8.09063 2.22225C7.4684 2.22225 6.84618 2.40003 6.31285 2.75558C5.69062 3.11114 5.33507 3.64447 5.0684 4.1778C4.80174 4.80003 4.71285 5.42225 4.89063 6.13336C4.97951 6.75558 5.33507 7.37781 5.77951 7.82225C6.22396 8.26669 6.84618 8.62225 7.4684 8.71114C7.64618 8.71114 7.91285 8.80003 8.09063 8.80003C8.53507 8.80003 8.97951 8.71114 9.33507 8.53336C9.95729 8.26669 10.4017 7.91114 10.8462 7.28892C11.2017 6.75558 11.3795 6.13336 11.3795 5.51114C11.3795 4.62225 11.024 3.82225 10.4017 3.20003C9.77951 2.48892 8.97951 2.22225 8.09063 2.22225Z"
                                                            fill="currentColor" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_523_98">
                                                            <rect width="16" height="16"
                                                                fill="currentColor" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>

                                            <div>
                                                <!-- Show this when no values are selected -->
                                                <span x-show="!rooms && !adults && !children"
                                                    class="tg-booking-title-value">
                                                    {{ __('translate.+ Add Guests') }}
                                                </span>

                                                <!-- Show this when any value exists -->
                                                <span x-show="rooms || adults || children"
                                                    class="tg-booking-title-value">
                                                    <template x-if="rooms">
                                                        <span class="tg-booking-title-value m-0" x-text="rooms + ' Room'"></span>
                                                    </template>
                                                    <template x-if="adults">
                                                        <span class="tg-booking-title-value m-0" x-text="', ' + adults + ' Adult'"></span>
                                                    </template>
                                                    <template x-if="children">
                                                        <span class="tg-booking-title-value m-0" x-text="', ' + children + ' Child'"></span>
                                                    </template>
                                                </span>
                                            </div>

                                            <span class="angle-down">
                                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.6665 1L6.99984 6.33333L12.3332 1" stroke="#353844"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div
                                            class="tg-booking-form-location-list tg-quantity tg-booking-quantity-active">
                                            <ul>
                                                <li>
                                                    <span class="mr-20">{{ __('translate.Rooms') }}</span>
                                                    <div class="tg-booking-quantity-item">
                                                        <span @click="incrementRooms" class="increment">
                                                            <svg width="15" height="14" viewBox="0 0 15 14"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.21924 7H13.3836" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M7.30176 13V1" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <input x-bind:value="rooms" class="tg-quantity-input"
                                                            type="text">
                                                        <span @click="decrementRooms" class="decrement">
                                                            <svg width="14" height="2" viewBox="0 0 14 2"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 1H13" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span class="mr-20">{{ __('translate.Adults') }}</span>
                                                    <div class="tg-booking-quantity-item">
                                                        <span @click="incrementAdults" class="increment">
                                                            <svg width="15" height="14" viewBox="0 0 15 14"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.21924 7H13.3836" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M7.30176 13V1" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <input x-bind:value="adults" class="tg-quantity-input"
                                                            type="text">
                                                        <span @click="decrementAdults" class="decrement">
                                                            <svg width="14" height="2" viewBox="0 0 14 2"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 1H13" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span class="mr-20">{{ __('translate.Children') }}</span>
                                                    <div class="tg-booking-quantity-item">
                                                        <span @click="incrementChildren" class="increment">
                                                            <svg width="15" height="14" viewBox="0 0 15 14"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.21924 7H13.3836" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M7.30176 13V1" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <input x-bind:value="children" class="tg-quantity-input"
                                                            type="text">
                                                        <span @click="decrementChildren" class="decrement">
                                                            <svg width="14" height="2" viewBox="0 0 14 2"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1 1H13" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tg-booking-form-search-btn mb-10">
                                        <button class="bk-search-button" type="submit">{{ __('translate.Search') }}
                                            <span class="ml-5">
                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_53_103)">
                                                        <path
                                                            d="M13.2218 13.2222L10.5188 10.5192M12.1959 6.48705C12.1959 9.6402 9.63977 12.1963 6.48662 12.1963C3.33348 12.1963 0.777344 9.6402 0.777344 6.48705C0.777344 3.3339 3.33348 0.777771 6.48662 0.777771C9.63977 0.777771 12.1959 3.3339 12.1959 6.48705Z"
                                                            stroke="currentColor" stroke-width="1.575"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_53_103">
                                                            <rect width="14" height="14"
                                                                fill="currentColor" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tg-hero-area-end -->

    @push('js_section')
        <script>
            (function($) {
                "use strict"
                $(document).ready(function() {

                    // Initialize datepicker
                    $(".datepicker").flatpickr({
                        enableTime: false,
                        noCalendar: false,
                        dateFormat: "Y-m-d"
                    });
                });
            })(jQuery);
        </script>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            function bookingForm() {
                return {
                    destination: '',
                    destination_id: '',
                    check_in: '',
                    check_out: '',
                    rooms: '',
                    adults: '',
                    children: '',

                    selectDestination(destinationId, destinationName) {
                        this.destination_id = destinationId;
                        this.destination = destinationName;
                       this.closeDestinationDropdown();
                    },

                    closeDestinationDropdown() {
                        $('.tg-booking-quantity-toggle').removeClass('active');
                        $('.tg-booking-quantity-active').removeClass('tg-list-open');
                    },

                    incrementRooms() {
                        this.rooms++;
                    },
                    decrementRooms() {
                        if (this.rooms > 0) {
                            this.rooms--;
                        }
                    },
                    incrementAdults() {
                        this.adults++;
                    },
                    decrementAdults() {
                        if (this.adults > 0) {
                            this.adults--;
                        }
                    },
                    incrementChildren() {
                        this.children++;
                    },
                    decrementChildren() {
                        if (this.children > 0) {
                            this.children--;
                        }
                    },

                    submitForm() {
                        const params = new URLSearchParams({
                            destination: this.destination,
                            destination_id: this.destination_id,
                            check_in: this.check_in,
                            check_out: this.check_out,
                            rooms: this.rooms,
                            adults: this.adults,
                            children: this.children
                        });

                        window.location.href = `{{ route('front.tourbooking.services') }}?` + params.toString();
                    }
                }
            }
        </script>
    @endpush
@endif
