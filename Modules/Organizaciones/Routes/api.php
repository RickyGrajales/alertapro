<?php
use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Si quieres auth en api activa auth:sanctum solo si sanctum está configurado
    Route::apiResource('organizaciones', OrganizacionesController::class)
         ->parameters(['organizaciones' => 'organizacion']);
});
