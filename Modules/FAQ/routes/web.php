<?php

use Illuminate\Support\Facades\Route;
use Modules\FAQ\App\Http\Controllers\FAQController;



Route::group(['as'=> 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
    Route::resource('faq', FAQController::class)->names('faq');
});

Route::group(['as'=> 'staff.', 'prefix' => 'staff', 'middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission']], function () {
    Route::resource('faq', FAQController::class)->names('faq')->except(['destroy']);
});
