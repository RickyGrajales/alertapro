<?php

use Illuminate\Support\Facades\Route;
use Modules\Plantillas\Http\Controllers\PlantillasController;

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('plantillas', [PlantillasController::class, 'index'])->name('plantillas.index');
    Route::get('plantillas/create', [PlantillasController::class, 'create'])->name('plantillas.create');
    Route::post('plantillas', [PlantillasController::class, 'store'])->name('plantillas.store');
    Route::get('plantillas/{plantilla}', [PlantillasController::class, 'show'])->name('plantillas.show');
    Route::get('plantillas/{plantilla}/edit', [PlantillasController::class, 'edit'])->name('plantillas.edit');
    Route::put('plantillas/{plantilla}', [PlantillasController::class, 'update'])->name('plantillas.update');
    Route::delete('plantillas/{plantilla}', [PlantillasController::class, 'destroy'])->name('plantillas.destroy');
});
