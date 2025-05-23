<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{product}', 'detail');
        Route::put('/{product}', 'update');
    });


Route::controller(App\Http\Controllers\Auth\AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('/login', 'login')->name('login');

        Route::post('/refresh', 'refresh')->name('refresh');
        Route::get('/me', 'me')->name('me');
    });
