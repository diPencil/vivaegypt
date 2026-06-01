<?php

use Modules\Category\Http\Controllers\CategoryController;

Route::group(['as'=> 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin']],function (){

    Route::resource('category', CategoryController::class);

});

Route::group(['as'=> 'staff.', 'prefix' => 'staff', 'middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission']],function (){

    Route::resource('category', CategoryController::class)->except(['destroy']);

});
