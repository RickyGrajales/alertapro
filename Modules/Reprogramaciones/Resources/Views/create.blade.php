@extends('layouts.app')

@section('title', '🔁 Reprogramar Evento')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🔁 Reprogramar Evento</h1>

    {{-- Mensajes de validación --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Información del evento actual --}}
    <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <h2 class="text-lg font-semibold text-blue-700">{{ $evento->titulo }}</h2>
        <p class="text-gray-600 mt-1"><strong>Fecha actual:</strong> {{ $evento->due_date->format('d/m/Y') }}</p>
        <p class="text-gray-600"><strong>Responsable:</strong> {{ $evento->responsable->nombre ?? 'Sin asignar' }}</p>
    </div>

    {{-- Formulario de reprogramación --}}
    <form action="{{ route('reprogramaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <input type="hidden" name="evento_id" value="{{ $evento->id }}">

        {{-- Motivo --}}
        <div>
            <label for="motivo" class="block text-gray-700 font-semibold mb-2">
                Motivo de la reprogramación <span class="text-red-500">*</span>
            </label>
            <textarea name="motivo" id="motivo" rows="4" required
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Explica brevemente por qué se reprograma el evento...">{{ old('motivo') }}</textarea>
        </div>

        {{-- Nueva Fecha --}}
        <div>
            <label for="nueva_fecha" class="block text-gray-700 font-semibold mb-2">
                Nueva fecha <span class="text-red-500">*</span>
            </label>
            <input type="date" name="nueva_fecha" id="nueva_fecha"
                   value="{{ old('nueva_fecha') }}"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        {{-- Evidencia opcional --}}
        <div>
            <label for="evidencia" class="block text-gray-700 font-semibold mb-2">
                Evidencia (opcional)
            </label>
            <input type="file" name="evidencia" id="evidencia"
                   accept=".jpg,.jpeg,.png,.pdf"
                   class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-gray-500 text-sm mt-1">Formatos permitidos: JPG, PNG, PDF (máx. 2MB)</p>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                💾 Guardar Reprogramación
            </button>

            <a href="{{ route('eventos.index') }}"
               class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition">
                ↩️ Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
