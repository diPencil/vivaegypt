@extends(dashboard_layout())
@section('title')
    <title>{{ __('translate.SPA Booking Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.SPA Booking Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Special Bookings') }} >> {{ __('translate.SPA Booking Details') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Booking Information') }} ({{ $spa_booking->booking_reference }})</h4>
                        <div class="row mg-top-20">
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Service') }}:</strong> {{ $spa_booking->spaService->title ?? 'N/A' }}</p>
                                <p><strong>{{ __('translate.Preferred Date') }}:</strong> {{ $spa_booking->preferred_date }}</p>
                                <p><strong>{{ __('translate.Preferred Time') }}:</strong> {{ $spa_booking->preferred_time }}</p>
                                <p><strong>{{ __('translate.Guests') }}:</strong> {{ $spa_booking->guests_count }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>{{ __('translate.Customer') }}:</strong> {{ $spa_booking->full_name }}</p>
                                <p><strong>{{ __('translate.Email') }}:</strong> {{ $spa_booking->email }}</p>
                                <p><strong>{{ __('translate.Phone') }}:</strong> {{ $spa_booking->phone }}</p>
                                <p><strong>{{ __('translate.Created At') }}:</strong> {{ $spa_booking->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                            <div class="col-12 mt-3">
                                <p><strong>{{ __('translate.Special Requests') }}:</strong></p>
                                <div class="p-3 bg-light rounded">{{ $spa_booking->notes ?? __('translate.None') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="crancy-product-card mg-top-30">
                        <h4 class="crancy-product-card__title">{{ __('translate.Admin Management') }}</h4>
                        <form action="{{ dashboard_route('admin.special-booking.spa-bookings.update', $spa_booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Status') }}</label>
                                <select class="crancy__item-input" name="status">
                                    @foreach(['pending', 'contacted', 'confirmed', 'cancelled', 'completed'] as $status)
                                        <option value="{{ $status }}" {{ $spa_booking->status == $status ? 'selected' : '' }}>{{ __("translate." . ucfirst($status)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Quoted Price') }}</label>
                                <input class="crancy__item-input" type="number" step="0.01" name="quoted_price" value="{{ $spa_booking->quoted_price }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Payment Status') }}</label>
                                <input class="crancy__item-input" type="text" name="payment_status" value="{{ $spa_booking->payment_status }}">
                            </div>

                            <div class="crancy__item-form--group mg-top-form-20">
                                <label class="crancy__item-label">{{ __('translate.Admin Notes') }}</label>
                                <textarea class="crancy__item-input" name="admin_notes" rows="4">{{ $spa_booking->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="crancy-btn mt-3 w-100">{{ __('translate.Update Booking') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
