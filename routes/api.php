<?php

use App\Http\Controllers\Api\V1\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/reports', [ReportController::class, 'store']);
        Route::post('/hotline/panic', [ReportController::class, 'panic']);
    });
