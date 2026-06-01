@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Flight Request Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Flight Request Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Flight Request Details') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Flight Request Info') }} ({{ $flight_request->request_reference }})</h4>
                        <div class="row mg-top-20">
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Trip Type') }}:</strong> {{ ucfirst($flight_request->trip_type) }}</p>
                                <p><strong>{{ __('translate.Route') }}:</strong> {{ $flight_request->from_city }} -> {{ $flight_request->to_city }}</p>
                                <p><strong>{{ __('translate.Departure Date') }}:</strong> {{ $flight_request->departure_date }}</p>
                                @if($flight_request->return_date)
                                    <p><strong>{{ __('translate.Return Date') }}:</strong> {{ $flight_request->return_date }}</p>
                                @endif
                                <p><strong>{{ __('translate.Class') }}:</strong> {{ ucfirst($flight_request->travel_class) }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Passengers') }}:</strong> {{ $flight_request->adults }} Adults, {{ $flight_request->children }} Children, {{ $flight_request->infants }} Infants</p>
                                <p><strong>{{ __('translate.Customer') }}:</strong> {{ $flight_request->full_name }}</p>
                                <p><strong>{{ __('translate.Email') }}:</strong> {{ $flight_request->email }}</p>
                                <p><strong>{{ __('translate.Phone') }}:</strong> {{ $flight_request->phone }}</p>
                            </div>
                            <div class="col-12 mt-3">
                                <p><strong>{{ __('translate.Additional Notes') }}:</strong></p>
                                <div class="p-3 bg-light rounded">{{ $flight_request->notes ?? __('translate.None') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Admin Management') }}</h4>
                        <form action="{{ dashboard_route('admin.special-booking.flight-requests.update', $flight_request->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                <select class="crancy__item-input" name="status">
                                    @foreach(['pending', 'contacted', 'confirmed', 'cancelled', 'completed'] as $status)
                                        <option value="{{ $status }}" {{ $flight_request->status == $status ? 'selected' : '' }}>{{ __("translate." . ucfirst($status)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Quoted Price') }}</label>
                                <input class="crancy__item-input" type="number" step="0.01" name="quoted_price" value="{{ $flight_request->quoted_price }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Payment Status') }}</label>
                                <input class="crancy__item-input" type="text" name="payment_status" value="{{ $flight_request->payment_status }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Admin Notes') }}</label>
                                <textarea class="crancy__item-input" name="admin_notes" rows="4">{{ $flight_request->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="crancy-btn mt-3 w-100">{{ __('translate.Update Request') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
