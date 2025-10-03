<?php

use Illuminate\Support\Facades\Route;
use Modules\Plantillas\Http\Controllers\PlantillasController;

Route::middleware(['web','auth', 'verified', 'role:Admin'])->group(function () {
    Route::resource('plantillas', PlantillasController::class)->names('plantillas');
});
