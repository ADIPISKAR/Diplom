<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentRequestController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EquipmentCategoryController as AdminEquipmentCategoryController;
use App\Http\Controllers\Admin\EquipmentController as AdminEquipmentController;
use App\Http\Controllers\Admin\EquipmentRequestController as AdminEquipmentRequestController;
use App\Http\Controllers\Admin\EquipmentReturnController as AdminEquipmentReturnController;
use App\Http\Controllers\Admin\IssueController as AdminIssueController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StorageLocationController as AdminStorageLocationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\EquipmentRequestController as EmployeeEquipmentRequestController;
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
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

    Route::get('/requests', [EquipmentRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [EquipmentRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [EquipmentRequestController::class, 'store'])->name('requests.store');
    Route::patch('/requests/{equipmentRequest}/return-request', [EquipmentRequestController::class, 'requestReturn'])->name('requests.return-request');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');
    Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');
});

Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function (): void {
    Route::get('/', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests', [EmployeeEquipmentRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{equipmentRequest}/edit', [EmployeeEquipmentRequestController::class, 'edit'])->name('requests.edit');
    Route::patch('/requests/{equipmentRequest}/approve', [EmployeeEquipmentRequestController::class, 'approve'])->name('requests.approve');
    Route::patch('/requests/{equipmentRequest}/issue', [EmployeeEquipmentRequestController::class, 'issue'])->name('requests.issue');
    Route::patch('/requests/{equipmentRequest}/return', [EmployeeEquipmentRequestController::class, 'completeReturn'])->name('requests.return');
    Route::patch('/requests/{equipmentRequest}/reject', [EmployeeEquipmentRequestController::class, 'reject'])->name('requests.reject');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

    Route::get('/categories', [AdminEquipmentCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminEquipmentCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminEquipmentCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminEquipmentCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/locations', [AdminStorageLocationController::class, 'index'])->name('locations.index');
    Route::post('/locations', [AdminStorageLocationController::class, 'store'])->name('locations.store');
    Route::put('/locations/{location}', [AdminStorageLocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [AdminStorageLocationController::class, 'destroy'])->name('locations.destroy');

    Route::get('/equipment', [AdminEquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/create', [AdminEquipmentController::class, 'create'])->name('equipment.create');
    Route::post('/equipment', [AdminEquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/equipment/{equipment}/edit', [AdminEquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('/equipment/{equipment}', [AdminEquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/equipment/{equipment}', [AdminEquipmentController::class, 'destroy'])->name('equipment.destroy');

    Route::get('/requests/active', [AdminEquipmentRequestController::class, 'active'])->name('requests.active');
    Route::get('/requests', [AdminEquipmentRequestController::class, 'index'])->name('requests.index');
    Route::get('/returns', [AdminEquipmentReturnController::class, 'index'])->name('returns.index');
    Route::get('/issues', [AdminIssueController::class, 'index'])->name('issues.index');
    Route::patch('/issues/{issue}', [AdminIssueController::class, 'update'])->name('issues.update');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [AdminReportController::class, 'store'])->name('reports.store');
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
});
