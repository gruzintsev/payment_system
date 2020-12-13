<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to(route('transactions'));
});

Route::prefix('transactions')
    ->group(function () {
        Route::get('/', TransactionController::class . '@index')->name('transactions');
        Route::get('/export', TransactionController::class . '@export')->name('transactions.export');
    });

Route::prefix('jobs')
    ->group(function () {
        Route::get('/', JobController::class . '@index')->name('jobs');
        Route::get('/{job}', JobController::class . '@view')->name('jobs.view');
    });
