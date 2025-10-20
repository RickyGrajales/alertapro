<?php

use Illuminate\Support\Facades\Route;
use Modules\Delegaciones\Http\Controllers\DelegacionesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('delegaciones', DelegacionesController::class)->names('delegaciones');
});
