<?php

use Illuminate\Support\Facades\Route;
use Modules\Reprogramaciones\Http\Controllers\ReprogramacionesController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/reprogramaciones', [ReprogramacionesController::class, 'index'])->name('reprogramaciones.index');
    Route::get('/reprogramaciones/crear/{evento_id}', [ReprogramacionesController::class, 'create'])->name('reprogramaciones.create');
    Route::post('/reprogramaciones', [ReprogramacionesController::class, 'store'])->name('reprogramaciones.store');
    Route::get('/reprogramaciones/{id}', [ReprogramacionesController::class, 'show'])->name('reprogramaciones.show');
    Route::get('/reprogramaciones/{id}/editar', [ReprogramacionesController::class, 'edit'])->name('reprogramaciones.edit');
    Route::put('/reprogramaciones/{id}', [ReprogramacionesController::class, 'update'])->name('reprogramaciones.update');
    Route::delete('/reprogramaciones/{id}', [ReprogramacionesController::class, 'destroy'])->name('reprogramaciones.destroy');
});
