<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         // Crear roles
    $admin = Role::firstOrCreate(['name' => 'Admin']);
    $empleado = Role::firstOrCreate(['name' => 'Empleado']);
    $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);

    // Crear usuario admin inicial
    $user = User::firstOrCreate(
        ['email' => 'admin@alertapro.com'],
        ['name' => 'Administrador', 'password' => bcrypt('password')]
    );
    $user->assignRole($admin);
    }
}
