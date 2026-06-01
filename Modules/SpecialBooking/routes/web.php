<?php

use Illuminate\Support\Facades\Route;
use Modules\SpecialBooking\App\Http\Controllers\SpecialBookingController;
use Modules\SpecialBooking\App\Http\Controllers\Front\SpecialBookingController as FrontSpecialBookingController;

Route::group(['as' => 'special-booking.', 'prefix' => 'booking-services', 'middleware' => ['web', 'HtmlSpecialchars', 'MaintenanceMode']], function () {
    Route::get('/', [FrontSpecialBookingController::class, 'index'])->name('index');
    
    Route::get('/spa', [FrontSpecialBookingController::class, 'spa'])->name('spa');
    Route::post('/spa/book', [FrontSpecialBookingController::class, 'storeSpaBooking'])->name('spa.book');
    
    Route::get('/flights', [FrontSpecialBookingController::class, 'flights'])->name('flights');
    Route::post('/flights/request', [FrontSpecialBookingController::class, 'storeFlightRequest'])->name('flights.request');
    
    Route::get('/transfers', [FrontSpecialBookingController::class, 'transfers'])->name('transfers');
    Route::post('/transfers/request', [FrontSpecialBookingController::class, 'storeTransferRequest'])->name('transfers.request');
    
    Route::get('/nile-cruises', [FrontSpecialBookingController::class, 'nileCruises'])->name('nile-cruises');
    Route::post('/nile-cruises/request', [FrontSpecialBookingController::class, 'storeNileCruiseRequest'])->name('nile-cruises.request');
});

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

use Modules\SpecialBooking\App\Http\Controllers\Admin\SpaServiceController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\SpaBookingController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\FlightRequestController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\TransferRequestController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\NileCruiseRequestController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\AirlineController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\TransferVehicleController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\NileCruiseRouteController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\NileCruiseCabinController;
use Modules\SpecialBooking\App\Http\Controllers\Admin\BookingFeatureController;

Route::group(['as' => 'admin.special-booking.', 'prefix' => 'admin/special-booking', 'middleware' => ['auth:admin']], function () {
    // Catalogs
    Route::resource('airlines', AirlineController::class)->except(['show']);
    Route::get('airlines/{airline}/status', [AirlineController::class, 'updateStatus'])->name('airlines.update-status');

    Route::resource('transfer-vehicles', TransferVehicleController::class)->except(['show']);
    Route::get('transfer-vehicles/{transfer_vehicle}/status', [TransferVehicleController::class, 'updateStatus'])->name('transfer-vehicles.update-status');

    Route::resource('nile-cruise-routes', NileCruiseRouteController::class)->except(['show']);
    Route::get('nile-cruise-routes/{nile_cruise_route}/status', [NileCruiseRouteController::class, 'updateStatus'])->name('nile-cruise-routes.update-status');

    Route::resource('nile-cruise-cabins', NileCruiseCabinController::class)->except(['show']);
    Route::get('nile-cruise-cabins/{nile_cruise_cabin}/status', [NileCruiseCabinController::class, 'updateStatus'])->name('nile-cruise-cabins.update-status');

    Route::resource('booking-features', BookingFeatureController::class)->except(['show']);
    Route::get('booking-features/{booking_feature}/status', [BookingFeatureController::class, 'updateStatus'])->name('booking-features.update-status');

    // SPA Services
    Route::resource('spa-services', SpaServiceController::class);
    Route::get('spa-services/{spa_service}/status', [SpaServiceController::class, 'updateStatus'])->name('spa-services.update-status');

    // SPA Bookings
    Route::resource('spa-bookings', SpaBookingController::class)->only(['index', 'show', 'update']);

    // Flight Requests
    Route::resource('flight-requests', FlightRequestController::class)->only(['index', 'show', 'update']);

    // Transfer Requests
    Route::resource('transfer-requests', TransferRequestController::class)->only(['index', 'show', 'update']);

    // Nile Cruise Requests
    Route::resource('nile-cruise-requests', NileCruiseRequestController::class)->only(['index', 'show', 'update']);
});

Route::group(['as' => 'staff.special-booking.', 'prefix' => 'staff/special-booking', 'middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission']], function () {
    // Catalogs
    Route::resource('airlines', AirlineController::class)->except(['destroy']);
    Route::get('airlines/{airline}/status', [AirlineController::class, 'updateStatus'])->name('airlines.update-status');

    Route::resource('transfer-vehicles', TransferVehicleController::class)->except(['destroy']);
    Route::get('transfer-vehicles/{transfer_vehicle}/status', [TransferVehicleController::class, 'updateStatus'])->name('transfer-vehicles.update-status');

    Route::resource('nile-cruise-routes', NileCruiseRouteController::class)->except(['destroy']);
    Route::get('nile-cruise-routes/{nile_cruise_route}/status', [NileCruiseRouteController::class, 'updateStatus'])->name('nile-cruise-routes.update-status');

    Route::resource('nile-cruise-cabins', NileCruiseCabinController::class)->except(['destroy']);
    Route::get('nile-cruise-cabins/{nile_cruise_cabin}/status', [NileCruiseCabinController::class, 'updateStatus'])->name('nile-cruise-cabins.update-status');

    Route::resource('booking-features', BookingFeatureController::class)->except(['destroy']);
    Route::get('booking-features/{booking_feature}/status', [BookingFeatureController::class, 'updateStatus'])->name('booking-features.update-status');

    // SPA Services
    Route::resource('spa-services', SpaServiceController::class)->except(['destroy']);
    Route::get('spa-services/{spa_service}/status', [SpaServiceController::class, 'updateStatus'])->name('spa-services.update-status');

    // SPA Bookings
    Route::resource('spa-bookings', SpaBookingController::class)->only(['index', 'show', 'update']);

    // Flight Requests
    Route::resource('flight-requests', FlightRequestController::class)->only(['index', 'show', 'update']);

    // Transfer Requests
    Route::resource('transfer-requests', TransferRequestController::class)->only(['index', 'show', 'update']);

    // Nile Cruise Requests
    Route::resource('nile-cruise-requests', NileCruiseRequestController::class)->only(['index', 'show', 'update']);
});

