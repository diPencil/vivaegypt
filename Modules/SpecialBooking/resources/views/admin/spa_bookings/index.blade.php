@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.SPA Booking List') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.SPA Booking List') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.SPA Booking List') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter">
                                    <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                        <h4 class="crancy-product-card__title">{{ __('translate.SPA Booking List') }}</h4>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Reference') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Customer') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Service') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Date & Time') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($bookings as $booking)
                                                <tr>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $booking->booking_reference }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $booking->user ? $booking->user->name : $booking->full_name }}
                                                        <br><small>{{ $booking->email }}</small>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $booking->spaService->title ?? 'N/A' }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $booking->preferred_date }}
                                                        <br><small>{{ $booking->preferred_time }}</small>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @php($badge = [
                                                            'pending' => 'crancy-badge-warning',
                                                            'contacted' => 'crancy-badge-info',
                                                            'confirmed' => 'crancy-badge-success',
                                                            'cancelled' => 'crancy-badge-danger',
                                                            'completed' => 'crancy-badge-primary',
                                                        ])
                                                        <span class="crancy-badge {{ $badge[$booking->status] ?? 'crancy-badge-secondary' }}">
                                                            {{ __("translate." . ucfirst($booking->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ dashboard_route('admin.special-booking.spa-bookings.show', $booking->id) }}"
                                                            class="crancy-action__btn crancy-action__edit crancy-btn"><i
                                                                class="fa fa-eye"></i> {{ __('translate.View') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
