<?php

namespace Modules\Plantillas\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Plantillas\Models\Template;
use Modules\Plantillas\Models\TemplateItem;
use Modules\Plantillas\Models\NotificationRule;

class PlantillasSeeder extends Seeder
{
    public function run()
    {
        // Plantilla de ejemplo
        $plantilla = Template::create([
            'nombre' => 'Informe Mensual de Cumplimiento',
            'descripcion' => 'Checklist mensual para verificar cumplimiento en todas las áreas de la organización.',
            'recurrencia' => 'mensual',
            'activo' => true,
        ]);

        // Ítems
        $items = [
            ['nombre' => 'Recolectar datos de operaciones', 'descripcion' => 'Solicitar datos al área de operaciones', 'orden' => 1, 'obligatorio' => true],
            ['nombre' => 'Subir documento PDF', 'descripcion' => 'Cargar el informe en formato PDF', 'orden' => 2, 'obligatorio' => true],
            ['nombre' => 'Revisión del supervisor', 'descripcion' => 'El supervisor debe aprobar el documento', 'orden' => 3, 'obligatorio' => false],
        ];

        foreach ($items as $item) {
            $plantilla->items()->create($item);
        }

        // Reglas de notificación
        $rules = [
            ['canal' => 'email', 'offset' => -3, 'mensaje' => 'Recordatorio: el informe vence en 3 días'],
            ['canal' => 'whatsapp', 'offset' => 0, 'mensaje' => 'Hoy vence el informe mensual'],
        ];

        foreach ($rules as $rule) {
            $plantilla->rules()->create($rule);
        }

        // Otra plantilla opcional
        $plantilla2 = Template::create([
            'nombre' => 'Revisión de Contratos Anual',
            'descripcion' => 'Checklist para verificar que los contratos de proveedores estén al día.',
            'recurrencia' => 'anual',
            'activo' => true,
        ]);

        $plantilla2->items()->create([
            'nombre' => 'Revisar contratos vigentes',
            'descripcion' => 'Verificar fechas de vencimiento',
            'orden' => 1,
            'obligatorio' => true,
        ]);

        $plantilla2->rules()->create([
            'canal' => 'email',
            'offset' => -7,
            'mensaje' => 'Recordatorio: la revisión de contratos es en una semana',
        ]);
    }
}
