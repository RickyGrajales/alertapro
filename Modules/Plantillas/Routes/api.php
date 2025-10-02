<?php

use Illuminate\Support\Facades\Route;
use Modules\Plantillas\Http\Controllers\PlantillasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('plantillas', PlantillasController::class)->names('plantillas');
});
