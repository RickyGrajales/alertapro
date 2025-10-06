@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Reprogramación</h2>

    <div class="card p-3">
        <p><strong>Evento:</strong> {{ $reprogramacion->evento->titulo ?? '—' }}</p>
        <p><strong>Usuario:</strong> {{ $reprogramacion->usuario->name ?? '—' }}</p>
        <p><strong>Fecha anterior:</strong> {{ $reprogramacion->fecha_anterior }}</p>
        <p><strong>Nueva fecha:</strong> {{ $reprogramacion->nueva_fecha }}</p>
        <p><strong>Motivo:</strong> {{ $reprogramacion->motivo }}</p>
        @if($reprogramacion->evidencia)
            <p><strong>Evidencia:</strong> <a href="{{ asset('storage/'.$reprogramacion->evidencia) }}" target="_blank">Ver archivo</a></p>
        @endif
    </div>
</div>
@endsection
