<?php

use Illuminate\Support\Facades\Route;
use Modules\Eventos\Http\Controllers\EventosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('eventos', EventosController::class)->names('eventos');
});
