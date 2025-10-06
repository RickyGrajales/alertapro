@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Reprogramación</h2>

    <form action="{{ route('reprogramaciones.update', $reprogramacion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Motivo</label>
            <textarea name="motivo" class="form-control" required>{{ $reprogramacion->motivo }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Nueva fecha</label>
            <input type="date" name="nueva_fecha" class="form-control" value="{{ $reprogramacion->nueva_fecha }}" required>
        </div>

        <button class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
