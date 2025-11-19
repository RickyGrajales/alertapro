<?php

use Illuminate\Support\Facades\Route;
use Modules\Usuarios\Http\Controllers\UsuariosController;

// Rutas protegidas para Usuarios (solo Admin)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('usuarios', UsuariosController::class)->names('usuarios');

});

Route::get('/fix-roles', function () {
    $usuarios = \Modules\Usuarios\Models\Usuario::all();

    foreach ($usuarios as $u) {
        if ($u->rol) {
            $u->syncRoles([$u->rol]); 
        }
    }

    return "Roles sincronizados correctamente";
});


