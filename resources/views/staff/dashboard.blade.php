@extends(dashboard_layout())

@section('title')
    <title>{{ dashboard_label('Staff Dashboard') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ dashboard_label('Staff Dashboard') }}</h3>
    <p class="crancy-header__text">{{ dashboard_label('Dashboard') }} >> {{ dashboard_label('Dashboard') }}</p>
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
                                @if (!empty($dashboardCards))
                                    @foreach ($dashboardCards as $card)
                                        <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                            <div class="crancy-ecom-card crancy-ecom-card__v2 h-100">
                                                <a href="{{ $card['route'] }}" class="flex-main h-100" style="text-decoration: none;">
                                                    <span>
                                                        @include($card['icon'])
                                                    </span>
                                                    <div class="flex-1">
                                                        <div class="crancy-ecom-card__heading">
                                                            <div class="crancy-ecom-card__icon">
                                                                <h4 class="crancy-ecom-card__title">{{ dashboard_label($card['label']) }}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="crancy-ecom-card__content">
                                                            <div class="crancy-ecom-card__camount">
                                                                <div class="crancy-ecom-card__camount__inside">
                                                                    <h3 class="crancy-ecom-card__amount">{{ $card['value'] }}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                     {{-- Fallback: If no cards are authorized, show a default welcome or limited stats --}}
                                     @if ($showFinancialCards)
                                        <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                            <div class="crancy-ecom-card crancy-ecom-card__v2">
                                                <div class="flex-main">
                                                    <span>@include('svg.total_sale')</span>
                                                    <div class="flex-1">
                                                        <div class="crancy-ecom-card__heading">
                                                            <div class="crancy-ecom-card__icon">
                                                                <h4 class="crancy-ecom-card__title">{{ dashboard_label('Total Sale') }}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="crancy-ecom-card__content">
                                                            <div class="crancy-ecom-card__camount">
                                                                <div class="crancy-ecom-card__camount__inside">
                                                                    <h3 class="crancy-ecom-card__amount">{{ currency($totalIncome) }}</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     @endif
                                @endif
                            </div>
                            
                            @if($user?->isStaffAccountant() || $user?->canSeeStaffSection('finance'))
                            <div class="row mg-top-30">
                                <div class="col-12">
                                    <div class="crancy-main__column">
                                        <h4 class="crancy-product-card__title mg-btm-20" style="font-size: 18px; font-weight: 600; color: #1e293b; border-left: 4px solid #ef4444; padding-left: 12px;">
                                            {{ dashboard_label('Financial Control Center') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Payment Summary -->
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-product-card h-100" style="background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #edf2f7;">
                                        <h4 class="crancy-product-card__title mg-btm-15" style="font-size: 15px;">{{ dashboard_label('Payment Summary') }}</h4>
                                        <ul class="crancy-list-none">
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Confirmed') }}</span>
                                                <span class="badge bg-success-transparent text-success">{{ $financialData['payments']['success'] }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Pending') }}</span>
                                                <span class="badge bg-warning-transparent text-warning">{{ $financialData['payments']['pending'] }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span style="color: #1e293b; font-weight: 600;">{{ dashboard_label('Total Records') }}</span>
                                                <span style="font-weight: 600;">{{ $financialData['payments']['total'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Withdrawals Summary -->
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-product-card h-100" style="background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #edf2f7;">
                                        <h4 class="crancy-product-card__title mg-btm-15" style="font-size: 15px;">{{ dashboard_label('Withdrawals Summary') }}</h4>
                                        <ul class="crancy-list-none">
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Approved') }}</span>
                                                <span class="badge bg-primary-transparent text-primary">{{ $financialData['withdrawals']['approved'] }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Pending') }}</span>
                                                <span class="badge bg-warning-transparent text-warning">{{ $financialData['withdrawals']['pending'] }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Rejected') }}</span>
                                                <span class="badge bg-danger-transparent text-danger">{{ $financialData['withdrawals']['rejected'] }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span style="color: #1e293b; font-weight: 600;">{{ dashboard_label('Total') }}</span>
                                                <span style="font-weight: 600;">{{ $financialData['withdrawals']['total'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Revenue Breakdown -->
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-product-card h-100" style="background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #edf2f7;">
                                        <h4 class="crancy-product-card__title mg-btm-15" style="font-size: 15px;">{{ dashboard_label('Revenue Breakdown') }}</h4>
                                        <ul class="crancy-list-none">
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Total Sales (Gross)') }}</span>
                                                <span style="color: #1e293b; font-weight: 500;">{{ currency($financialData['revenue']['total_sales']) }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between mg-btm-10">
                                                <span style="color: #64748b;">{{ dashboard_label('Agent Earnings (Share)') }}</span>
                                                <span style="color: #1e293b; font-weight: 500;">{{ currency($financialData['revenue']['agent_earnings']) }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span style="color: #ef4444; font-weight: 600;">{{ dashboard_label('Admin Commission') }}</span>
                                                <span style="color: #ef4444; font-weight: 600;">{{ currency($financialData['revenue']['admin_commission']) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Quick Accountant Actions -->
                                <div class="col-xxl-3 col-md-6 col-12 mg-top-30">
                                    <div class="crancy-product-card h-100" style="background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #edf2f7;">
                                        <h4 class="crancy-product-card__title mg-btm-15" style="font-size: 15px;">{{ dashboard_label('Quick Accountant Actions') }}</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($financialData['actions'] as $action)
                                                <a href="{{ $action['route'] }}" class="btn btn-outline-secondary btn-sm d-flex items-center gap-2" style="font-size: 12px; border-color: #edf2f7; color: #475569;">
                                                    <i class="{{ $action['icon'] }}"></i> {{ dashboard_label($action['label']) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row crancy-gap-30">
                                <div class="col-12">
                                    <!-- Charts One -->
                                    <div class="charts-main charts-home-one mg-top-30">
                                        <!-- Top Heading -->
                                        <div class="charts-main__heading  mg-btm-20">
                                            <h4 class="charts-main__title">{{ dashboard_label('Booking Statistics') }}</h4>
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
                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ dashboard_label('Latest Bookings') }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class=" dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3  no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Booking Code') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Service Title') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Customer') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Total Amount') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Payment') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">
                                                    {{ dashboard_label('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($latestBookings as $booking)
                                                @php
                                                    $statusKey = strtolower((string) $booking->booking_status);
                                                    $bookingStatusLabel = match ($statusKey) {
                                                        'confirmed' => dashboard_label('Confirmed'),
                                                        'pending' => dashboard_label('Pending'),
                                                        'cancelled' => dashboard_label('Cancelled'),
                                                        'completed' => dashboard_label('Completed'),
                                                        'success' => dashboard_label('Success'),
                                                        default => ucfirst($statusKey),
                                                    };

                                                    $paymentStatusKey = strtolower((string) $booking->payment_status);
                                                    $paymentStatusLabel = match ($paymentStatusKey) {
                                                        'success', 'completed' => dashboard_label('Paid'),
                                                        'pending' => dashboard_label('Unpaid'),
                                                        default => ucfirst($paymentStatusKey),
                                                    };
                                                    $paymentStatusClass = in_array($paymentStatusKey, ['success', 'completed']) ? 'crancy-table__status--paid' : 'crancy-table__status--delete';
                                                @endphp
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2 crancy-table__cell-ltr">
                                                        #{{ $booking->booking_code ?? 'N/A' }}</td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ Str::limit($booking?->service?->title ?? 'N/A', 30) }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $booking?->user?->name ?? $booking->customer_name ?? dashboard_label('Guest') }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ currency($booking->total) }}
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span class="crancy-badge {{ $paymentStatusClass }}">{{ $paymentStatusLabel }}</span>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <span
                                                            class="crancy-badge crancy-table__status--paid">{{ $bookingStatusLabel }}</span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($user->canAccessStaffRoute('staff.tourbooking.bookings.show'))
                                                            <a href="{{ route('staff.tourbooking.bookings.show', $booking) }}"
                                                                class="crancy-action__btn crancy-action__edit crancy-btn"><i
                                                                    class="fas fa-eye"></i>
                                                                {{ dashboard_label('Details') }}
                                                            </a>
                                                        @endif
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

        let purchase_data = JSON.parse(@json($chartData));
        let date_lable = JSON.parse(@json($chartLabels));

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
                    label: @json(dashboard_label('Sells')),
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
                        text: @json(dashboard_label('Purchase History'))
                    }
                }
            }
        });
    </script>
@endpush
