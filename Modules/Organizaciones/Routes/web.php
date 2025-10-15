<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    // Rutas web públicas (autenticadas)
    Route::get('organizaciones', [OrganizacionesController::class, 'index'])->name('organizaciones.index');
    Route::get('organizaciones/create', [OrganizacionesController::class, 'create'])->name('organizaciones.create'); // Admin check en controller
    Route::post('organizaciones', [OrganizacionesController::class, 'store'])->name('organizaciones.store');
    Route::get('organizaciones/{organizacion}', [OrganizacionesController::class, 'show'])->name('organizaciones.show');
    Route::get('organizaciones/{organizacion}/edit', [OrganizacionesController::class, 'edit'])->name('organizaciones.edit');
    Route::put('organizaciones/{organizacion}', [OrganizacionesController::class, 'update'])->name('organizaciones.update');
    Route::delete('organizaciones/{organizacion}', [OrganizacionesController::class, 'destroy'])->name('organizaciones.destroy');
});
