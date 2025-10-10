<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizaciones\Http\Controllers\OrganizacionesController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('organizaciones', [OrganizacionesController::class, 'index'])->name('organizaciones.index');
    Route::get('organizaciones/{organizacion}', [OrganizacionesController::class, 'show'])->name('organizaciones.show');
});

Route::middleware(['web', 'auth', 'verified', 'role:Admin'])->group(function () {
    Route::get('organizaciones/create', [OrganizacionesController::class, 'create'])->name('organizaciones.create');
    Route::post('organizaciones', [OrganizacionesController::class, 'store'])->name('organizaciones.store');
    Route::get('organizaciones/{organizacion}/edit', [OrganizacionesController::class, 'edit'])->name('organizaciones.edit');
    Route::put('organizaciones/{organizacion}', [OrganizacionesController::class, 'update'])->name('organizaciones.update');
    Route::delete('organizaciones/{organizacion}', [OrganizacionesController::class, 'destroy'])->name('organizaciones.destroy');
});
