<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequestTransactionController;
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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware(['signed'])->group(function () {
    Route::get('product/{product}/image', [ProductController::class, 'getImage'])->name('product.image');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('product', ProductController::class)->except(['show','destroy']);
    Route::post('product/{product}/status', [ProductController::class, 'status'])->name('product.status');

    Route::resource('request-transaction', RequestTransactionController::class)->parameter('request-transaction' , 'request_transaction')->only(['index','store','destroy']);
    Route::resource('grant-transaction', GrantController::class)->parameter('grant-transaction' , 'grant')->only(['index','store','destroy']);
    Route::get('request-transaction/{request_transaction}/status', [RequestTransactionController::class, 'status'])->name('request-transaction.status');

    Route::get('import', [ImportController::class, 'index'])->name('import.index');
    Route::post('import', [ImportController::class, 'importData'])->name('import.import');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
