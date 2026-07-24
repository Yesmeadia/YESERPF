<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolManagementController;
use App\Http\Controllers\PublicSchoolController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PublicSchoolController::class, 'index'])->name('home');
Route::get('/register', [PublicSchoolController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [PublicSchoolController::class, 'register'])->name('register.submit');
Route::get('/api/zones', [PublicSchoolController::class, 'getZones'])->name('public.zones');
Route::get('/api/check-suic', [PublicSchoolController::class, 'checkSuic'])->name('public.check-suic');




// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // School Management
        Route::get('/schools', [SchoolManagementController::class, 'index'])->name('schools.index');
        Route::get('/schools/export/csv', [SchoolManagementController::class, 'exportCsv'])->name('schools.export.csv');
        Route::get('/schools/{id}', [SchoolManagementController::class, 'show'])->name('schools.show');
        Route::patch('/schools/{id}/status', [SchoolManagementController::class, 'updateStatus'])->name('schools.status.update');
        Route::delete('/schools/{id}', [SchoolManagementController::class, 'destroy'])->name('schools.destroy');
    });
});
