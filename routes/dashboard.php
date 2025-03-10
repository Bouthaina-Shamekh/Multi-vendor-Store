<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;

Route::group([
    'middleware' => 'auth',
        //هاي لاستخدام الراوت داخل الكود
    'prefix' => 'dashboard'  // هاي لاستخدام الكود داخل url
],function(){

    Route::get('/' ,[DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
   
    Route::get('/category/trash' , [CategoryController::class , 'trash'])->name('category.trash');
    Route::put('/category/{category}/restore' , [CategoryController::class , 'restore'])->name('category.restore');
    Route::delete('/category/{category}/force-delete' , [CategoryController::class , 'forcedelete'])->name('category.forcedelete');
    Route::resource('/category' , CategoryController::class);
    Route::resource('/products' , ProductController::class);
});
