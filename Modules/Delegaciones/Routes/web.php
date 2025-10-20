<?php

use Illuminate\Support\Facades\Route;
use Modules\Delegaciones\Http\Controllers\DelegacionesController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('delegaciones', [DelegacionesController::class, 'index'])->name('delegaciones.index');
    Route::get('delegaciones/crear/{evento_id}', [DelegacionesController::class, 'create'])->name('delegaciones.create');
    Route::post('delegaciones', [DelegacionesController::class, 'store'])->name('delegaciones.store');
    Route::get('delegaciones/{id}', [DelegacionesController::class, 'show'])->name('delegaciones.show');
    Route::delete('delegaciones/{id}', [DelegacionesController::class, 'destroy'])->name('delegaciones.destroy');
});
