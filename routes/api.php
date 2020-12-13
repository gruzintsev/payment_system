<?php

use App\Http\Controllers\Api\CurrencyRateController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function() {
    Route::post('register', UserController::class . '@register')->name('register');

    Route::middleware('auth:api')
        ->group(static function() {
            Route::prefix('transfer')->group(static function (){
                Route::post('/', TransactionController::class . '@create')->name('transfer.create');
            });

            Route::prefix('currency-rate')->group(static function (){
                Route::post('/', CurrencyRateController::class . '@create')->name('currency.rate.create');
            });
        });

});
