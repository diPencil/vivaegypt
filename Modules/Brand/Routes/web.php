<?php

use Modules\Brand\Http\Controllers\BrandController;


Route::group(['as'=> 'admin.', 'prefix' => 'admin/', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode','auth:admin']],function (){

    Route::resource('brand', BrandController::class);

});

Route::group(['as'=> 'staff.', 'prefix' => 'staff/', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode', 'auth:web', 'CheckStaff', 'CheckStaffRoutePermission']],function (){

    Route::resource('brand', BrandController::class)->except(['destroy']);

});
