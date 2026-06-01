@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">{{ __('translate.Team & Users') }} >> {{ $title }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex align-items-start justify-between create_new_btn_box mb-3 flex-wrap gap-3">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title mb-0">{{ $title }}</h4>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-nowrap">
                                            <label for="staff-length" class="mb-0 fw-medium text-nowrap">Show</label>
                                            <select id="staff-length" class="form-select" style="min-width: 84px; min-height: 48px;">
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <span class="text-nowrap">entries</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3 flex-wrap ms-auto" id="staff-toolbar">
                                        <div class="d-flex align-items-center gap-2 flex-nowrap">
                                            <label for="staff-search" class="mb-0 fw-medium text-nowrap">Search:</label>
                                            <input id="staff-search" type="search" class="form-control" style="min-width: 300px; min-height: 48px;">
                                        </div>
                                        <a href="{{ route('admin.staff-create') }}" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2 text-nowrap" style="min-width: 150px; display: inline-flex; align-items: center; justify-content: center;">
                                            {{ __('translate.Add Staff') }}
                                        </a>
                                    </div>
                                </div>

                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Serial') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Name') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Email') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Role') }}</th>
                                                <th class="crancy-table__column-2 crancy-table__h2 sorting">{{ __('translate.Status') }}</th>
                                                        <th class="crancy-table__column-3 crancy-table__h3 sorting text-end">{{ __('translate.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @forelse ($staffMembers as $index => $staff)
                                                <tr class="odd">
                                                    <td class="crancy-table__column-2 crancy-table__data-2"><h4 class="crancy-table__product-title">{{ ++$index }}</h4></td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2"><h4 class="crancy-table__product-title">{{ html_decode($staff->name) }}</h4></td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2"><h4 class="crancy-table__product-title">{{ html_decode($staff->email) }}</h4></td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2"><h4 class="crancy-table__product-title">{{ $staff->roleDisplayLabel() }}</h4></td>
                                                    <td class="crancy-table__column-2 crancy-table__data-2"><h4 class="crancy-table__product-title">{{ $staff->status == 'enable' ? __('translate.Active') : __('translate.Inactive') }}</h4></td>
                                                    <td class="crancy-table__column-3 crancy-table__data-2 text-end">
                                                        <div class="d-inline-flex justify-content-end gap-2 w-100">
                                                            <a href="{{ route('admin.staff-show', $staff->id) }}" class="crancy-btn" title="{{ __('translate.Show') }}" aria-label="{{ __('translate.Show') }}"><i class="fas fa-eye"></i></a>
                                                            <a href="{{ route('admin.staff-edit', $staff->id) }}" class="crancy-btn" title="{{ __('translate.Edit') }}" aria-label="{{ __('translate.Edit') }}"><i class="fas fa-pen"></i></a>
                                                            <a onclick="itemDeleteConfrimation({{ $staff->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="crancy-btn delete_danger_btn"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5">{{ __('translate.No staff members found') }}</td>
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
@endsection

@push('js_section')
    <script>
        "use strict"

        $(document).ready(function() {
            var table = $('#dataTable').DataTable();

            $('.dataTables_length, .dataTables_filter').remove();

            $('#staff-length').val(table.page.len());

            $('#staff-length').on('change', function() {
                table.page.len($(this).val()).draw();
            });

            $('#staff-search').on('input', function() {
                table.search($(this).val()).draw();
            });
        });
    </script>
@endpush

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('translate.Are you realy want to delete this item?') }}</p>
            </div>
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

@push('js_section')
    <script>
        function itemDeleteConfrimation(id) {
            $("#item_delect_confirmation").attr("action", '{{ url("admin/staff-delete/") }}' + "/" + id)
        }
    </script>
@endpush