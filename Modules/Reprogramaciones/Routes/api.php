<?php

use Illuminate\Support\Facades\Route;
use Modules\Reprogramaciones\Http\Controllers\ReprogramacionesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('reprogramaciones', ReprogramacionesController::class)->names('reprogramaciones');
});
