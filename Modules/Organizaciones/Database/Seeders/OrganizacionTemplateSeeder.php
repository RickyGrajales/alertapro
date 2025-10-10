<?php

namespace Modules\Organizaciones\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Organizaciones\Models\Organizacion;
use Modules\Plantillas\Models\Template;

class OrganizacionTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $organizaciones = Organizacion::all();
        $templates = Template::all();

        if ($organizaciones->isEmpty() || $templates->isEmpty()) {
            $this->command->warn('⚠️ No hay organizaciones o plantillas (templates) para asignar.');
            return;
        }

        foreach ($organizaciones as $org) {
            // Asignar entre 1 y 3 plantillas (templates) aleatoriamente
            $org->templates()->syncWithoutDetaching(
                $templates->random(rand(1, min(3, $templates->count())))->pluck('id')->toArray()
            );
        }

        $this->command->info('✅ Templates asignados correctamente a las organizaciones.');
    }
}
