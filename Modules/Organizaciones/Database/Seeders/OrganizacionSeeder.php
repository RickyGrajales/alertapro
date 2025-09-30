<?php

namespace Modules\Organizaciones\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Organizaciones\Models\Organizacion;

class OrganizacionSeeder extends Seeder
{
    public function run(): void
    {
        $examples = [
            [
                'nombre' => 'ASODISVALLE',
                'nit' => '900000001',
                'tipo' => 'ONG',
                'representante' => 'Director ASODISVALLE',
                'email' => 'contacto@asodisvalle.org',
                'telefono' => '3120000001',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'descripcion' => 'Organización de la sociedad civil ASODISVALLE',
                'activo' => true
            ],
            [
                'nombre' => 'ATRAPASUEÑOS',
                'nit' => '900000002',
                'tipo' => 'Fundación',
                'representante' => 'Director Atrapasuños',
                'email' => 'info@atrapasuenos.org',
                'telefono' => '3120000002',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'descripcion' => 'Fundación Atrapasuños',
                'activo' => true
            ],
            [
                'nombre' => 'COLEGIO PORFIRIO BARBA JACOB',
                'nit' => '900000003',
                'tipo' => 'Colegio',
                'representante' => 'Rector Colegio',
                'email' => 'colegio@porfirio.edu.co',
                'telefono' => '3120000003',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'descripcion' => 'Colegio Porfirio Barba Jacob',
                'activo' => true
            ],
            [
                'nombre' => 'UNIVERSIDAD JEISON ARISTIZABAL',
                'nit' => '900000004',
                'tipo' => 'Universidad',
                'representante' => 'Rector Universidad',
                'email' => 'info@jeison.edu.co',
                'telefono' => '3120000004',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'descripcion' => 'Universidad Jeison Aristizabal',
                'activo' => true
            ],
        ];

        foreach ($examples as $data) {
            Organizacion::firstOrCreate(['nit' => $data['nit']], $data);
        }
    }
}
