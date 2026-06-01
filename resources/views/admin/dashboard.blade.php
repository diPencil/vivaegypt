@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Dashboard') }}</title>
@endsection
@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Dashboard') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Dashboard') }}</p>
@endsection
@push('style_section')
    <link rel="stylesheet" href="{{ asset('backend/css/charts.min.css') }}">
@endpush
@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <div class="row">
                                @if ($showFinancialCards)
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">
                                            <span>
                                                @include('svg.total_sale')
                                            </span>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Total Sale') }}
                                                        </h4>
                                                    </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">
                                                                {{ currency($total_income) }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif


                                @if ($showFinancialCards)
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">
                                            <span>
                                                @include('svg.net_earning')
                                            </span>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">
                                                            {{ __('translate.Admin Earnings') }} </h4>
                                                    </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">
                                                                {{ currency($total_commission) }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif


                                @if ($showFinancialCards)
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">
                                            <span>
                                                @include('svg.seller_earning')
                                            </span>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">
                                                            {{ __('translate.Seller Earnings') }} </h4>
                                                    </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">
                                                                {{ currency($net_income) }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if ($showOperationsCards)
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-ecom-card crancy-ecom-card__v2">
                                        <div class="flex-main">
                                            <span>
                                                @include('svg.total_sold')
                                            </span>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">
                                                            {{ __('translate.Total Sold') }} </h4>
                                                    </div>

                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $total_sold }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- Row 2 --}}
                                @if ($showOperationsCards)
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <a href="{{ route('admin.tourbooking.bookings.index') }}" class="crancy-ecom-card crancy-ecom-card__v2 d-block">
                                        <div class="flex-main">
                                            <div class="d-inline-flex justify-content-center align-items-center bg-primary-white rounded-circle grid-icon-size">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C62828" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Total Bookings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $total_bookings_count }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <a href="{{ route('admin.tourbooking.bookings.status', 'pending') }}" class="crancy-ecom-card crancy-ecom-card__v2 d-block">
                                        <div class="flex-main">
                                            <div class="d-inline-flex justify-content-center align-items-center bg-primary-white rounded-circle grid-icon-size">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C62828" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Pending Bookings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $pending_bookings_count }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <a href="{{ route('admin.user-list') }}" class="crancy-ecom-card crancy-ecom-card__v2 d-block">
                                        <div class="flex-main">
                                            <div class="d-inline-flex justify-content-center align-items-center bg-primary-white rounded-circle grid-icon-size">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C62828" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Total Customers') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $total_customers_count }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <a href="{{ route('admin.live-chat.index') }}" class="crancy-ecom-card crancy-ecom-card__v2 d-block">
                                        <div class="flex-main">
                                            <div class="d-inline-flex justify-content-center align-items-center bg-primary-white rounded-circle grid-icon-size">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#C62828" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="crancy-ecom-card__heading">
                                                    <div class="crancy-ecom-card__icon">
                                                        <h4 class="crancy-ecom-card__title">{{ __('translate.Live Chat') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="crancy-ecom-card__content">
                                                    <div class="crancy-ecom-card__camount">
                                                        <div class="crancy-ecom-card__camount__inside">
                                                            <h3 class="crancy-ecom-card__amount">{{ $live_chat_count }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                            </div>

                            <div class="row crancy-gap-30">
                                <div class="col-12">
                                    <!-- Charts One -->
                                    <div class="charts-main charts-home-one mg-top-30">
                                        <!-- Top Heading -->
                                        <div class="charts-main__heading  mg-btm-20">
                                            <h4 class="charts-main__title">{{ __('translate.Booking Statistics') }}</h4>

                                        </div>
                                        <div class="charts-main__one">
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="crancy-chart__s1" role="tabpanel"
                                                    aria-labelledby="crancy-chart__s1">
                                                    <div class="crancy-chart__inside crancy-chart__three">
                                                        <!-- Chart One -->
                                                        <canvas id="myChart_recent_statics"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Charts One -->
                                </div>
                            </div>

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                <div class="crancy-customer-filter">
                                    <div
                                        class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div
                                            class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Latest Bookings') }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class=" dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3  no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Booking Code') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Service Title') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Total Amount') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Location') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($bookings as $booking)
                                                @php
                                                    $bookingStatusLabel = match ($booking->booking_status) {
                                                        'confirmed' => __('translate.Confirmed'),
                                                        'pending' => __('translate.Pending'),
                                                        'cancelled' => __('translate.Cancelled'),
                                                        'completed' => __('translate.Completed'),
                                                        'success' => __('translate.Success'),
                                                        default => ucfirst($booking->booking_status),
                                                    };
                                                @endphp
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2 crancy-table__cell-ltr">
                                                        #{{ $booking->booking_code ?? 'N/A' }}</td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ Str::limit($booking->service->title, 50) }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ currency($booking->total) }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $booking?->service?->location ?? 'N/A' }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span
                                                            class="crancy-badge crancy-table__status--paid">{{ $bookingStatusLabel }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ route('admin.tourbooking.bookings.show', $booking) }}"
                                                            class="crancy-action__btn crancy-action__edit crancy-btn"><i
                                                                class="fas fa-eye"></i>
                                                            {{ __('translate.Details') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>


            </div>


        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection

@push('js_section')
    <script src="{{ asset('backend/js/charts.js') }}"></script>

    <script>
        "use strict";

        const dashboardChartRtl = @json(Session::get('lang_dir') == 'right_to_left');

        let purchase_data = @json($data);
        purchase_data = JSON.parse(purchase_data);

        let date_lable = @json($lable);
        date_lable = JSON.parse(date_lable);

        // Chart Three (mirror layout for RTL: Chart.js rtl + Y-axis on the right + flipped gradient)
        const ctx_myChart_recent_statics = document.getElementById('myChart_recent_statics').getContext('2d');
        const gradientBgs = dashboardChartRtl
            ? ctx_myChart_recent_statics.createLinearGradient(100, 100, 400, 400)
            : ctx_myChart_recent_statics.createLinearGradient(400, 100, 100, 400);

        gradientBgs.addColorStop(0, 'rgba(198, 40, 40, 0.12)');
        gradientBgs.addColorStop(1, 'rgba(198, 40, 40, 0.45)');

        const myChart_recent_statics = new Chart(ctx_myChart_recent_statics, {
            type: 'line',

            data: {

                labels: date_lable,
                datasets: [{
                    label: 'Sells',
                    data: purchase_data,
                    backgroundColor: gradientBgs,
                    borderColor: '#C62828',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    fillColor: '#fff',
                    fill: 'start',
                    pointRadius: 4,
                    pointBackgroundColor: '#C62828',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#b71c1c',
                    pointHoverBorderColor: '#fff',
                }]
            },

            options: {
                rtl: dashboardChartRtl,
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#718096',
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                            color: '#FFE5E5',
                        },
                        suggestedMax: 100,
                        suggestedMin: 50,

                    },
                    y: {
                        position: dashboardChartRtl ? 'right' : 'left',
                        ticks: {
                            color: '#718096',
                            callback: function(value, index, values) {
                                return (value / 10) * 10 + '$';
                            }
                        },
                        grid: {
                            drawBorder: false,
                            color: '#D7DCE7',
                            borderDash: [5, 5]
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        padding: 10,
                        displayColors: true,
                        yAlign: 'bottom',
                        backgroundColor: '#fff',
                        titleColor: '#000',
                        titleFont: {
                            weight: 'normal'
                        },
                        bodyColor: '#2F3032',
                        cornerRadius: 12,
                        boxPadding: 3,
                        usePointStyle: true,
                        borderWidth: 0,
                        font: {
                            size: 14
                        },
                        caretSize: 9,
                        bodySpacing: 100,
                    },
                    legend: {
                        position: 'bottom',
                        display: false,
                    },
                    title: {
                        display: false,
                        text: "{{ __('translate.Purchase History') }}"
                    }
                }
            }
        });
    </script>
@endpush
