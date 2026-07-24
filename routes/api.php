<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SchoolApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes (V1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public API Auth
    Route::post('/login', [AuthController::class, 'login']);

    // Protected API Endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        // Analytics
        Route::get('/analytics', [SchoolApiController::class, 'analytics']);

        // Schools CRUD & Status API
        Route::get('/schools', [SchoolApiController::class, 'index']);
        Route::post('/schools', [SchoolApiController::class, 'store']);
        Route::get('/schools/{id}', [SchoolApiController::class, 'show']);
        Route::patch('/schools/{id}/status', [SchoolApiController::class, 'updateStatus']);
    });
});
