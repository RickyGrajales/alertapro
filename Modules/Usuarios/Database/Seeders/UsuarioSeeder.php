<?php

namespace Modules\Usuarios\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Usuarios\Models\Usuario;
use Spatie\Permission\Models\Role;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $empleadoRole = Role::firstOrCreate(['name' => 'Empleado']);

        // Crear usuario Admin inicial (Don Jimmy)
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@alertapro.com'],
            [
                'nombre' => 'Jimmmy Aristizabal',
                'password' => Hash::make('123456'),
                'rol' => 'Admin',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
        $admin->assignRole($adminRole);

        // Crear empleado de ejemplo
        $empleado = Usuario::firstOrCreate(
            ['email' => 'empleado@alertapro.com'],
            [
                'nombre' => 'Empleado Demo',
                'password' => Hash::make('123456'),
                'rol' => 'Empleado',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
        $empleado->assignRole($empleadoRole);
    }
}
