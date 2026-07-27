<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolManagementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PublicSchoolController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PublicSchoolController::class, 'index'])->name('home');
Route::get('/register', [PublicSchoolController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [PublicSchoolController::class, 'register'])->middleware('throttle:60,1')->name('register.submit');
Route::get('/api/zones', [PublicSchoolController::class, 'getZones'])->name('public.zones');
Route::get('/api/check-suic', [PublicSchoolController::class, 'checkSuic'])->name('public.check-suic');
Route::get('/api/check-domain-live', [PublicSchoolController::class, 'checkDomainLive'])->name('public.check-domain-live');
Route::get('/api/check-domain-availability', [PublicSchoolController::class, 'checkDomainAvailability'])->name('public.check-domain-availability');

// Fallback Login Route Alias
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Settings & Profile
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::post('/settings/registration', [SettingsController::class, 'toggleRegistration'])->name('settings.registration');

        // School Management
        Route::get('/schools', [SchoolManagementController::class, 'index'])->name('schools.index');
        Route::get('/schools/export/csv', [SchoolManagementController::class, 'exportCsv'])->name('schools.export.csv');
        Route::get('/schools/{id}', [SchoolManagementController::class, 'show'])->name('schools.show');
        Route::get('/schools/{id}/edit', [SchoolManagementController::class, 'edit'])->name('schools.edit');
        Route::put('/schools/{id}', [SchoolManagementController::class, 'update'])->name('schools.update');
        Route::patch('/schools/{id}/status', [SchoolManagementController::class, 'updateStatus'])->name('schools.status.update');
        Route::delete('/schools/{id}', [SchoolManagementController::class, 'destroy'])->name('schools.destroy');
    });
});
