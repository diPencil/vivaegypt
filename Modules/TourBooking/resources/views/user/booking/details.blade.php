@extends('user.master_layout')
@section('title')
    <title>{{ __('translate.Booking Details') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Booking Details') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Booking Details') }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">

                            <div class="row justify-content-center">
                                <div class="col-10 mg-top-30">
                                    <div class="ed-invoice-page-wrapper">
                                        <div class="ed-invoice-main-wrapper">

                                            <div class="ed-invoice-page">
                                                <div class="ed-inv-logo-area">
                                                    <div class="ed-main-logo">
                                                        <img src="{{ asset($general_setting->secondary_logo) }}" alt="logo"
                                                            class="ed-logo">
                                                    </div>
                                                    <div>

                                                    </div>
                                                </div>

                                                <div class="ed-inv-billing-info">
                                                    <div class="ed-inv-info">
                                                        <p class="ed-inv-info-title">{{ __('translate.Billed To') }}
                                                        </p>
                                                        <table>
                                                            <tr>
                                                                <td>{{ __('translate.Name') }}:</td>
                                                                <td> {{ $booking->customer_name ?? 'NA' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Phone') }}:</td>
                                                                <td>{{ $booking?->customer_email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Email') }}:</td>
                                                                <td>{{ $booking?->customer_phone }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Address') }} : </td>
                                                                <td> {{ $booking?->customer_address }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="ed-inv-billing-info">
                                                    <div class="ed-inv-info">
                                                        <p class="ed-inv-info-title">
                                                            {{ __('translate.Booking Information') }}
                                                        </p>
                                                        <table>
                                                            <tr>
                                                                <td>{{ __('translate.Invoice No') }}:</td>
                                                                <td>#{{ $booking->booking_code }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Booking Status') }}:</td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-{{ $booking->booking_status == 'confirmed' ? 'success' : ($booking->booking_status == 'pending' ? 'warning' : ($booking->booking_status == 'cancelled' ? 'danger' : 'info')) }}">
                                                                        {{ ucfirst($booking->booking_status) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Payment Status') }} : </td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-{{ $booking->payment_status == 'completed' ? 'success' : 'warning' }}">
                                                                        {{ ucfirst($booking->payment_status) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Payment Method') }} : </td>
                                                                <td>
                                                                    {{ ucfirst($booking->payment_method) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Total Amount') }} : </td>
                                                                <td>
                                                                    {{ currency($booking->total) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Paid Amount') }} : </td>
                                                                <td>
                                                                    {{ currency($booking->paid_amount) }}
                                                                </td>
                                                            </tr>
                                                            @if ($booking->due_amount > 0)
                                                                <tr>
                                                                    <td>{{ __('translate.Due Amount') }} : </td>
                                                                    <td>
                                                                        {{ currency($booking->due_amount) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>

                                                    </div>
                                                    <div class="ed-inv-info">
                                                        <p class="ed-inv-info-title">
                                                            {{ __('translate.Service Information') }}
                                                        </p>
                                                        <table>
                                                            <tr>
                                                                <td>{{ __('translate.Title') }}:</td>
                                                                <td> {{ $booking->service->title ?? 'NA' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Location') }} : </td>
                                                                <td>{{ $booking?->service?->location }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('translate.Check in Date') }}:</td>
                                                                <td>{{ date('d M Y', strtotime($booking->check_in_date)) }}
                                                                </td>
                                                            </tr>
                                                            @if ($booking->check_out_date)
                                                                <tr>
                                                                    <td>{{ __('translate.Check out Date') }}:</td>
                                                                    <td>{{ date('d M Y', strtotime($booking->check_out_date)) }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            @if ($booking->is_per_person)
                                                                <tr>
                                                                    <td>{{ __('translate.Adults') }} : </td>
                                                                    <td> {{ $booking?->adults }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>{{ __('translate.Children') }} : </td>
                                                                    <td> {{ $booking?->children }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>{{ __('translate.Extra Charges') }} : </td>
                                                                    <td> {{ currency($booking?->extra_charges) }}</td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>

                                                @if ($booking->admin_notes)
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-muted">{{ __('translate.Admin note for you') }}
                                                            </h6>
                                                            <p>{{ $booking->admin_notes }}</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($booking->cancellation_reason)
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <h6 class="text-muted">
                                                                {{ __('translate.Cancellation reason') }}</h6>
                                                            <p>{{ $booking->cancellation_reason }}</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="text-muted">{{ __('translate.Actions') }}</h6>
                                                        <div class="d-flex flex-wrap gap-4">

                                                            <div>
                                                                <button class="btn btn-secondary">
                                                                    <a class="text-dark"
                                                                        href="{{ route('user.bookings.index') }}">
                                                                        <i class="bi bi-arrow-left"></i>
                                                                        {{ __('translate.Back to Bookings') }}
                                                                    </a>
                                                                </button>
                                                            </div>

                                                            <div>
                                                                @if (
                                                                    $booking->booking_status == 'pending' ||
                                                                        $booking->booking_status == 'confirmed' ||
                                                                        $booking->booking_status == 'success')
                                                                    <button type="button" class="btn btn-danger w-auto"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#cancelBookingModal">
                                                                        <i class="bi bi-x-circle"></i>
                                                                        {{ __('translate.Cancel Booking') }}
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            <div>
                                                                @if ($booking->booking_status == 'completed')
                                                                    <button class="btn btn-primary w-auto">
                                                                        <a target="_blank"
                                                                            href="{{ route('front.tourbooking.services.show', ['slug' => $booking->service->slug . '#reviewForm']) }}"
                                                                            class="text-white">
                                                                            <i class="bi bi-star"></i>
                                                                            {{ __('translate.Leave a Review') }}
                                                                        </a>
                                                                    </button>
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
                        <!-- End Dashboard Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->

    <!-- Cancel Booking Modal -->
    @if (
        $booking->booking_status == 'pending' ||
            $booking->booking_status == 'confirmed' ||
            $booking->booking_status == 'success')
        <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('user.bookings.cancel', ['id' => $booking->id]) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelBookingModalLabel">{{ __('translate.Cancel Booking') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger">{{ __('translate.Are you sure you want to cancel this booking?') }}</p>
                            <div class="mb-3">
                                <label for="cancellation_reason"
                                    class="form-label">{{ __('translate.Reason for Cancellation') }}</label>
                                <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('translate.Cancel Booking') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
