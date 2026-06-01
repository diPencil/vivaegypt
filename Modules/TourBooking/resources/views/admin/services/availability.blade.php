@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Service Availability') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Service Availability Management') }}</h3>
    <p class="crancy-header__text">
        {{ __('translate.Manage Availability') }} >> {{ $service->title }}
    </p>
@endsection

@push('style_section')
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .availability-calendar {
            margin-top: 20px;
        }

        .fc-day-grid-event {
            cursor: pointer;
        }

        .availability-legend {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border-radius: 3px;
        }

        .legend-available {
            background-color: #4caf50;
        }

        .legend-unavailable {
            background-color: #f44336;
        }

        .legend-limited {
            background-color: #ff9800;
        }

        .date-range-select {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

        .date-range-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .date-picker-container {
            margin-bottom: 15px;
        }

        .availability-actions {
            margin-top: 10px;
        }

        .selected-dates {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f7ff;
            border: 1px dashed #c0d6f9;
            border-radius: 5px;
            display: none;
        }

        #selectedDatesCount {
            font-weight: 600;
            color: #2563eb;
        }

        .flatpickr-day.selected.available {
            background-color: #4caf50;
        }

        .flatpickr-day.selected.unavailable {
            background-color: #f44336;
        }

        .modal-lg {
            max-width: 800px;
        }
        .availability-flex {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Edit Availability: keep footer visible; scroll body on small viewports */
        #editAvailabilityModal .modal-dialog {
            max-width: min(32rem, calc(100vw - 1.5rem));
            margin: 0.75rem auto;
        }

        #editAvailabilityModal .modal-body {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        #editAvailabilityModal .edit-availability-field {
            margin-bottom: 0.65rem;
        }

        #editAvailabilityModal .edit-availability-field label {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        #editAvailabilityModal details.edit-availability-hint {
            margin-bottom: 0.5rem;
        }

        #editAvailabilityModal details.edit-availability-hint summary {
            cursor: pointer;
            list-style-position: outside;
        }

        #editAvailabilityModal details.edit-availability-hint summary::-webkit-details-marker {
            display: none;
        }

        /* Native time picker: match Crancy input height */
        input[type="time"].crancy__item-input {
            min-height: 50px;
            padding-right: 12px !important;
        }

        /* Flatpickr (date only) inside modals */
        .modal .flatpickr-calendar {
            z-index: 2000 !important;
        }
    </style>
@endpush

@section('body-content')
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
                                                {{ __('translate.Service Availability') }}</h4>
                                            <div>
                                                <a href="{{ dashboard_route('admin.tourbooking.services.edit', [$service]) }}"
                                                    class="crancy-btn"><i class="fa fa-edit"></i>
                                                    {{ __('translate.Edit Service') }}</a>
                                                <a href="{{ dashboard_route('admin.tourbooking.services.index') }}"
                                                    class="crancy-btn"><i class="fa fa-list"></i>
                                                    {{ __('translate.Service List') }}</a>
                                            </div>
                                        </div>

                                        <div class="row mg-top-30">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="availability-legend">
                                                            <div class="legend-item">
                                                                <div class="legend-color legend-available"></div>
                                                                <span>{{ __('translate.Available') }}</span>
                                                            </div>
                                                            <div class="legend-item">
                                                                <div class="legend-color legend-unavailable"></div>
                                                                <span>{{ __('translate.Unavailable') }}</span>
                                                            </div>
                                                            <div class="legend-item">
                                                                <div class="legend-color legend-limited"></div>
                                                                <span>{{ __('translate.Limited Spots') }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Date Range Selection -->
                                                        <div class="date-range-select">
                                                            <h5 class="date-range-title">
                                                                {{ __('translate.Bulk Date Selection') }}</h5>
                                                                    <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="date-picker-container">
                                                                        <label>{{ __('translate.Start Date') }}</label>
                                                                        <input type="text" id="startDate" 
                                                                            class="crancy__item-input" 
                                                                            placeholder="{{ __('translate.Select start date') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="date-picker-container">
                                                                        <label>{{ __('translate.End Date') }}</label>
                                                                        <input type="text" id="endDate" 
                                                                            class="crancy__item-input" 
                                                                            placeholder="{{ __('translate.Select end date') }}">
                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Days of Week') }}</label>
                                                                        <div class="mt-2">
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-sun" value="0" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-sun">{{ __('translate.Sun') }}</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-mon" value="1" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-mon">{{ __('translate.Mon') }}</label>
                                                                        </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-tue" value="2" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-tue">{{ __('translate.Tue') }}</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-wed" value="3" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-wed">{{ __('translate.Wed') }}</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-thu" value="4" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-thu">{{ __('translate.Thu') }}</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-fri" value="5" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-fri">{{ __('translate.Fri') }}</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="checkbox"
                                                                                    id="day-sat" value="6" checked>
                                                                                <label class="form-check-label"
                                                                                    for="day-sat">{{ __('translate.Sat') }}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                        </div>
                                                                <div class="col-md-6">
                                                                    <div class="availability-actions mt-4">
                                                                        <button id="generateDatesBtn"
                                                                            class="crancy-btn">{{ __('translate.Generate Dates') }}</button>
                                                                        <button id="clearSelectionBtn" class="crancy-btn crancy-btn-danger"
                                                                            style="display: none;">{{ __('translate.Clear Selection') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="selected-dates" id="selectedDatesContainer">
                                                                <p>{{ __('translate.Selected') }}: <span
                                                                        id="selectedDatesCount">0</span> {{ __('translate.dates') }}
                                                                </p>
                                                                <button id="bulkManageBtn" class="crancy-btn"
                                                                    data-bs-toggle="modal" data-bs-target="#bulkManageModal"
                                                                    disabled>{{ __('translate.Manage Selected Dates') }}</button>
                                                            </div>
                                                        </div>

                                                        <!-- Calendar View -->
                                                        <div id="availabilityCalendar" class="availability-calendar"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Existing Availabilities Table -->
                                        <div class="row mg-top-30">
                                            <div class="col-12">
                                                <h5>{{ __('translate.Configured Availabilities') }}</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('translate.Date') }}</th>
                                                                <th>{{ __('translate.Time') }}</th>
                                                                <th>{{ __('translate.Status') }}</th>
                                                                <th>{{ __('translate.Available Spots') }}</th>
                                                                <th>{{ __('translate.Special Price') }}</th>
                                                                <th>{{ __('translate.Notes') }}</th>
                                                                <th>{{ __('translate.Action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($service->availabilities) > 0)
                                                                @foreach($service->availabilities as $availability)
                                                                    <tr>
                                                                        <td>{{ date('d M Y', strtotime($availability->date)) }}</td>
                                                                        <td>
                                                                            @if ($availability->start_time)
                                                                                {{ date('H:i', strtotime($availability->start_time)) }}
                                                                                @if ($availability->end_time)
                                                                                    – {{ date('H:i', strtotime($availability->end_time)) }}
                                                                                @endif
                                                                            @else
                                                                                {{ __('translate.All Day') }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($availability->is_available)
                                                                                <span class="badge bg-success">{{ __('translate.Available') }}</span>
                                                                        @else
                                                                                <span class="badge bg-danger">{{ __('translate.Unavailable') }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                            @if($availability->available_spots !== null)
                                                                            {{ $availability->available_spots }}
                                                                        @else
                                                                                <span class="text-muted">{{ __('translate.Unlimited') }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                            @if($availability->special_price !== null)
                                                                                {{ currency($availability->special_price) }}
                                                                        @else
                                                                                <span class="text-muted">{{ __('translate.Standard') }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                            @if($availability->notes)
                                                                                {{ Str::limit($availability->notes, 30) }}
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="availability-flex">
                                                                            <button type="button" class="btn btn-sm btn-primary edit-availability"
                                                                                data-id="{{ $availability->id }}"
                                                                                data-date="{{ $availability->date instanceof \Carbon\Carbon ? $availability->date->format('Y-m-d') : \Carbon\Carbon::parse($availability->date)->format('Y-m-d') }}"
                                                                                data-start-time="{{ $availability->start_time ? date('H:i', strtotime($availability->start_time)) : '' }}"
                                                                                data-end-time="{{ $availability->end_time ? date('H:i', strtotime($availability->end_time)) : '' }}"
                                                                                data-is-available="{{ $availability->is_available ? '1' : '0' }}"
                                                                                data-available-spots="{{ $availability->available_spots }}"
                                                                                data-special-price="{{ $availability->special_price }}"
                                                                                data-notes="{{ $availability->notes }}"
                                                                                data-bs-toggle="modal" data-bs-target="#editAvailabilityModal">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                            <button type="button" class="btn btn-sm btn-danger delete-availability"
                                                                                data-id="{{ $availability->id }}"
                                                                                data-date="{{ date('d M Y', strtotime($availability->date)) }}">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">{{ __('translate.No availabilities configured') }}</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                                            </div>
                                                                                            </div>
                                                                                        </div>

                                        <!-- Add Single Availability -->
                                        <div class="row mg-top-30">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>{{ __('translate.Add Single Date Availability') }}</h5>
                                                                                            </div>
                                                    <div class="card-body">
                                                        <form action="{{ dashboard_route('admin.tourbooking.services.availability.store', [$service]) }}" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Date') }} *</label>
                                                                        <input type="text" name="date" class="crancy__item-input datepicker"
                                                                            required>
                                                                                            </div>
                                                                                        </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Start Time') }}</label>
                                                                        <input type="time" name="start_time" step="60"
                                                                            class="crancy__item-input"
                                                                            value="{{ old('start_time') }}">
                                                                                            </div>
                                                                                        </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.End Time') }}</label>
                                                                        <input type="time" name="end_time" step="60"
                                                                            class="crancy__item-input"
                                                                            value="{{ old('end_time') }}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="small text-muted mb-0">{{ __('translate.Availability time slot help') }}</p>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Available Spots') }}</label>
                                                                        <input type="number" name="available_spots"
                                                                            class="crancy__item-input" min="1" placeholder="Leave empty for unlimited">
                                                                                            </div>
                                                                                        </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Special Price') }}</label>
                                                                        <input type="number" step="0.01" name="special_price"
                                                                            class="crancy__item-input" placeholder="Leave empty for standard price">
                                                                                                </div>
                                                                                            </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Status') }}</label>
                                                                        <div class="form-check form-switch mt-2">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                name="is_available" id="is_available" value="1" checked>
                                                                            <label class="form-check-label"
                                                                                for="is_available">{{ __('translate.Available') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>{{ __('translate.Notes') }}</label>
                                                                        <textarea name="notes" class="crancy__item-input"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <button type="submit"
                                                                        class="crancy-btn">{{ __('translate.Add Availability') }}</button>
                                                                </div>
                                                            </div>
                                                        </form>
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

    <!-- Edit Availability Modal -->
    <div class="modal fade" id="editAvailabilityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title fs-6 mb-0">{{ __('translate.Edit Availability') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAvailabilityForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group edit-availability-field">
                            <label>{{ __('translate.Date') }}</label>
                            <input type="text" name="date" id="edit_date" class="crancy__item-input" readonly
                                autocomplete="off">
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="form-group edit-availability-field mb-0">
                                    <label>{{ __('translate.Start Time') }}</label>
                                    <input type="time" name="start_time" id="edit_start_time" step="60"
                                        class="crancy__item-input">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group edit-availability-field mb-0">
                                    <label>{{ __('translate.End Time') }}</label>
                                    <input type="time" name="end_time" id="edit_end_time" step="60"
                                        class="crancy__item-input">
                                </div>
                            </div>
                        </div>
                        <details class="edit-availability-hint small text-muted">
                            <summary>{{ __('translate.About time slots') }}</summary>
                            <p class="small text-muted mb-0 mt-2">{{ __('translate.Availability time slot help') }}</p>
                        </details>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="form-group edit-availability-field mb-0">
                                    <label>{{ __('translate.Available Spots') }}</label>
                                    <input type="number" name="available_spots" id="edit_available_spots"
                                        class="crancy__item-input" min="1"
                                        placeholder="Leave empty for unlimited">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group edit-availability-field mb-0">
                                    <label>{{ __('translate.Special Price') }}</label>
                                    <input type="number" step="0.01" name="special_price" id="edit_special_price"
                                        class="crancy__item-input" placeholder="Leave empty for standard price">
                                </div>
                            </div>
                        </div>
                        <div class="form-group edit-availability-field">
                            <label>{{ __('translate.Status') }}</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_available"
                                    id="edit_is_available" value="1">
                                <label class="form-check-label" for="edit_is_available">{{ __('translate.Available') }}</label>
                            </div>
                        </div>
                        <div class="form-group edit-availability-field mb-0">
                            <label>{{ __('translate.Notes') }}</label>
                            <textarea name="notes" id="edit_notes" class="crancy__item-input" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">{{ __('translate.Cancel') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm">{{ __('translate.Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Manage Modal -->
    <div class="modal fade" id="bulkManageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('translate.Bulk Manage Availability') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="bulkManageForm" action="{{ dashboard_route('admin.tourbooking.services.availability.store', [$service]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="bulk" value="1">
                    <input type="hidden" name="dates[]" id="bulk_dates">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <p>{{ __('translate.You are about to configure availability for') }}
                                <strong id="bulkDateCount">0</strong> {{ __('translate.dates') }}.
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.Start Time') }}</label>
                                    <input type="time" name="start_time" id="bulk_start_time" step="60"
                                        class="crancy__item-input">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.End Time') }}</label>
                                    <input type="time" name="end_time" id="bulk_end_time" step="60"
                                        class="crancy__item-input">
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="small text-muted mb-3">{{ __('translate.Availability time slot help') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.Available Spots') }}</label>
                                    <input type="number" name="available_spots" id="bulk_available_spots"
                                        class="crancy__item-input" min="1" placeholder="Leave empty for unlimited">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.Special Price') }}</label>
                                    <input type="number" step="0.01" name="special_price" id="bulk_special_price"
                                        class="crancy__item-input" placeholder="Leave empty for standard price">
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_available"
                                            id="bulk_is_available" value="1" checked>
                                        <label class="form-check-label"
                                            for="bulk_is_available">{{ __('translate.Available') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>{{ __('translate.Notes') }}</label>
                                    <textarea name="notes" id="bulk_notes" class="crancy__item-input" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('translate.Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Apply to All Selected Dates') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAvailabilityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('translate.Delete Availability') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you sure you want to delete availability for') }} <span id="deleteDate"></span>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteAvailabilityForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('translate.Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('translate.Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_section')
    <script src="{{ asset('global/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        (function($) {
            "use strict"
            $(document).ready(function() {

                document.querySelectorAll('.datepicker').forEach(function(el) {
                    flatpickr(el, {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                    });
                });

                // Selected dates array
                let selectedDates = [];

                // Date range selectors
                const startDatePicker = flatpickr("#startDate", {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                });

                const endDatePicker = flatpickr("#endDate", {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                });

                // Generate dates based on selection
                $("#generateDatesBtn").click(function() {
                    const startDate = startDatePicker.selectedDates[0];
                    const endDate = endDatePicker.selectedDates[0];

                    if (!startDate || !endDate) {
                        alert("{{ __('translate.Please select both start and end dates') }}");
                        return;
                    }

                    // Get selected days of week
                    const selectedDays = [];
                    for (let i = 0; i <= 6; i++) {
                        if ($(`#day-${['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'][i]}`).is(':checked')) {
                            selectedDays.push(i);
                        }
                    }

                    if (selectedDays.length === 0) {
                        alert("{{ __('translate.Please select at least one day of week') }}");
                        return;
                    }

                    // Generate dates
                    selectedDates = [];
                    const current = new Date(startDate);
                    while (current <= endDate) {
                        if (selectedDays.includes(current.getDay())) {
                            const dateStr = current.toISOString().split('T')[0];
                            selectedDates.push(dateStr);
                        }
                        current.setDate(current.getDate() + 1);
                    }

                    updateSelectedDatesUI();
                });

                // Clear selection
                $("#clearSelectionBtn").click(function() {
                    selectedDates = [];
                    updateSelectedDatesUI();
                    calendar.unselect();
                });

                // Update UI with selected dates
                function updateSelectedDatesUI() {
                    const count = selectedDates.length;
                    $("#selectedDatesCount").text(count);

                    if (count > 0) {
                        $("#selectedDatesContainer").show();
                        $("#clearSelectionBtn").show();
                        $("#bulkManageBtn").prop("disabled", false);
                        $("#bulkDateCount").text(count);
                        
                        // Clear previous hidden inputs for dates
                        $('input[name="dates[]"]').remove();
                        
                        // Create hidden inputs for each date
                        selectedDates.forEach(function(date) {
                            $('#bulkManageForm').append('<input type="hidden" name="dates[]" value="' + date + '">');
                        });
                    } else {
                        $("#selectedDatesContainer").hide();
                        $("#clearSelectionBtn").hide();
                        $("#bulkManageBtn").prop("disabled", true);
                    }
                }

                // Edit Availability Modal
                $('.edit-availability').click(function() {
                    const id = $(this).data('id');
                    const date = $(this).data('date');
                    const startTime = $(this).data('start-time');
                    const endTime = $(this).data('end-time');
                    const isAvailable = $(this).data('is-available');
                    const availableSpots = $(this).data('available-spots');
                    const specialPrice = $(this).data('special-price');
                    const notes = $(this).data('notes');

                    $('#edit_date').val(date);
                    $('#edit_start_time').val(startTime);
                    $('#edit_end_time').val(endTime);
                    $('#edit_available_spots').val(availableSpots);
                    $('#edit_special_price').val(specialPrice);
                    $('#edit_is_available').prop('checked', isAvailable == 1);
                    $('#edit_notes').val(notes);

                    const url = "{{ dashboard_route('admin.tourbooking.services.availability.update', ['service' => $service->id, 'availability' => ':id']) }}";
                    $('#editAvailabilityForm').attr('action', url.replace(':id', id));
                });

                // Delete Availability
                $('.delete-availability').click(function() {
                    const id = $(this).data('id');
                    const date = $(this).data('date');
                    $('#deleteDate').text(date);

                    const url = "{{ dashboard_route('admin.tourbooking.services.availability.destroy', ['service' => $service->id, 'availability' => ':id']) }}";
                    $('#deleteAvailabilityForm').attr('action', url.replace(':id', id));

                    $('#deleteAvailabilityModal').modal('show');
                });

                // Initialize calendar
                const calendarEl = document.getElementById('availabilityCalendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    },
                    events: [
                        @foreach($service->availabilities as $availability)
                        @php
                            $fcSpot = $availability->is_available
                                ? ($availability->available_spots !== null ? $availability->available_spots . ' spots' : __('translate.Available'))
                                : __('translate.Not Available');
                            $fcTime = '';
                            if ($availability->start_time) {
                                $fcTime = date('H:i', strtotime($availability->start_time));
                                if ($availability->end_time) {
                                    $fcTime .= '–' . date('H:i', strtotime($availability->end_time));
                                }
                                $fcTime .= ' · ';
                            }
                            $fcTitle = $fcTime . $fcSpot;
                        @endphp
                        {
                            title: @json($fcTitle),
                            start: '{{ $availability->date instanceof \Carbon\Carbon ? $availability->date->format('Y-m-d') : \Carbon\Carbon::parse($availability->date)->format('Y-m-d') }}',
                            color: '{{ $availability->is_available ? 
                                ($availability->available_spots !== null && $availability->available_spots > 0 ? "#ff9800" : "#4caf50") : 
                                "#f44336" }}',
                            extendedProps: {
                                availabilityId: {{ $availability->id }},
                                isAvailable: {{ $availability->is_available ? 'true' : 'false' }},
                                availableSpots: {{ $availability->available_spots ?? 'null' }},
                                specialPrice: {{ $availability->special_price ?? 'null' }},
                                notes: '{{ $availability->notes ?? "" }}'
                            }
                        },
                        @endforeach
                    ],
                    eventClick: function(info) {
                        const id = info.event.extendedProps.availabilityId;
                        const url = "{{ dashboard_route('admin.tourbooking.services.availability.update', ['service' => $service->id, 'availability' => ':id']) }}";
                        const editUrl = url.replace(':id', id);
                        
                        // Find the existing edit data in the table
                        const editBtn = $(`.edit-availability[data-id="${id}"]`);
                        if (editBtn.length) {
                            editBtn.trigger('click');
                        }
                    }
                });
                calendar.render();
            });
        })(jQuery);
    </script>
@endpush
