<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;

use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Dash\DashboardController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/' ,[HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/{product:slug}', [ProductController::class, 'show'])
        ->name('products.show');

     Route::resource('cart', CartController::class);

     Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
     Route::post('checkout', [CheckoutController::class, 'store']);

     Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
