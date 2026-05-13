<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PowerbankController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TariffController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('stations', StationController::class)->only(['store', 'update', 'destroy']);
Route::resource('powerbanks', PowerbankController::class)->only(['store', 'update', 'destroy']);
Route::resource('tariffs', TariffController::class)->only(['store', 'update', 'destroy']);
Route::resource('rentals', RentalController::class)->only(['store', 'update', 'destroy']);
Route::resource('payments', PaymentController::class)->only(['store', 'update', 'destroy']);
Route::resource('error-logs', ErrorLogController::class)->only(['store', 'destroy']);
Route::post('simulation', [SimulationController::class, 'store'])->name('simulation.store');
