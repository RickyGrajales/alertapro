@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reprogramar Evento: {{ $evento->titulo }}</h2>

    <form action="{{ route('reprogramaciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="evento_id" value="{{ $evento->id }}">

        <div class="form-group mb-3">
            <label>Motivo</label>
            <textarea name="motivo" class="form-control" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Nueva fecha</label>
            <input type="date" name="nueva_fecha" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Evidencia (opcional)</label>
            <input type="file" name="evidencia" class="form-control">
        </div>

        <button class="btn btn-primary">Guardar reprogramación</button>
    </form>
</div>
@endsection
