<?php

namespace Modules\Organizaciones\Database\Seeders;

use Illuminate\Database\Seeder;

class OrganizacionesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);
        $this->call([
            OrganizacionSeeder::class,
        ]);
    }
}
