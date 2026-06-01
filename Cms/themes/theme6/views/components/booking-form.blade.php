@php
    $theme6_destinations = destinations();
    $theme6_service_type = serviceTypeTab();
@endphp

@if ($theme6_service_type->count() > 0)

{{-- booking-form-area-start --}}
<div class="t6bf-wrapper">
    <div class="container">

        {{-- ── Tabs ── --}}
        <div class="t6bf-tabs-row nav" id="t6bfTabList" role="tablist">
            @foreach ($theme6_service_type as $key => $service_type)
                <button
                    class="t6bf-tab {{ $loop->first ? 't6bf-tab--active active' : '' }}"
                    id="t6bf-tab-{{ $service_type->id }}"
                    data-bs-toggle="tab"
                    data-bs-target="#t6bf-panel-{{ $service_type->id }}"
                    type="button" role="tab"
                    aria-controls="t6bf-panel-{{ $service_type->id }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    @if ($service_type->image)
                        <img src="{{ asset($service_type->image) }}" width="18" height="18" class="t6bf-tab-icon" alt="">
                    @elseif ($service_type->icon)
                        <i class="{{ $service_type->icon }} t6bf-tab-icon"></i>
                    @endif
                    {{ $service_type->name }}
                </button>
            @endforeach
        </div>

        {{-- ── Tab panels ── --}}
        <div class="tab-content t6bf-panel--first-active" id="t6bfTabContent">
            @foreach ($theme6_service_type as $key => $service_type)
                <div
                    class="tab-pane {{ $loop->first ? 'show active' : '' }}"
                    id="t6bf-panel-{{ $service_type->id }}"
                    role="tabpanel"
                    aria-labelledby="t6bf-tab-{{ $service_type->id }}">

                    {{-- ── Card ── --}}
                    <div class="t6bf-card">
                        <form x-data="bookingForm()" @submit.prevent="submitForm">
                            <div class="t6bf-fields">

                                {{-- Destination --}}
                                <div class="t6bf-field t6bf-field--dest tg-hero-quantity p-relative">
                                    <span class="t6bf-label">{{ __('translate.Destinations:') }}</span>
                                    <div class="t6bf-input-trigger tg-booking-quantity-toggle">
                                        <span x-show="destination" x-text="destination" class="t6bf-value"></span>
                                        <span x-show="!destination" class="t6bf-placeholder">
                                            {{ __('translate.Where are you going . . .') }}
                                        </span>
                                        <svg class="t6bf-field-icon" width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.3329 6.7071C12.3329 11.2324 6.55512 15.1111 6.55512 15.1111C6.55512 15.1111 0.777344 11.2324 0.777344 6.7071C0.777344 5.16402 1.38607 3.68414 2.46962 2.59302C3.55316 1.5019 5.02276 0.888916 6.55512 0.888916C8.08748 0.888916 9.55708 1.5019 10.6406 2.59302C11.7242 3.68414 12.3329 5.16402 12.3329 6.7071Z" stroke="currentColor" stroke-width="1.15556" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.55512 8.64649C7.61878 8.64649 8.48105 7.7782 8.48105 6.7071C8.48105 5.636 7.61878 4.7677 6.55512 4.7677C5.49146 4.7677 4.6292 5.636 4.6292 6.7071C4.6292 7.7782 5.49146 8.64649 6.55512 8.64649Z" stroke="currentColor" stroke-width="1.15556" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="tg-booking-form-location-list tg-booking-quantity-active">
                                        <ul class="scrool-bar scrool-height pr-5">
                                            @foreach ($theme6_destinations as $destination)
                                                <li @click="selectDestination(`{{ $destination->id }}`, `{{ $destination->localized_name }}`)">
                                                    <i class="fa-regular fa-location-dot"></i>
                                                    <span>{{ $destination->localized_name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="t6bf-divider"></div>

                                {{-- Check In --}}
                                <div class="t6bf-field t6bf-field--date">
                                    <span class="t6bf-label">{{ __('translate.Check in:') }}</span>
                                    <div class="t6bf-date-wrap">
                                        <input
                                            x-model="check_in"
                                            class="t6bf-date-input datepicker"
                                            name="t6bf_check_in"
                                            type="text"
                                            placeholder="{{ __('translate.Select start date') }}"
                                            autocomplete="off">
                                        <svg class="t6bf-field-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.76501 0.777771V3.26668M4.23413 0.777771V3.26668M0.777344 5.75548H13.2218M2.16006 2.02211H11.8391C12.6027 2.02211 13.2218 2.57927 13.2218 3.26656V11.9778C13.2218 12.6651 12.6027 13.2222 11.8391 13.2222H2.16006C1.39641 13.2222 0.777344 12.6651 0.777344 11.9778V3.26656C0.777344 2.57927 1.39641 2.02211 2.16006 2.02211Z" stroke="currentColor" stroke-width="0.977778" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="t6bf-divider"></div>

                                {{-- Check Out --}}
                                <div class="t6bf-field t6bf-field--date">
                                    <span class="t6bf-label">{{ __('translate.Check Out:') }}</span>
                                    <div class="t6bf-date-wrap">
                                        <input
                                            x-model="check_out"
                                            class="t6bf-date-input datepicker"
                                            name="t6bf_check_out"
                                            type="text"
                                            placeholder="{{ __('translate.Select end date') }}"
                                            autocomplete="off">
                                        <svg class="t6bf-field-icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.76501 0.777771V3.26668M4.23413 0.777771V3.26668M0.777344 5.75548H13.2218M2.16006 2.02211H11.8391C12.6027 2.02211 13.2218 2.57927 13.2218 3.26656V11.9778C13.2218 12.6651 12.6027 13.2222 11.8391 13.2222H2.16006C1.39641 13.2222 0.777344 12.6651 0.777344 11.9778V3.26656C0.777344 2.57927 1.39641 2.02211 2.16006 2.02211Z" stroke="currentColor" stroke-width="0.977778" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="t6bf-divider"></div>

                                {{-- Guests --}}
                                <div class="t6bf-field t6bf-field--guests tg-hero-quantity p-relative">
                                    <span class="t6bf-label">{{ __('translate.Guest:') }}</span>
                                    <div class="t6bf-input-trigger tg-booking-quantity-toggle">
                                        <div style="flex:1; min-width:0; overflow:hidden;">
                                            <span x-show="!rooms && !adults && !children" class="t6bf-placeholder">
                                                {{ __('translate.+ Add Guests') }}
                                            </span>
                                            <span x-show="rooms || adults || children" class="t6bf-value">
                                                <template x-if="rooms">
                                                    <span x-text="rooms + ' {{ __('translate.Room') }}'"></span>
                                                </template>
                                                <template x-if="adults">
                                                    <span x-text="', ' + adults + ' {{ __('translate.Adult') }}'"></span>
                                                </template>
                                                <template x-if="children">
                                                    <span x-text="', ' + children + ' {{ __('translate.Child') }}'"></span>
                                                </template>
                                            </span>
                                        </div>
                                        <svg class="t6bf-field-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_t6bf_guest)">
                                                <path d="M1.51285 15.2889C1.33507 15.2889 1.15729 15.2 1.0684 15.1111C0.979514 14.9334 0.890625 14.8445 0.890625 14.6667C0.890625 13.4222 1.24618 12.1778 1.8684 11.0222C2.49063 9.95558 3.4684 8.9778 4.53507 8.35558C4.09062 7.82225 3.73507 7.11114 3.55729 6.40003C3.4684 5.68892 3.4684 4.88892 3.64618 4.26669C3.82396 3.55558 4.2684 2.84447 4.71285 2.31114C5.24618 1.7778 5.8684 1.33336 6.49063 1.15558C7.02396 0.977805 7.55729 0.888916 8.09063 0.888916C8.2684 0.888916 8.53507 0.888916 8.71285 0.888916C9.42396 0.977805 10.1351 1.24447 10.7573 1.68892C11.3795 2.13336 11.824 2.66669 12.1795 3.28892C12.5351 3.91114 12.7128 4.62225 12.7128 5.42225C12.7128 6.48892 12.3573 7.55558 11.6462 8.35558C12.1795 8.71114 12.7128 9.06669 13.2462 9.51114C13.9573 10.2222 14.4017 10.9334 14.8462 11.8222C15.2017 12.7111 15.3795 13.6 15.3795 14.5778C15.3795 14.7556 15.2906 14.9334 15.2017 15.0222C15.1128 15.1111 14.9351 15.2 14.7573 15.2C14.6684 15.2 14.5795 15.2 14.4906 15.1111C14.4017 15.1111 14.3128 15.0222 14.3128 14.9334C14.224 14.8445 14.224 14.8445 14.1351 14.7556C14.1351 14.6667 14.0462 14.5778 14.0462 14.4889C14.0462 13.6889 13.8684 12.9778 13.6017 12.2667C13.3351 11.5556 12.8906 10.9334 12.2684 10.4C11.7351 9.95558 11.2017 9.51114 10.5795 9.24447C9.8684 9.68892 9.0684 9.95558 8.09063 9.95558C7.20174 9.95558 6.31285 9.68892 5.60174 9.24447C4.62396 9.68892 3.73507 10.4 3.11285 11.3778C2.49063 12.3556 2.13507 13.4222 2.13507 14.5778C2.13507 14.7556 2.04618 14.9334 1.95729 15.0222C1.8684 15.2 1.69062 15.2889 1.51285 15.2889ZM8.09063 2.22225C7.4684 2.22225 6.84618 2.40003 6.31285 2.75558C5.69062 3.11114 5.33507 3.64447 5.0684 4.1778C4.80174 4.80003 4.71285 5.42225 4.89063 6.13336C4.97951 6.75558 5.33507 7.37781 5.77951 7.82225C6.22396 8.26669 6.84618 8.62225 7.4684 8.71114C7.64618 8.71114 7.91285 8.80003 8.09063 8.80003C8.53507 8.80003 8.97951 8.71114 9.33507 8.53336C9.95729 8.26669 10.4017 7.91114 10.8462 7.28892C11.2017 6.75558 11.3795 6.13336 11.3795 5.51114C11.3795 4.62225 11.024 3.82225 10.4017 3.20003C9.77951 2.48892 8.97951 2.22225 8.09063 2.22225Z" fill="currentColor"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_t6bf_guest">
                                                    <rect width="16" height="16" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="tg-booking-form-location-list tg-quantity tg-booking-quantity-active">
                                        <ul>
                                            <li>
                                                <span>{{ __('translate.Rooms') }}</span>
                                                <div class="tg-booking-quantity-item">
                                                    <span @click="incrementRooms" class="increment">
                                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.21924 7H13.3836" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.30176 13V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <input x-bind:value="rooms" class="tg-quantity-input" type="text" readonly>
                                                    <span @click="decrementRooms" class="decrement">
                                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                </div>
                                            </li>
                                            <li>
                                                <span>{{ __('translate.Adults') }}</span>
                                                <div class="tg-booking-quantity-item">
                                                    <span @click="incrementAdults" class="increment">
                                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.21924 7H13.3836" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.30176 13V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <input x-bind:value="adults" class="tg-quantity-input" type="text" readonly>
                                                    <span @click="decrementAdults" class="decrement">
                                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                </div>
                                            </li>
                                            <li>
                                                <span>{{ __('translate.Children') }}</span>
                                                <div class="tg-booking-quantity-item">
                                                    <span @click="incrementChildren" class="increment">
                                                        <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.21924 7H13.3836" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.30176 13V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <input x-bind:value="children" class="tg-quantity-input" type="text" readonly>
                                                    <span @click="decrementChildren" class="decrement">
                                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Search button --}}
                                <button class="t6bf-search-btn" type="submit">
                                    {{ __('translate.Search') }}
                                    <svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_t6bf_search)">
                                            <path d="M13.2218 13.2222L10.5188 10.5192M12.1959 6.48705C12.1959 9.6402 9.63977 12.1963 6.48662 12.1963C3.33348 12.1963 0.777344 9.6402 0.777344 6.48705C0.777344 3.3339 3.33348 0.777771 6.48662 0.777771C9.63977 0.777771 12.1959 3.3339 12.1959 6.48705Z" stroke="currentColor" stroke-width="1.575" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs><clipPath id="clip0_t6bf_search"><rect width="14" height="14" fill="white"/></clipPath></defs>
                                    </svg>
                                </button>

                            </div>{{-- /.t6bf-fields --}}
                        </form>
                    </div>{{-- /.t6bf-card --}}

                </div>{{-- /.tab-pane --}}
            @endforeach
        </div>{{-- /.tab-content --}}

    </div>{{-- /.container --}}
</div>{{-- /.t6bf-wrapper --}}
{{-- booking-form-area-end --}}

@push('js_section')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                // Sync active class on tab buttons (Bootstrap fires 'shown.bs.tab')
                $('#t6bfTabList button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
                    $('#t6bfTabList .t6bf-tab--active').removeClass('t6bf-tab--active');
                    $(this).addClass('t6bf-tab--active');

                    // Remove first-active class when a non-first tab is selected
                    var isFirst = $(this).parent().is(':first-child') ||
                                  $(this).is('#t6bfTabList button:first-of-type');
                    if (isFirst) {
                        $('#t6bfTabContent').addClass('t6bf-panel--first-active');
                    } else {
                        $('#t6bfTabContent').removeClass('t6bf-panel--first-active');
                    }
                });

                // Flatpickr: only theme6 hero inputs (.t6bf-date-input). Do NOT use
                // name="datetime-local" here — global main.js already binds those site-wide.
                document.querySelectorAll('.t6bf-wrapper .t6bf-date-input.datepicker').forEach(function (el) {
                    if (el._flatpickr) {
                        el._flatpickr.destroy();
                    }
                    flatpickr(el, {
                        enableTime: false,
                        noCalendar: false,
                        dateFormat: 'Y-m-d',
                        disableMobile: false,
                    });
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
                    this.destination    = destinationName;
                    this.closeDestinationDropdown();
                },

                closeDestinationDropdown() {
                    $('.tg-booking-quantity-toggle').removeClass('active');
                    $('.tg-booking-quantity-active').removeClass('tg-list-open');
                },

                incrementRooms()    { this.rooms++;                              },
                decrementRooms()    { if (this.rooms > 0)    this.rooms--;       },
                incrementAdults()   { this.adults++;                             },
                decrementAdults()   { if (this.adults > 0)   this.adults--;      },
                incrementChildren() { this.children++;                           },
                decrementChildren() { if (this.children > 0) this.children--;    },

                submitForm() {
                    const params = new URLSearchParams({
                        destination:    this.destination,
                        destination_id: this.destination_id,
                        check_in:       this.check_in,
                        check_out:      this.check_out,
                        rooms:          this.rooms,
                        adults:         this.adults,
                        children:       this.children,
                    });
                    window.location.href = `{{ route('front.tourbooking.services') }}?` + params.toString();
                }
            }
        }
    </script>
@endpush

@endif
