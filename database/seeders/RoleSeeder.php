<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear roles básicos
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $empleadoRole = Role::firstOrCreate(['name' => 'Empleado']);
        

        // 2. Crear permisos básicos
        $permissions = [
            'usuarios.view',
            'usuarios.create',
            'usuarios.edit',
            'usuarios.delete',
            'eventos.view',
            'eventos.create',
            'eventos.edit',
            'eventos.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 3. Asignar permisos a roles
        $adminRole->givePermissionTo(Permission::all());
        $empleadoRole->givePermissionTo(['eventos.view', 'eventos.create']);
       

        // 4. Asignar un rol al primer usuario
        $user = User::first();
        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
