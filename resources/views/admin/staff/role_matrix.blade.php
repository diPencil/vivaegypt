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
                                    <h4 class="crancy-product-card__title mb-0">{{ $title }}</h4>
                                    <a href="{{ $backRoute }}" class="crancy-btn crancy-btn--white">{{ __('translate.Back') }}</a>
                                </div>

                                <form action="{{ $submitRoute }}" method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('translate.Permission') }}</th>
                                                    @foreach ($roleLabels as $role => $label)
                                                        <th>{{ $label }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($permissionGroups as $permissionKey => $definition)
                                                    <tr>
                                                        <td>
                                                            <div class="fw-semibold">{{ __('translate.' . $definition['label']) }}</div>
                                                            <small class="text-muted">{{ $permissionKey }}</small>
                                                        </td>
                                                        @foreach ($roleLabels as $role => $label)
                                                            <td>
                                                                <input type="checkbox" name="permissions[{{ $role }}][]" value="{{ $permissionKey }}" {{ in_array($permissionKey, $selectedPermissions[$role] ?? [], true) ? 'checked' : '' }}>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4 d-flex gap-2">
                                        <button type="submit" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2">{{ __('translate.Save Data') }}</button>
                                        <a href="{{ route('admin.staff-list') }}" class="crancy-btn crancy-btn--white">{{ __('translate.Close') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection