<?php

namespace Modules\Usuarios\Tests\Feature;

use Tests\TestCase;
use Modules\Usuarios\Entities\Usuario;
use Modules\Organizaciones\Entities\Organizacion;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuariosTest extends TestCase
{
    use RefreshDatabase;

    public function test_listado_usuarios_funciona()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/usuarios');

        $response->assertStatus(200);
        $response->assertSee('Gestión de Usuarios');
    }

    public function test_crear_usuario()
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Organizacion::factory()->create();
        
        $admin = Usuario::factory()->create();
        $admin->assignRole('Admin');

        $this->actingAs($admin);

        $response = $this->post('/usuarios', [
            'nombre' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rol' => 'Admin'
        ]);

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseHas('usuarios', ['email' => 'test@example.com']);
    }
}
