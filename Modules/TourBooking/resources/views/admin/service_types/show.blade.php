@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Service Type Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Service Type Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Tour Booking') }} >> {{ __('translate.Service Type Details') }}</p>
@endsection

@section('body-content')
    @php
        $serviceList = $services ?? $serviceType->services;
    @endphp
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="row">
                                <div class="col-12 mg-top-30">
                                    <div class="crancy-product-card">
                                        <div class="create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">
                                                {{ __('translate.Service Type Details') }}</h4>
                                            <div>
                                                <a href="{{ dashboard_route('admin.tourbooking.service-types.edit', [$serviceType->id]) }}"
                                                    class="crancy-btn crancy-btn__primary me-2">
                                                    <i class="fa fa-edit"></i> {{ __('translate.Edit') }}
                                                </a>
                                                <a href="{{ dashboard_route('admin.tourbooking.service-types.index') }}"
                                                    class="crancy-btn">
                                                    <i class="fa fa-list"></i> {{ __('translate.Back to List') }}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row mg-top-25">
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        @php
                                                            $serviceTypeName = $serviceType->localized_name;
                                                        @endphp
                                                        @if ($serviceType->image)
                                                            <img src="{{ asset($serviceType->image) }}"
                                                                alt="{{ $serviceTypeName }}"
                                                                class="img-fluid mb-3" style="max-height: 150px;">
                                                        @elseif($serviceType->icon)
                                                            <i class="{{ $serviceType->icon }}"
                                                                style="font-size: 80px; margin-bottom: 20px;"></i>
                                                        @else
                                                            <i class="fa fa-cubes"
                                                                style="font-size: 80px; margin-bottom: 20px;"></i>
                                                        @endif

                                                        <h5 class="card-title">
                                                            {{ $serviceTypeName }}
                                                        </h5>
                                                        <p class="text-muted"><small>{{ $serviceType->slug }}</small></p>

                                                        <div class="mt-3">
                                                            @if ($serviceType->status)
                                                                <span
                                                                    class="crancy-badge crancy-badge-success">{{ __('translate.Active') }}</span>
                                                            @else
                                                                <span
                                                                    class="crancy-badge crancy-badge-danger">{{ __('translate.Inactive') }}</span>
                                                            @endif

                                                            @if ($serviceType->is_featured)
                                                                <span
                                                                    class="crancy-badge crancy-badge-primary">{{ __('translate.Featured') }}</span>
                                                            @endif

                                                            @if ($serviceType->show_on_homepage)
                                                                <span
                                                                    class="crancy-badge crancy-badge-info">{{ __('translate.Homepage') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($serviceType->description)
                                                    <div class="card mt-4">
                                                        <div class="card-header">
                                                            <h5 class="mb-0">{{ __('translate.Description') }}</h5>
                                                        </div>
                                                        <div class="card-body">
                                                                    <div>
                                                                        {!! clean(html_decode($serviceType->translation->description ?? $serviceType->description)) !!}
                                                                    </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                                            <h5 class="mb-0">{{ __('translate.Services in this Category') }}
                                                                ({{ $serviceList->count() }})</h5>
                                                            <form method="GET" action="{{ url()->current() }}"
                                                                class="d-flex align-items-center gap-2">
                                                                <select name="status" class="form-select">
                                                                    <option value="manageable" @selected(($statusFilter ?? 'manageable') === 'manageable')>
                                                                        {{ __('translate.All Manageable') }}
                                                                    </option>
                                                                    <option value="active" @selected(($statusFilter ?? 'all') === 'active')>
                                                                        {{ __('translate.Active') }}
                                                                    </option>
                                                                    <option value="inactive_drafts" @selected(($statusFilter ?? 'all') === 'inactive_drafts')>
                                                                        {{ __('translate.Inactive Drafts') }}
                                                                    </option>
                                                                    <option value="archived" @selected(($statusFilter ?? 'all') === 'archived')>
                                                                        {{ __('translate.Archived / Booking History') }}
                                                                    </option>
                                                                </select>
                                                                <button type="submit" class="crancy-btn">
                                                                    {{ __('translate.Filter') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        @if ($serviceList->count() > 0)
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>{{ __('translate.Image') }}</th>
                                                                            <th>{{ __('translate.Title') }}</th>
                                                                            <th>{{ __('translate.Price') }}</th>
                                                                            <th>{{ __('translate.Status') }}</th>
                                                                            <th>{{ __('translate.Action') }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($serviceList as $service)
                                                                            <tr>
                                                                                <td>
                                                                                    @if ($service->thumbnail && $service->thumbnail->file_path)
                                                                                        <img src="{{ asset($service->thumbnail->file_path) }}"
                                                                                            alt="{{ $service->translation->title ?? $service->title }}"
                                                                                            width="50">
                                                                                    @else
                                                                                        <img src="{{ asset('admin/img/img-placeholder.jpg') }}"
                                                                                            alt="No image" width="50">
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $service->translation->title ?? $service->title }}
                                                                                </td>
                                                                                <td>

                                                                                    @if ($service->is_per_person)
                                                                                        @if ($service->price_per_person)
                                                                                            {{ currency($service->price_per_person) }}
                                                                                            ({{ __('translate.Per Person') }})
                                                                                            <br>
                                                                                        @endif

                                                                                        @if ($service->child_price)
                                                                                            {{ currency($service->child_price) }}
                                                                                            ({{ __('translate.Children Price') }})
                                                                                        @endif
                                                                                    @else
                                                                                        @if ($service->price_display)
                                                                                            {!! $service->price_display !!}
                                                                                            ({{ __('translate.Full Price') }})
                                                                                        @else
                                                                                            {{ __('translate.N/A') }}
                                                                                        @endif
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if ($service->status)
                                                                                        <span
                                                                                            class="crancy-badge crancy-badge-success">{{ __('translate.Active') }}</span>
                                                                                    @else
                                                                                        <span
                                                                                            class="crancy-badge crancy-badge-danger">{{ __('translate.Inactive') }}</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td
                                                                                    class="text-center d-flex justify-content-center gap-2">
                                                                                    <a href="{{ dashboard_route('admin.tourbooking.services.edit', [$service->id]) }}"
                                                                                        class="crancy-btn crancy-btn__primary crancy-btn__sm">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </a>
                                                                                    <a href="{{ dashboard_route('admin.tourbooking.services.show', [$service->id]) }}"
                                                                                        class="crancy-btn crancy-btn__info crancy-btn__sm">
                                                                                        <i class="fa fa-eye"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-info">
                                                                {{ __('translate.No services found in this category') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
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
@endsection
