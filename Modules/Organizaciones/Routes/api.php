<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('organizaciones', OrganizacionesController::class)->names('organizaciones');
});
