<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\FtthPopController;
use App\Http\Controllers\FtthOltController;
use App\Http\Controllers\FtthOdcController;
use App\Http\Controllers\FtthOdpController;

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

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['check.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pelanggan Routes
    Route::resource('pelanggan', PelangganController::class);
});

// FTTH Infrastructure Routes
Route::prefix('ftth')->name('ftth.')->group(function () {
    Route::resource('pop', FtthPopController::class);
    Route::resource('olt', FtthOltController::class);
    Route::resource('odc', FtthOdcController::class);
    Route::resource('odp', FtthOdpController::class);
});



