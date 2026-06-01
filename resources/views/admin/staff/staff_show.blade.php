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
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                    <h4 class="crancy-product-card__title mb-0">{{ $staff->name }}</h4>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <form action="{{ route('admin.staff-login-as', $staff->id) }}" method="POST" target="_blank" class="m-0">
                                            @csrf
                                            <button type="submit" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2">Login as Staff</button>
                                        </form>
                                        <a href="{{ route('admin.staff-edit', $staff->id) }}" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2">{{ __('translate.Edit') }}</a>
                                        <a onclick="itemDeleteConfrimation({{ $staff->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="crancy-btn delete_danger_btn">{{ __('translate.Delete') }}</a>
                                        <a href="{{ route('admin.staff-list') }}" class="crancy-btn crancy-btn--white">{{ __('translate.Back') }}</a>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded-3 bg-white">
                                            <div class="mb-2 text-muted">{{ __('translate.Name') }}</div>
                                            <div class="fw-semibold">{{ $staff->name }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded-3 bg-white">
                                            <div class="mb-2 text-muted">{{ __('translate.Email') }}</div>
                                            <div class="fw-semibold">{{ $staff->email }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded-3 bg-white">
                                            <div class="mb-2 text-muted">{{ __('translate.Role') }}</div>
                                            <div class="fw-semibold">{{ $staff->roleDisplayLabel() }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded-3 bg-white">
                                            <div class="mb-2 text-muted">{{ __('translate.Status') }}</div>
                                            <div class="fw-semibold">{{ $staff->status == 'enable' ? __('translate.Active') : __('translate.Inactive') }}</div>
                                        </div>
                                    </div>
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
@endsection

@push('js_section')
    <script>
        function itemDeleteConfrimation(id) {
            $("#item_delect_confirmation").attr("action", '{{ url("admin/staff-delete/") }}' + "/" + id)
        }
    </script>
@endpush