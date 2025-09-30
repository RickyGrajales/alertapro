<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Usuarios\Database\Seeders\UsuarioSeeder;
use Modules\Organizaciones\Database\Seeders\OrganizacionSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            OrganizacionSeeder::class,
        ]);
    }
}
