<?php

namespace Modules\Organizaciones\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrganizacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organizaciones')->insert([
            [
                'nombre' => 'ASODISVALLE',
                'nit' => '900123456-1',
                'tipo' => 'Fundación',
                'representante' => 'Jeison Aristizábal',
                'email' => 'contacto@asodisvalle.org',
                'telefono' => '3001234567',
                'direccion' => 'Cali - Valle del Cauca',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'pagina_web' => 'https://asodisvalle.org',
                'logo' => null,
                'descripcion' => 'Asociación para personas con discapacidad en el Valle.',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Fundación Atrapasueños',
                'nit' => '900654321-2',
                'tipo' => 'ONG',
                'representante' => 'María Fernanda López',
                'email' => 'info@atrapasuenos.org',
                'telefono' => '3109876543',
                'direccion' => 'Cra 10 #20-30',
                'ciudad' => 'Palmira',
                'departamento' => 'Valle del Cauca',
                'pagina_web' => null,
                'logo' => null,
                'descripcion' => 'Fundación dedicada a proyectos educativos y culturales.',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Colegio Porfirio Barba Jacob',
                'nit' => '811223344-5',
                'tipo' => 'Colegio',
                'representante' => 'Carlos Restrepo',
                'email' => 'colegio@barbajacob.edu.co',
                'telefono' => '6021234567',
                'direccion' => 'Cl 45 #23-50',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'pagina_web' => 'https://barbajacob.edu.co',
                'logo' => null,
                'descripcion' => 'Institución educativa reconocida en la región.',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Universidad Jeison Aristizábal',
                'nit' => '901112223-6',
                'tipo' => 'Universidad',
                'representante' => 'Jeison Aristizábal',
                'email' => 'rectoria@uja.edu.co',
                'telefono' => '6012345678',
                'direccion' => 'Av. Principal #100-200',
                'ciudad' => 'Cali',
                'departamento' => 'Valle del Cauca',
                'pagina_web' => 'https://uja.edu.co',
                'logo' => null,
                'descripcion' => 'Universidad inclusiva fundada por Jeison Aristizábal.',
                'activo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
