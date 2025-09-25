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
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $empleadoRole = Role::firstOrCreate(['name' => 'Empleado']);
        $supervisorRole = Role::firstOrCreate(['name' => 'Supervisor']);

        // Crear usuario Admin inicial
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@alertapro.com'],
            [
                'nombre' => 'Administrador General',
                'password' => Hash::make('password123'),
                'rol' => 'Admin',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
        $admin->assignRole($adminRole);

        // Crear supervisor de ejemplo
        $supervisor = Usuario::firstOrCreate(
            ['email' => 'supervisor@alertapro.com'],
            [
                'nombre' => 'Supervisor Demo',
                'password' => Hash::make('password123'),
                'rol' => 'Supervisor',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
        $supervisor->assignRole($supervisorRole);

        // Crear empleado de ejemplo
        $empleado = Usuario::firstOrCreate(
            ['email' => 'empleado@alertapro.com'],
            [
                'nombre' => 'Empleado Demo',
                'password' => Hash::make('password123'),
                'rol' => 'Empleado',
                'activo' => true,
                'organizacion_id' => null,
            ]
        );
        $empleado->assignRole($empleadoRole);
    }
}
