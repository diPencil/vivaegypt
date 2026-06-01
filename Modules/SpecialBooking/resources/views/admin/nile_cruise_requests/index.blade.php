@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Nile Cruise Request List') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Nile Cruise Request List') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Nile Cruise Request List') }}</p>
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
                                        <h4 class="crancy-product-card__title">{{ __('translate.Nile Cruise Request List') }}</h4>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Reference') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Customer') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Route') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Check-in') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach ($requests as $request)
                                                <tr>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $request->request_reference }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $request->user ? $request->user->name : $request->full_name }}
                                                        <br><small>{{ $request->email }}</small>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $request->route }}
                                                        <br><small>{{ $request->nights_count }} {{ __('translate.Nights') }}</small>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $request->checkin_date }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @php($badge = [
                                                            'pending' => 'crancy-badge-warning',
                                                            'contacted' => 'crancy-badge-info',
                                                            'confirmed' => 'crancy-badge-success',
                                                            'cancelled' => 'crancy-badge-danger',
                                                            'completed' => 'crancy-badge-primary',
                                                        ])
                                                        <span class="crancy-badge {{ $badge[$request->status] ?? 'crancy-badge-secondary' }}">
                                                            {{ __("translate." . ucfirst($request->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ dashboard_route('admin.special-booking.nile-cruise-requests.show', $request->id) }}"
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
