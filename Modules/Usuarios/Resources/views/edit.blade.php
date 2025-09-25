@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Usuario</h1>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="Empleado" @if($usuario->rol == 'Empleado') selected @endif>Empleado</option>
                <option value="Supervisor" @if($usuario->rol == 'Supervisor') selected @endif>Supervisor</option>
                <option value="Admin" @if($usuario->rol == 'Admin') selected @endif>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="activo" class="form-label">Activo</label>
            <select name="activo" id="activo" class="form-select">
                <option value="1" @if($usuario->activo) selected @endif>Sí</option>
                <option value="0" @if(!$usuario->activo) selected @endif>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="organizacion_id" class="form-label">Organización</label>
            <input type="number" name="organizacion_id" id="organizacion_id" class="form-control" value="{{ $usuario->organizacion_id }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
