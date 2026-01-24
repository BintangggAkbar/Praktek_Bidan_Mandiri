<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Bidan Controllers
use App\Http\Controllers\Bidan\BidanDashboardController;
use App\Http\Controllers\Bidan\BidanPatientController;
use App\Http\Controllers\Bidan\BidanMedicalRecordController;
use App\Http\Controllers\Bidan\BidanScheduleController;
use App\Http\Controllers\Bidan\BidanMedicineController;
use App\Http\Controllers\Bidan\BidanReportController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBidanController;
use App\Http\Controllers\Admin\AdminPatientController;
use App\Http\Controllers\Admin\AdminMedicineController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminMedicalRecordController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Bidan Routes
Route::prefix('bidan')->middleware(['auth', 'role:bidan'])->group(function () {
    Route::get('/dashboard', [BidanDashboardController::class, 'index'])->name('dashboard');

    // Patient Routes
    Route::resource('patients', BidanPatientController::class);

    // Medical Record Routes
    Route::get('/medical-records/create', [BidanMedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [BidanMedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/latest', [BidanMedicalRecordController::class, 'latest'])->name('medical-records.latest');
    Route::delete('/medical-records/{medicalRecord}', [BidanMedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    Route::get('/medical-records/{medicalRecord}', [BidanMedicalRecordController::class, 'show'])->name('medical-records.show');

    // Schedule
    Route::get('/schedule', [BidanScheduleController::class, 'index'])->name('bidan.schedule.index');

    // Medicine Routes
    Route::resource('medicines', BidanMedicineController::class);

    // Reports
    Route::get('/reports', [BidanReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [BidanReportController::class, 'print'])->name('reports.print');
    Route::get('/reports/excel', [BidanReportController::class, 'exportExcel'])->name('reports.excel');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Bidan Management
    Route::resource('bidans', AdminBidanController::class);

    // Patient Management (Read Only)
    Route::get('/patients', [AdminPatientController::class, 'index'])->name('patients.index');

    // Medicine Management (Read Only)
    Route::get('/medicines', [AdminMedicineController::class, 'index'])->name('medicines.index');

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
    Route::get('/reports/excel', [AdminReportController::class, 'exportExcel'])->name('reports.excel');

    // Services
    Route::resource('services', AdminServiceController::class)->names([
        'index' => 'services.index',
        'create' => 'services.create',
        'store' => 'services.store',
        'show' => 'services.show',
        'edit' => 'services.edit',
        'update' => 'services.update',
        'destroy' => 'services.destroy',
    ]);

    // Schedule
    Route::get('/schedule', [AdminScheduleController::class, 'index'])->name('schedule.index');
    Route::put('/schedule', [AdminScheduleController::class, 'update'])->name('schedule.update');

    // Medical Records (Read Only)
    Route::resource('medical-records', AdminMedicalRecordController::class)->only(['index', 'show']);
});
