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
                            <div class="crancy-form mg-top-30">
                                <form action="{{ route('admin.staff-store') }}" method="POST">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <label class="form-label">{{ __('translate.Name') }}</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">{{ __('translate.Email') }}</label>
                                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">{{ __('translate.Username') }}</label>
                                            <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
                                            @error('username')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">{{ __('translate.Role') }}</label>
                                            <select name="type" class="form-select" required>
                                                <option value="data-entry" {{ old('type', 'data-entry') === 'data-entry' ? 'selected' : '' }}>{{ __('translate.Data Entry') }}</option>
                                                <option value="accountant" {{ old('type') === 'accountant' ? 'selected' : '' }}>{{ __('translate.Accountant') }}</option>
                                                <option value="travel-agent" {{ old('type') === 'travel-agent' ? 'selected' : '' }}>{{ __('translate.Travel Agent') }}</option>
                                                <option value="sales-agent" {{ old('type') === 'sales-agent' ? 'selected' : '' }}>{{ __('translate.Sales Agent') }}</option>
                                                <option value="booking-agent" {{ old('type') === 'booking-agent' ? 'selected' : '' }}>{{ __('translate.Booking Agent') }}</option>
                                            </select>
                                            @error('type')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">{{ __('translate.Password') }}</label>
                                            <input type="password" name="password" class="form-control" required>
                                            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                                                <span class="form-check-label">{{ __('translate.Active') }}</span>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2">{{ __('translate.Save Data') }}</button>
                                            <a href="{{ route('admin.staff-list') }}" class="crancy-btn crancy-btn--white">{{ __('translate.Close') }}</a>
                                        </div>
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