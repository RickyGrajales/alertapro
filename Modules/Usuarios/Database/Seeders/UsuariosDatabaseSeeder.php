<?php

namespace Modules\Usuarios\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Usuarios\Models\Usuario;

class UsuariosDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador por defecto
        Usuario::firstOrCreate(
            ['email' => 'admin@alertapro.com'],
            [
                'nombre' => 'Administrador General',
                'password' => Hash::make('password123'), // cámbialo en producción
                'rol' => 'Admin',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );

        // Usuario Supervisor de ejemplo
        Usuario::firstOrCreate(
            ['email' => 'supervisor@alertapro.com'],
            [
                'nombre' => 'Supervisor Demo',
                'password' => Hash::make('password123'),
                'rol' => 'Supervisor',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );

        // Usuario Empleado de ejemplo
        Usuario::firstOrCreate(
            ['email' => 'empleado@alertapro.com'],
            [
                'nombre' => 'Empleado Demo',
                'password' => Hash::make('password123'),
                'rol' => 'Empleado',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
    }
}
