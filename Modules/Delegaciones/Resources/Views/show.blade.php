@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Delegación #{{ $delegacion->id }}</h2>

    <div class="bg-white p-4 shadow rounded">
        <p><strong>Evento:</strong> {{ $delegacion->evento->titulo }}</p>
        <p><strong>De:</strong> {{ $delegacion->de->nombre ?? '—' }}</p>
        <p><strong>A:</strong> {{ $delegacion->para->nombre ?? '—' }}</p>
        <p><strong>Motivo:</strong> {{ $delegacion->motivo }}</p>
        <p><strong>Fecha:</strong> {{ $delegacion->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>
@endsection
