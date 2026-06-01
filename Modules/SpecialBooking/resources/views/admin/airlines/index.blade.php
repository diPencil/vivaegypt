@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Airlines') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Airlines') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Airlines') }}</p>
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
                                        <h4 class="crancy-product-card__title">{{ __('translate.Airlines') }}</h4>
                                        <a href="{{ dashboard_route('admin.special-booking.airlines.create') }}" class="crancy-btn"><i class="fa fa-plus"></i> {{ __('translate.Add Airline') }}</a>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class="dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Airline Logo') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Name') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Short Description') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Sort Order') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">{{ __('translate.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @foreach($airlines as $airline)
                                                <tr>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if($logoUrl = special_booking_image_url($airline->logo))
                                                            <img src="{{ $logoUrl }}" alt="{{ $airline->name }}" width="80" class="rounded">
                                                        @else
                                                            <div class="d-inline-flex align-items-center justify-content-center rounded bg-light border text-muted" style="width: 80px; height: 50px;">
                                                                <span class="small">{{ __('translate.No image') }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $airline->name }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $airline->short_description }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">{{ $airline->sort_order }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ dashboard_route('admin.special-booking.airlines.update-status', $airline->id) }}">
                                                            @if($airline->status)
                                                                <span class="crancy-badge crancy-badge-success">{{ __('translate.Active') }}</span>
                                                            @else
                                                                <span class="crancy-badge crancy-badge-danger">{{ __('translate.Inactive') }}</span>
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <a href="{{ dashboard_route('admin.special-booking.airlines.edit', $airline->id) }}" class="crancy-action__btn crancy-action__edit crancy-btn"><i class="fa fa-edit"></i> {{ __('translate.Edit') }}</a>
                                                        <a onclick="itemDeleteConfrimation({{ $airline->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="crancy-btn delete_danger_btn"><i class="fas fa-trash"></i></a>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"><p>{{ __('translate.Are you realy want to delete this item?') }}</p></div>
                <div class="modal-footer">
                    <form action="" id="item_delect_confirmation" class="delet_modal_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
    <script>
        function itemDeleteConfrimation(id) {
            $("#item_delect_confirmation").attr("action", '{{ url("admin/special-booking/airlines") }}' + "/" + id)
        }
    </script>
@endpush