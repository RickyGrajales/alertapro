@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Historial de Reprogramaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Evento</th>
                <th>Usuario</th>
                <th>Fecha anterior</th>
                <th>Nueva fecha</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reprogramaciones as $rep)
            <tr>
                <td>{{ $rep->evento->titulo ?? '—' }}</td>
                <td>{{ $rep->usuario->name ?? '—' }}</td>
                <td>{{ $rep->fecha_anterior }}</td>
                <td>{{ $rep->nueva_fecha }}</td>
                <td>{{ $rep->motivo }}</td>
                <td>
                    <a href="{{ route('reprogramaciones.show', $rep->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('reprogramaciones.edit', $rep->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('reprogramaciones.destroy', $rep->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar reprogramación?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
