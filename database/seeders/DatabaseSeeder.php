<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Usuarios\Database\Seeders\UsuarioSeeder;
use Modules\Organizaciones\Database\Seeders\OrganizacionSeeder;
use Modules\Eventos\Database\Seeders\EventosSeeder;
use Modules\Plantillas\Database\Seeders\PlantillasSeeder;
use Modules\Reprogramaciones\Database\Seeders\ReprogramacionesSeeder; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            OrganizacionSeeder::class,
            EventosSeeder::class,
            PlantillasSeeder::class,
            ReprogramacionesSeeder::class,
        ]);
    }
}
