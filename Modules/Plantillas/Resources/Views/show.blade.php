@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $template->nombre }}</h1>
        <a href="{{ route('plantillas.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded">Volver</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <p class="mb-4 text-gray-700">{{ $template->descripcion }}</p>

        <h3 class="font-semibold mt-4">Ítems</h3>
        <ul class="mb-4">
            @foreach($template->items as $item)
                <li class="py-1">• {{ $item->titulo }} @if($item->requerido) <span class="text-red-500">(obligatorio)</span> @endif</li>
            @endforeach
        </ul>

        <h3 class="font-semibold mt-4">Reglas de Notificación</h3>
        <ul>
            @foreach($template->rules as $r)
                <li class="py-1">• {{ $r->canal }} — {{ $r->momento }} {{ $r->offset_days }} días @if($r->hora) a las {{ $r->hora }} @endif</li>
            @endforeach
        </ul>

        <h3 class="font-semibold mt-4">Organizaciones asignadas</h3>
        <ul>
            @foreach($template->organizaciones as $org)
                <li class="py-1">• {{ $org->nombre }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
