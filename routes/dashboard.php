<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\DashboardController;
use App\Http\Controllers\Dashboard\CategoryController;

Route::get('/dash', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

 Route::group(['middleware' =>['auth']], function(){
    Route::get('/dashboard' ,[DashboardController::class, 'index']);
 });

 Route::resource('category' , CategoryController::class);