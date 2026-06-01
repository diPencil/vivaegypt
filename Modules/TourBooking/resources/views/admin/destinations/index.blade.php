@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Destinations') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Destinations') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Tour Booking') }} >> {{ __('translate.Destinations') }}</p>
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
                                    <div
                                        class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                        <h4 class="crancy-product-card__title">{{ __('translate.All Destinations') }}</h4>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ dashboard_route('admin.tourbooking.destinations.create') }}"
                                                class="crancy-btn"><i class="fa fa-plus"></i>
                                                {{ __('translate.Add New Destination') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class=" dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3  no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.ID') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Image') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Name') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Country') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Status') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Featured') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Created At') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @forelse($destinations as $destination)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $destination->id }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($destination->image)
                                                            <img src="{{ asset($destination->image) }}"
                                                                alt="{{ $destination->name }}" class="img-thumbnail"
                                                                width="50">
                                                        @else
                                                            <span class="badge badge-secondary">{{ __('translate.No Image') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $destination->name }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $destination->country }}</td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($destination->status)
                                                            <span class="badge badge-success">{{ __('translate.Active') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('translate.Inactive') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($destination->is_featured)
                                                            <span class="badge badge-info">{{ __('translate.Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ __('translate.No') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        {{ $destination->created_at->locale(app()->getLocale())->isoFormat('D MMM YYYY') }}
                                                    </td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <label class="crancy__item-switch" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ __('translate.Toggle destination status') }}">
                                                            <input onClick="manageStatus({{ $destination->id }})"
                                                                name="status" type="checkbox"
                                                                {{ $destination->status == 1 ? 'checked' : '' }}>
                                                            <span
                                                                class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                        </label>

                                                        <label class="crancy__item-switch" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ __('translate.Toggle destination featured') }}">
                                                            <input onClick="manage{{ __('translate.Featured') }}({{ $destination->id }})"
                                                                name="featured" type="checkbox"
                                                                {{ $destination->is_featured == 1 ? 'checked' : '' }}>
                                                            <span
                                                                class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                        </label>
                                                        <a href="{{ dashboard_route('admin.tourbooking.destinations.edit', ['destination' => $destination, 'lang_code' => admin_lang()]) }}"
                                                            class="crancy-action__btn crancy-action__edit crancy-btn">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ dashboard_route('admin.tourbooking.destinations.show', [$destination]) }}"
                                                            class="crancy-action__btn crancy-action__edit crancy-btn d-none">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a onclick="itemDeleteConfrimation({{ $destination->id }})"
                                                            href="javascript:;" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"
                                                            class="destination crancy-btn crancy-action__btn crancy-action__edit crancy-btn delete_danger_btn"><i
                                                                class="fas fa-trash"></i> {{ __('translate.Delete') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">{{ __('translate.No destinations found') }}</td>
                                                </tr>
                                            @endforelse
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('translate.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to delete this item?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="item_delect_confirmation" class="delet_modal_form" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Delete') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
@endpush


@push('js_section')
    <script>
        "use strict"

        function itemDeleteConfrimation(id) {
            $("#item_delect_confirmation").attr("action", '{{ dashboard_url('admin/tourbooking/destinations') }}' + "/" + id)
        }

        function manageStatus(id) {
            var appMODE = "{{ env('APP_MODE') }}"
            if (appMODE == 'DEMO') {
                toastr.error(@json(__('translate.This Is Demo Version. You Can Not Change Anything')));
                return;
            }

            $.ajax({
                type: "PUT",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ dashboard_route('admin.tourbooking.destinations.update-status', ['destination' => ':id']) }}".replace(':id', id),
                success: function(response) {
                    toastr.success(response.message)
                },
                error: function(err) {
                    console.log(err);
                    toastr.error(@json(__('translate.An error occurred while updating status')));
                }
            })
        }

        function manage{{ __('translate.Featured') }}(id) {
            var appMODE = "{{ env('APP_MODE') }}"
            if (appMODE == 'DEMO') {
                toastr.error(@json(__('translate.This Is Demo Version. You Can Not Change Anything')));
                return;
            }

            $.ajax({
                type: "PUT",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ dashboard_route('admin.tourbooking.destinations.update-featured', ['destination' => ':id']) }}".replace(':id', id),
                success: function(response) {
                    toastr.success(response.message)
                },
                error: function(err) {
                    console.log(err);
                    toastr.error(@json(__('translate.An error occurred while updating featured')));
                }
            })
        }
    </script>
@endpush
