<?php

namespace Modules\Usuarios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usuarios\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Admin')->except(['index', 'show']);
    }


    public function index(Request $request)
{
    $query = Usuario::with('organizacion');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('nombre', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('rol', 'like', "%{$search}%")
              ->orWhereHas('organizacion', function ($q) use ($search) {
                  $q->where('nombre', 'like', "%{$search}%");
              });
    }

    $usuarios = $query->orderBy('id', 'desc')->paginate(10);

    return view('usuarios::index', compact('usuarios'));
}


    public function create()
    {
        return view('usuarios::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:Admin,Empleado',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => $request->activo ?? true,
            'organizacion_id' => $request->organizacion_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios::edit', compact('usuario'));
    }

    public function show(Usuario $usuario)
    {

        return view('usuarios::show', compact('usuario'));

    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'rol' => 'required|in:Admin,Empleado',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->activo = $request->activo ?? true;
        $usuario->organizacion_id = $request->organizacion_id;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
