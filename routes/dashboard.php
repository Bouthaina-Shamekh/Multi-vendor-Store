<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\DashboardController;
use App\Http\Controllers\Dashboard\CategoryController;

Route::group([
    'middleware' => 'auth',
        //هاي لاستخدام الراوت داخل الكود
    'prefix' => 'dashboard'  // هاي لاستخدام الكود داخل url
],function(){

    Route::get('/' ,[DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/category' , CategoryController::class);
});
