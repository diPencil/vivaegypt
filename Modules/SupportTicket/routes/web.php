<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportTicket\App\Http\Controllers\ServiceQuery\User\ServiceQueryController as UserServiceQueryController;
use Modules\SupportTicket\App\Http\Controllers\ServiceQuery\Seller\ServiceQueryController as SellerServiceQueryController;
use Modules\SupportTicket\App\Http\Controllers\Support\Admin\SupportTicketController as AdminSupportTicketController;
use Modules\SupportTicket\App\Http\Controllers\Support\User\SupportTicketController as UserSupportTicketController;
use Modules\SupportTicket\App\Http\Controllers\Support\Seller\SupportTicketController as SellerSupportTicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth:web', 'HtmlSpecialchars', 'MaintenanceMode']], function () {

    Route::resource('support-ticket', UserSupportTicketController::class);
    Route::post('support-ticket-message/{id}', [UserSupportTicketController::class, 'support_ticket_message'])->name('support-ticket-message');

    Route::resource('agent-support', UserServiceQueryController::class);
    Route::post('agent-support-message/{id}', [UserServiceQueryController::class, 'support_ticket_message'])->name('agent-support-message');
});


Route::group(['as' => 'agent.', 'prefix' => 'agent', 'middleware' => ['auth:web', 'HtmlSpecialchars', 'MaintenanceMode']], function () {

    Route::resource('support-ticket', SellerSupportTicketController::class);
    Route::post('support-ticket-message/{id}', [SellerSupportTicketController::class, 'support_ticket_message'])->name('support-ticket-message');

    Route::get('supports', [SellerServiceQueryController::class, 'index'])->name('supports');
    Route::get('supports/{id}', [SellerServiceQueryController::class, 'show'])->name('support');
    Route::post('supports-message/{id}', [SellerServiceQueryController::class, 'support_ticket_message'])->name('support-message');
    Route::put('supports-close/{id}', [SellerServiceQueryController::class, 'close'])->name('support-close');
});


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'HtmlSpecialchars', 'MaintenanceMode']], function () {

    Route::get('support-tickets', [AdminSupportTicketController::class, 'index'])->name('support-tickets');
    Route::get('support-ticket/{id}', [AdminSupportTicketController::class, 'show'])->name('support-ticket');
    Route::post('support-ticket-message/{id}', [AdminSupportTicketController::class, 'support_ticket_message'])->name('support-ticket-message');
    Route::delete('support-ticket-delete/{id}', [AdminSupportTicketController::class, 'destroy'])->name('support-ticket-delete');
    Route::put('support-ticket-close/{id}', [AdminSupportTicketController::class, 'close'])->name('support-ticket-close');
});

Route::group(['as' => 'staff.', 'prefix' => 'staff', 'middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission', 'HtmlSpecialchars', 'MaintenanceMode']], function () {

    Route::get('support-tickets', [AdminSupportTicketController::class, 'index'])->name('support-tickets');
    Route::get('support-ticket/{id}', [AdminSupportTicketController::class, 'show'])->name('support-ticket');
    Route::post('support-ticket-message/{id}', [AdminSupportTicketController::class, 'support_ticket_message'])->name('support-ticket-message');
    Route::put('support-ticket-close/{id}', [AdminSupportTicketController::class, 'close'])->name('support-ticket-close');
});
