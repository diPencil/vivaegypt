@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.Transfer Request Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Transfer Request Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.Transfer Request Details') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Transfer Request Info') }} ({{ $transfer_request->request_reference }})</h4>
                        <div class="row mg-top-20">
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Transfer Type') }}:</strong> {{ ucfirst($transfer_request->transfer_type) }}</p>
                                <p><strong>{{ __('translate.Pickup') }}:</strong> {{ $transfer_request->pickup_location }}</p>
                                <p><strong>{{ __('translate.Dropoff') }}:</strong> {{ $transfer_request->dropoff_location }}</p>
                                <p><strong>{{ __('translate.Date & Time') }}:</strong> {{ $transfer_request->pickup_date }} {{ $transfer_request->pickup_time }}</p>
                                <p><strong>{{ __('translate.Vehicle') }}:</strong> {{ ucfirst($transfer_request->vehicle_type) }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Passengers') }}:</strong> {{ $transfer_request->passengers_count }}</p>
                                <p><strong>{{ __('translate.Customer') }}:</strong> {{ $transfer_request->full_name }}</p>
                                <p><strong>{{ __('translate.Email') }}:</strong> {{ $transfer_request->email }}</p>
                                <p><strong>{{ __('translate.Phone') }}:</strong> {{ $transfer_request->phone }}</p>
                            </div>
                            <div class="col-12 mt-3">
                                <p><strong>{{ __('translate.Additional Notes') }}:</strong></p>
                                <div class="p-3 bg-light rounded">{{ $transfer_request->notes ?? __('translate.None') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Admin Management') }}</h4>
                        <form action="{{ dashboard_route('admin.special-booking.transfer-requests.update', $transfer_request->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                <select class="crancy__item-input" name="status">
                                    @foreach(['pending', 'contacted', 'confirmed', 'cancelled', 'completed'] as $status)
                                        <option value="{{ $status }}" {{ $transfer_request->status == $status ? 'selected' : '' }}>{{ __("translate." . ucfirst($status)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Quoted Price') }}</label>
                                <input class="crancy__item-input" type="number" step="0.01" name="quoted_price" value="{{ $transfer_request->quoted_price }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Payment Status') }}</label>
                                <input class="crancy__item-input" type="text" name="payment_status" value="{{ $transfer_request->payment_status }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Admin Notes') }}</label>
                                <textarea class="crancy__item-input" name="admin_notes" rows="4">{{ $transfer_request->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="crancy-btn mt-3 w-100">{{ __('translate.Update Request') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
