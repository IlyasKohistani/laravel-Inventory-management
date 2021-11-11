<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// URL::temporarySignedRoute('images', now()->addMinutes(ENV('SIGNED_URL_EXPIRATION_TIME')))
Route::get('import', [ImportController::class, 'index'])->name('import.index');
Route::post('import', [ImportController::class, 'importData'])->name('import.import');
Route::get('images', [ImportController::class, 'images'])->name('images')->middleware('signed');

});
