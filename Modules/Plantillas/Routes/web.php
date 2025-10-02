<?php

use Illuminate\Support\Facades\Route;
use Modules\Plantillas\Http\Controllers\PlantillasController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('plantillas', PlantillasController::class)->names('plantillas');
});
