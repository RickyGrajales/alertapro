<?php

namespace Modules\Usuarios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usuarios\Models\Usuario;
use Modules\Usuarios\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Modules\Organizaciones\Models\Organizacion;

class UsuariosController extends Controller
{
    public function __construct()
    {
        // Solo Admin puede crear/editar/eliminar; index/show según rol
        $this->middleware('role:Admin')->except(['index','show']);
    }

    public function index(Request $request)
    {
        $query = Usuario::with('organizacion', 'roles');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('rol', 'like', "%{$search}%")
                  ->orWhereHas('organizacion', function ($q2) use ($search) {
                      $q2->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Si NO es admin → solo muestra su propio usuario
        if (!auth()->user()->hasRole('Admin')) {
            $usuarios = Usuario::where('id', auth()->id())->paginate(10);
        } else {
            $usuarios = $query->orderBy('id', 'desc')->paginate(10);
        }

        // 🔥 Auto-fix de roles faltantes (solo una vez por usuario)
        foreach (Usuario::all() as $u) {
            if ($u->rol && !$u->hasAnyRole(['Admin', 'Empleado'])) {
                $u->syncRoles([$u->rol]);
            }
        }

        $usuarios->appends($request->all());

        return view('usuarios::index', compact('usuarios'));
    }

    public function create()
    {
        $organizaciones = Organizacion::select('id','nombre')->get();
        $roles = Role::pluck('name');
        return view('usuarios::create', compact('organizaciones','roles'));
    }

    public function store(UsuarioRequest $request)
    {
        $user = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'activo' => $request->activo,
            'organizacion_id' => $request->organizacion_id,
            'rol' => $request->rol, // importante para BD
        ]);

        // 🔥 Spatie role
        $user->assignRole($request->rol);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('organizacion','roles');
        return view('usuarios::show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $organizaciones = Organizacion::select('id','nombre')->get();
        $roles = Role::pluck('name');

        return view('usuarios::edit', compact('usuario','organizaciones','roles'));
    }

    public function update(UsuarioRequest $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'activo' => $request->activo,
            'organizacion_id' => $request->organizacion_id,
            'rol' => $request->rol, // mantener columna actualizada
        ]);

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
        }

        // 🔥 sincronizar rol Spatie
        $usuario->syncRoles([$request->rol]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Protección
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puede eliminar el usuario con sesión activa.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
