<?php

namespace Modules\Plantillas\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Plantillas\Models\Template;
use Modules\Plantillas\Models\TemplateItem;
use Modules\Plantillas\Models\NotificationRule;

class PlantillasSeeder extends Seeder
{
    public function run(): void
    {
        $t = Template::create([
            'nombre' => 'Plantilla ejemplo - Checklist mensual',
            'descripcion' => 'Checklist mensual general.',
            'recurrencia' => 'Mensual',
            'activa' => true,
        ]);

        $t->items()->createMany([
            ['titulo' => 'Verificar documentos', 'detalle' => 'Revisar que estén completos', 'orden'=>1, 'requerido'=>1, 'tipo'=>'texto'],
            ['titulo' => 'Fotos evidencia', 'detalle' => 'Subir fotos', 'orden'=>2, 'requerido'=>0, 'tipo'=>'archivo'],
            ['titulo' => 'Confirmar asistencia', 'detalle' => '', 'orden'=>3, 'requerido'=>0, 'tipo'=>'checkbox'],
        ]);

        $t->notificationRules()->create([
            'canal' => 'email',
            'offset_days' => 2,
            'momento' => 'antes',
            'hora' => '08:00',
        ]);
    }
}
