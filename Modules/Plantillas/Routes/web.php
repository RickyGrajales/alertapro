<?php

use Illuminate\Support\Facades\Route;
use Modules\Plantillas\Http\Controllers\PlantillasController;

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('plantillas', [PlantillasController::class,'index'])->name('plantillas.index');
    Route::get('plantillas/crear', [PlantillasController::class,'create'])->name('plantillas.create');
    Route::post('plantillas', [PlantillasController::class,'store'])->name('plantillas.store');
    Route::get('plantillas/{template}', [PlantillasController::class,'show'])->name('plantillas.show');
    Route::get('plantillas/{template}/editar', [PlantillasController::class,'edit'])->name('plantillas.edit');
    Route::put('plantillas/{template}', [PlantillasController::class,'update'])->name('plantillas.update');
    Route::delete('plantillas/{template}', [PlantillasController::class,'destroy'])->name('plantillas.destroy');
});

