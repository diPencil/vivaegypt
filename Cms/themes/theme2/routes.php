<?php

use Illuminate\Support\Facades\Route;
use Cms\Themes\Theme2\Src\Http\Controllers\Theme2Controller;

/*
|--------------------------------------------------------------------------
| Theme Routes
|--------------------------------------------------------------------------
|
| Here is where you can register theme-specific routes for your theme.
| These routes are loaded by the ThemeServiceProvider within a theme group which
| contains the "web" middleware. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/demo', [Theme2Controller::class, 'demo'])->name('theme1.demo');
});
