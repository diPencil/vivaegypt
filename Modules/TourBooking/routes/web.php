<?php

use Illuminate\Support\Facades\Route;
use Modules\TourBooking\App\Http\Controllers\Admin\AmenitiesController;
use Modules\TourBooking\App\Http\Controllers\Admin\ServiceTypeController;
use Modules\TourBooking\App\Http\Controllers\Admin\ServiceController;
use Modules\TourBooking\App\Http\Controllers\Admin\BookingController;
use Modules\TourBooking\App\Http\Controllers\Admin\DestinationController;
use Modules\TourBooking\App\Http\Controllers\Admin\CouponController;
use Modules\TourBooking\App\Http\Controllers\Admin\ReviewController;
use Modules\TourBooking\App\Http\Controllers\Admin\ReportController;
use Modules\TourBooking\App\Http\Controllers\Agent\ServiceController as AgentServiceController;
use Modules\TourBooking\App\Http\Controllers\Front\FrontServiceController;
use Modules\TourBooking\App\Http\Controllers\Front\FrontBookingController;
use Modules\TourBooking\App\Http\Controllers\Front\PaymentController;
use Modules\TourBooking\App\Http\Controllers\User\BookingController as UserBookingController;
use Modules\TourBooking\App\Http\Controllers\Agent\BookingController as AgentBookingController;
use Modules\TourBooking\App\Http\Controllers\Agent\DestinationController as AgentDestinationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['as' => 'admin.tourbooking.', 'prefix' => 'admin/tourbooking', 'middleware' => ['auth:admin']], function () {
    // Service Types
    Route::resource('service-types', ServiceTypeController::class);

    // Services
    Route::resource('services', ServiceController::class);
    Route::get('services/type/{type}', [ServiceController::class, 'getByType'])->name('services.by-type');
    Route::get('services/tours', [ServiceController::class, 'tours'])->name('services.tours');
    Route::get('services/hotels', [ServiceController::class, 'hotels'])->name('services.hotels');
    Route::get('services/restaurants', [ServiceController::class, 'restaurants'])->name('services.restaurants');
    Route::get('services/rentals', [ServiceController::class, 'rentals'])->name('services.rentals');
    Route::get('services/activities', [ServiceController::class, 'activities'])->name('services.activities');

    // Service Media
    Route::post('services/{service}/media', [ServiceController::class, 'storeMedia'])->name('services.media.store');
    Route::delete('services/media/{media}', [ServiceController::class, 'deleteMedia'])->name('services.media.destroy');
    Route::post('services/media/{media}/set-thumbnail', [ServiceController::class, 'setThumbnail'])->name('services.media.set-thumbnail');
    Route::get('services/{service}/media', [ServiceController::class, 'showMedia'])->name('services.media');

    // Itineraries
    Route::get('services/{service}/itineraries', [ServiceController::class, 'showItineraries'])->name('services.itineraries');
    Route::post('services/{service}/itineraries', [ServiceController::class, 'storeItinerary'])->name('services.itineraries.store');
    Route::put('services/itineraries/{itinerary}', [ServiceController::class, 'updateItinerary'])->name('services.itineraries.update');
    Route::delete('services/itineraries/{itinerary}', [ServiceController::class, 'deleteItinerary'])->name('services.itineraries.destroy');

    // Extra Charges
    Route::get('services/{service}/extra-charges', [ServiceController::class, 'showExtraCharges'])->name('services.extra-charges');
    Route::post('services/{service}/extra-charges', [ServiceController::class, 'storeExtraCharge'])->name('services.extra-charges.store');
    Route::put('services/extra-charges/{charge}', [ServiceController::class, 'updateExtraCharge'])->name('services.extra-charges.update');
    Route::delete('services/extra-charges/{charge}', [ServiceController::class, 'deleteExtraCharge'])->name('services.extra-charges.destroy');

    // Availability
    Route::get('services/{service}/availability', [ServiceController::class, 'showAvailability'])->name('services.availability');
    Route::post('services/{service}/availability', [ServiceController::class, 'storeAvailability'])->name('services.availability.store');
    Route::put('services/availability/{availability}', [ServiceController::class, 'updateAvailability'])->name('services.availability.update');
    Route::delete('services/availability/{availability}', [ServiceController::class, 'deleteAvailability'])->name('services.availability.destroy');

    // Booking Management
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('bookings/{booking}/payment-status', [BookingController::class, 'updatePaymentStatus'])->name('bookings.payment-status');
    Route::get('bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('bookings/{booking}/download-invoice', [BookingController::class, 'downloadInvoicePdf'])->name('bookings.download-invoice');
    Route::get('bookings/status/{status}', [BookingController::class, 'getByStatus'])->name('bookings.status');

    Route::post('bookings/confirm', [BookingController::class, 'bookingConfirm'])->name('bookings.confirm');
    Route::post('bookings/cancel', [BookingController::class, 'bookingCancel'])->name('bookings.cancel');
    Route::post('bookings/add-note', [BookingController::class, 'bookingAddNote'])->name('bookings.add-note');

    // Destinations
    Route::resource('destinations', DestinationController::class);
    Route::put('destinations/{destination}/status', [DestinationController::class, 'updateStatus'])->name('destinations.update-status');
    Route::put('destinations/{destination}/featured', [DestinationController::class, 'updateFeatured'])->name('destinations.update-featured');

    // amenities
    Route::resource('amenities', AmenitiesController::class);
    Route::put('amenities/{amenity}/status', [AmenitiesController::class, 'updateStatus'])->name('amenities.update-status');

    // Coupons
    // Route::resource('coupons', CouponController::class);

    // Reviews
    Route::get('reviews', [ServiceController::class, 'review_list'])->name('reviews.index');
    Route::get('review/detail/{id}', [ServiceController::class, 'review_detail'])->name('reviews.detail');
    Route::delete('review/delete/{id}', [ServiceController::class, 'review_delete'])->name('reviews.delete');
    Route::put('review/approve/{id}', [ServiceController::class, 'review_approve'])->name('reviews.approve');
});

Route::group(['as' => 'staff.tourbooking.', 'prefix' => 'staff/tourbooking', 'middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission']], function () {
    // Service Types
    Route::resource('service-types', ServiceTypeController::class)->except(['destroy']);

    // Services
    Route::resource('services', ServiceController::class)->except(['destroy']);
    Route::get('services/type/{type}', [ServiceController::class, 'getByType'])->name('services.by-type');
    Route::get('services/tours', [ServiceController::class, 'tours'])->name('services.tours');
    Route::get('services/hotels', [ServiceController::class, 'hotels'])->name('services.hotels');
    Route::get('services/restaurants', [ServiceController::class, 'restaurants'])->name('services.restaurants');
    Route::get('services/rentals', [ServiceController::class, 'rentals'])->name('services.rentals');
    Route::get('services/activities', [ServiceController::class, 'activities'])->name('services.activities');

    // Service Media
    Route::post('services/{service}/media', [ServiceController::class, 'storeMedia'])->name('services.media.store');
    Route::post('services/media/{media}/set-thumbnail', [ServiceController::class, 'setThumbnail'])->name('services.media.set-thumbnail');
    Route::get('services/{service}/media', [ServiceController::class, 'showMedia'])->name('services.media');

    // Itineraries
    Route::get('services/{service}/itineraries', [ServiceController::class, 'showItineraries'])->name('services.itineraries');
    Route::post('services/{service}/itineraries', [ServiceController::class, 'storeItinerary'])->name('services.itineraries.store');
    Route::put('services/itineraries/{itinerary}', [ServiceController::class, 'updateItinerary'])->name('services.itineraries.update');

    // Extra Charges
    Route::get('services/{service}/extra-charges', [ServiceController::class, 'showExtraCharges'])->name('services.extra-charges');
    Route::post('services/{service}/extra-charges', [ServiceController::class, 'storeExtraCharge'])->name('services.extra-charges.store');
    Route::put('services/extra-charges/{charge}', [ServiceController::class, 'updateExtraCharge'])->name('services.extra-charges.update');

    // Availability
    Route::get('services/{service}/availability', [ServiceController::class, 'showAvailability'])->name('services.availability');
    Route::post('services/{service}/availability', [ServiceController::class, 'storeAvailability'])->name('services.availability.store');
    Route::put('services/availability/{availability}', [ServiceController::class, 'updateAvailability'])->name('services.availability.update');

    // Booking Management
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::post('bookings/{booking}/payment-status', [BookingController::class, 'updatePaymentStatus'])->name('bookings.payment-status');
    Route::get('bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('bookings/{booking}/download-invoice', [BookingController::class, 'downloadInvoicePdf'])->name('bookings.download-invoice');
    Route::get('bookings/status/{status}', [BookingController::class, 'getByStatus'])->name('bookings.status');

    Route::post('bookings/confirm', [BookingController::class, 'bookingConfirm'])->name('bookings.confirm');
    Route::post('bookings/cancel', [BookingController::class, 'bookingCancel'])->name('bookings.cancel');
    Route::post('bookings/add-note', [BookingController::class, 'bookingAddNote'])->name('bookings.add-note');

    // Destinations
    Route::resource('destinations', DestinationController::class)->except(['destroy']);
    Route::put('destinations/{destination}/status', [DestinationController::class, 'updateStatus'])->name('destinations.update-status');
    Route::put('destinations/{destination}/featured', [DestinationController::class, 'updateFeatured'])->name('destinations.update-featured');

    // amenities
    Route::resource('amenities', AmenitiesController::class)->except(['destroy']);
    Route::put('amenities/{amenity}/status', [AmenitiesController::class, 'updateStatus'])->name('amenities.update-status');

    // Reviews
    Route::get('reviews', [ServiceController::class, 'review_list'])->name('reviews.index');
    Route::get('review/detail/{id}', [ServiceController::class, 'review_detail'])->name('reviews.detail');
    Route::put('review/approve/{id}', [ServiceController::class, 'review_approve'])->name('reviews.approve');
});

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
*/
Route::group(['as' => 'agent.tourbooking.', 'prefix' => 'agent/tourbooking', 'middleware' => ['auth', 'CheckAgent']], function () {

    // Services
    Route::resource('services', AgentServiceController::class);

    // Service Media
    Route::post('services/{service}/media', [AgentServiceController::class, 'storeMedia'])->name('services.media.store');
    Route::delete('services/media/{media}', [AgentServiceController::class, 'deleteMedia'])->name('services.media.destroy');
    Route::post('services/media/{media}/set-thumbnail', [AgentServiceController::class, 'setThumbnail'])->name('services.media.set-thumbnail');
    Route::get('services/{service}/media', [AgentServiceController::class, 'showMedia'])->name('services.media');

    // Itineraries
    Route::get('services/{service}/itineraries', [AgentServiceController::class, 'showItineraries'])->name('services.itineraries');
    Route::post('services/{service}/itineraries', [AgentServiceController::class, 'storeItinerary'])->name('services.itineraries.store');
    Route::put('services/itineraries/{itinerary}', [AgentServiceController::class, 'updateItinerary'])->name('services.itineraries.update');
    Route::delete('services/itineraries/{itinerary}', [AgentServiceController::class, 'deleteItinerary'])->name('services.itineraries.destroy');

    // Extra Charges
    Route::get('services/{service}/extra-charges', [AgentServiceController::class, 'showExtraCharges'])->name('services.extra-charges');
    Route::post('services/{service}/extra-charges', [AgentServiceController::class, 'storeExtraCharge'])->name('services.extra-charges.store');
    Route::put('services/extra-charges/{charge}', [AgentServiceController::class, 'updateExtraCharge'])->name('services.extra-charges.update');
    Route::delete('services/extra-charges/{charge}', [AgentServiceController::class, 'deleteExtraCharge'])->name('services.extra-charges.destroy');

    // Availability
    Route::get('services/{service}/availability', [AgentServiceController::class, 'showAvailability'])->name('services.availability');
    Route::post('services/{service}/availability', [AgentServiceController::class, 'storeAvailability'])->name('services.availability.store');
    Route::put('services/availability/{availability}', [AgentServiceController::class, 'updateAvailability'])->name('services.availability.update');
    Route::delete('services/availability/{availability}', [AgentServiceController::class, 'deleteAvailability'])->name('services.availability.destroy');

    // Booking Management
    Route::get('bookings', [AgentBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [AgentBookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [AgentBookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [AgentBookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/edit', [AgentBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{booking}', [AgentBookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [AgentBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('bookings/{booking}/payment-status', [AgentBookingController::class, 'updatePaymentStatus'])->name('bookings.payment-status');
    Route::get('bookings/{booking}/invoice', [AgentBookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('bookings/{booking}/download-invoice', [AgentBookingController::class, 'downloadInvoicePdf'])->name('bookings.download-invoice');
    Route::get('bookings/status/{status}', [AgentBookingController::class, 'getByStatus'])->name('bookings.status');

    Route::post('bookings/confirm', [AgentBookingController::class, 'bookingConfirm'])->name('bookings.confirm');
    Route::post('bookings/cancel', [AgentBookingController::class, 'bookingCancel'])->name('bookings.cancel');
    Route::post('bookings/add-note', [AgentBookingController::class, 'bookingAddNote'])->name('bookings.add-note');

    // Destinations
    Route::resource('destinations', AgentDestinationController::class);
    Route::put('destinations/{destination}/status', [AgentDestinationController::class, 'updateStatus'])->name('destinations.update-status');
    Route::put('destinations/{destination}/featured', [AgentDestinationController::class, 'updateFeatured'])->name('destinations.update-featured');
});

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['HtmlSpecialchars', 'MaintenanceMode']], function () {

    Route::get('tourbookings', [FrontServiceController::class, 'index'])->name('tourbooking');
    Route::get('tourbookings/{slug}', [FrontServiceController::class, 'show'])->name('tourbooking.show');

    Route::group(['as' => 'payment.', 'prefix' => 'payment', 'middleware' => ['auth:web']], function () {

        Route::post('/stripe', [PaymentController::class, 'stripe_payment'])->name('stripe');
        Route::post('/bank', [PaymentController::class, 'bank_payment'])->name('bank');

        Route::get('/paypal', [PaymentController::class, 'paypal_payment'])->name('paypal');
        Route::get('/paypal-success-payment', [PaymentController::class, 'paypal_success_payment'])->name('paypal-success-payment');
        Route::get('/paypal-faild-payment', [PaymentController::class, 'paypal_faild_payment'])->name('paypal-faild-payment');

        Route::post('/razorpay', [PaymentController::class, 'razorpay_payment'])->name('razorpay');

        Route::post('/flutterwave', [PaymentController::class, 'flutterwave_payment'])->name('flutterwave');

        Route::post('/paystack', [PaymentController::class, 'paystack_payment'])->name('paystack');

        Route::get('/paymob', [PaymentController::class, 'paymob_payment'])->name('paymob');
        Route::get('/paymob-callback', [PaymentController::class, 'paymob_callback'])->name('paymob-callback');

        Route::get('/mollie', [PaymentController::class, 'mollie_payment'])->name('mollie');
        Route::get('/mollie-callback', [PaymentController::class, 'mollie_callback'])->name('mollie-callback');


        Route::get('/instamojo', [PaymentController::class, 'instamojo_payment'])->name('instamojo');
        Route::get('/instamojo-callback', [PaymentController::class, 'instamojo_callback'])->name('instamojo-callback');

        Route::post('/cash-payment', [PaymentController::class, 'cash_payment'])->name('cash_payment');

        Route::get('/wallet', [PaymentController::class, 'wallet_payment'])->name('wallet');
    });
});

Route::group(['as' => 'front.tourbooking.', 'prefix' => 'tour-booking', 'middleware' => ['web']], function () {
    // Home/Search Page
    Route::get('/', [FrontServiceController::class, 'index'])->name('home');
    Route::get('/search', [FrontServiceController::class, 'search'])->name('search');

    // Service Types
    Route::get('/types', [FrontServiceController::class, 'serviceTypes'])->name('service-types');
    Route::get('/types/{slug}', [FrontServiceController::class, 'serviceTypeDetails'])->name('service-types.show');

    // Services
    Route::get('/services', [FrontServiceController::class, 'allServices'])->name('services');
    Route::get('/services/load', [FrontServiceController::class, 'loadServicesAjax'])->name('services.load.ajax');
    Route::get('/service/{slug}', [FrontServiceController::class, 'serviceDetail'])->name('services.show');

    Route::get('/tours', [FrontServiceController::class, 'tours'])->name('tours');
    Route::get('/hotels', [FrontServiceController::class, 'hotels'])->name('hotels');
    Route::get('/restaurants', [FrontServiceController::class, 'restaurants'])->name('restaurants');
    Route::get('/rentals', [FrontServiceController::class, 'rentals'])->name('rentals');
    Route::get('/activities', [FrontServiceController::class, 'activities'])->name('activities');

    // Destinations
    Route::get('/destinations', [FrontServiceController::class, 'destinations'])->name('destinations');
    Route::get('/destinations/{slug}', [FrontServiceController::class, 'destinationDetails'])->name('destinations.show');

    // Booking
    Route::get('/book/checkout/view', [FrontBookingController::class, 'bookingCheckoutView'])->name('book.checkout.view')->middleware('auth:web');

    // Reviews
    Route::post('/services/reviews', [FrontServiceController::class, 'storeReview'])->name('reviews.store');

    // Availability Check
    Route::post('/check-availability', [FrontBookingController::class, 'checkAvailability'])->name('check-availability');

    // Coupons
    Route::post('/validate-coupon', [FrontBookingController::class, 'validateCoupon'])->name('validate-coupon');

});

// user routes
Route::group(['as' => 'user.', 'prefix' => 'user'], function () {

    Route::group(['middleware' => 'auth:web'], function () {

        Route::get('/bookings', [UserBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/details/{id}', [UserBookingController::class, 'details'])->name('bookings.details');
        Route::post('/bookings/cancel/{id}', [UserBookingController::class, 'cancelBooking'])->name('bookings.cancel');
    });
});
