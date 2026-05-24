<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankCardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\IssueController as AdminIssueController;
use App\Http\Controllers\Admin\PowerbankController as AdminPowerbankController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReturnController as AdminReturnController;
use App\Http\Controllers\Admin\StationController as AdminStationController;
use App\Http\Controllers\Admin\StationSlotController as AdminStationSlotController;
use App\Http\Controllers\Admin\TariffController as AdminTariffController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::get('/stations/{station}', [StationController::class, 'show'])->name('stations.show');
    Route::get('/stations/{station}/rent', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/stations/{station}/rent', [RentalController::class, 'store'])->name('rentals.store');

    Route::get('/rentals/current', [RentalController::class, 'current'])->name('rentals.current');
    Route::get('/rentals/history', [RentalController::class, 'history'])->name('rentals.history');
    Route::get('/rentals/{rental}/return', [ReturnController::class, 'create'])->name('rentals.return.create');
    Route::post('/rentals/{rental}/return', [ReturnController::class, 'store'])->name('rentals.return.store');

    Route::get('/bank-cards', [BankCardController::class, 'index'])->name('bank-cards.index');
    Route::post('/bank-cards', [BankCardController::class, 'store'])->name('bank-cards.store');
    Route::patch('/bank-cards/{bankCard}/default', [BankCardController::class, 'makeDefault'])->name('bank-cards.default');
    Route::delete('/bank-cards/{bankCard}', [BankCardController::class, 'destroy'])->name('bank-cards.destroy');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');
    Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

    Route::get('/stations', [AdminStationController::class, 'index'])->name('stations.index');
    Route::get('/stations/create', [AdminStationController::class, 'create'])->name('stations.create');
    Route::post('/stations', [AdminStationController::class, 'store'])->name('stations.store');
    Route::get('/stations/{station}/edit', [AdminStationController::class, 'edit'])->name('stations.edit');
    Route::put('/stations/{station}', [AdminStationController::class, 'update'])->name('stations.update');
    Route::delete('/stations/{station}', [AdminStationController::class, 'destroy'])->name('stations.destroy');
    Route::get('/stations/{station}/slots', [AdminStationSlotController::class, 'index'])->name('stations.slots');
    Route::patch('/stations/{station}/slots/{slot}', [AdminStationSlotController::class, 'update'])->name('stations.slots.update');

    Route::get('/powerbanks', [AdminPowerbankController::class, 'index'])->name('powerbanks.index');
    Route::get('/powerbanks/create', [AdminPowerbankController::class, 'create'])->name('powerbanks.create');
    Route::post('/powerbanks', [AdminPowerbankController::class, 'store'])->name('powerbanks.store');
    Route::get('/powerbanks/{powerbank}/edit', [AdminPowerbankController::class, 'edit'])->name('powerbanks.edit');
    Route::put('/powerbanks/{powerbank}', [AdminPowerbankController::class, 'update'])->name('powerbanks.update');
    Route::delete('/powerbanks/{powerbank}', [AdminPowerbankController::class, 'destroy'])->name('powerbanks.destroy');

    Route::get('/tariffs', [AdminTariffController::class, 'index'])->name('tariffs.index');
    Route::post('/tariffs', [AdminTariffController::class, 'store'])->name('tariffs.store');
    Route::put('/tariffs/{tariff}', [AdminTariffController::class, 'update'])->name('tariffs.update');
    Route::delete('/tariffs/{tariff}', [AdminTariffController::class, 'destroy'])->name('tariffs.destroy');

    Route::get('/rentals/active', [AdminRentalController::class, 'active'])->name('rentals.active');
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('/issues', [AdminIssueController::class, 'index'])->name('issues.index');
    Route::patch('/issues/{issue}', [AdminIssueController::class, 'update'])->name('issues.update');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [AdminReportController::class, 'store'])->name('reports.store');
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
});
