@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="Empleado">Empleado</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="activo" class="form-label">Activo</label>
            <select name="activo" id="activo" class="form-select">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="organizacion_id" class="form-label">Organización</label>
            <input type="number" name="organizacion_id" id="organizacion_id" class="form-control">
            <small class="form-text text-muted">Ingresa el ID de la organización (por ahora manual).</small>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
