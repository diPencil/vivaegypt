@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Nile Cruise Request Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Nile Cruise Request Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Nile Cruise Request Details') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Nile Cruise Request Info') }} ({{ $nile_cruise_request->request_reference }})</h4>
                        <div class="row mg-top-20">
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Route') }}:</strong> {{ $nile_cruise_request->route }}</p>
                                <p><strong>{{ __('translate.Duration') }}:</strong> {{ $nile_cruise_request->nights_count }} {{ __('translate.Nights') }}</p>
                                <p><strong>{{ __('translate.Check-in') }}:</strong> {{ $nile_cruise_request->checkin_date }}</p>
                                <p><strong>{{ __('translate.Cabin Type') }}:</strong> {{ ucfirst($nile_cruise_request->cabin_type) }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Passengers') }}:</strong> {{ $nile_cruise_request->adults }} Adults, {{ $nile_cruise_request->children }} Children</p>
                                <p><strong>{{ __('translate.Customer') }}:</strong> {{ $nile_cruise_request->full_name }}</p>
                                <p><strong>{{ __('translate.Email') }}:</strong> {{ $nile_cruise_request->email }}</p>
                                <p><strong>{{ __('translate.Phone') }}:</strong> {{ $nile_cruise_request->phone }}</p>
                            </div>
                            <div class="col-12 mt-3">
                                <p><strong>{{ __('translate.Additional Notes') }}:</strong></p>
                                <div class="p-3 bg-light rounded">{{ $nile_cruise_request->notes ?? __('translate.None') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Admin Management') }}</h4>
                        <form action="{{ dashboard_route('admin.special-booking.nile-cruise-requests.update', $nile_cruise_request->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                <select class="crancy__item-input" name="status">
                                    @foreach(['pending', 'contacted', 'confirmed', 'cancelled', 'completed'] as $status)
                                        <option value="{{ $status }}" {{ $nile_cruise_request->status == $status ? 'selected' : '' }}>{{ __("translate." . ucfirst($status)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Quoted Price') }}</label>
                                <input class="crancy__item-input" type="number" step="0.01" name="quoted_price" value="{{ $nile_cruise_request->quoted_price }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Payment Status') }}</label>
                                <input class="crancy__item-input" type="text" name="payment_status" value="{{ $nile_cruise_request->payment_status }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Admin Notes') }}</label>
                                <textarea class="crancy__item-input" name="admin_notes" rows="4">{{ $nile_cruise_request->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="crancy-btn mt-3 w-100">{{ __('translate.Update Request') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
