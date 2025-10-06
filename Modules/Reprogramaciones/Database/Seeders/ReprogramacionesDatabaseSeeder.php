<?php

namespace Modules\Reprogramaciones\Database\Seeders;

use Illuminate\Database\Seeder;

class ReprogramacionesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([ReprogramacionSeeder::class]);
    }
}
