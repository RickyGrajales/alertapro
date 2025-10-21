@extends('layouts.app')

@section('title', '👤 Delegar Evento')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-2xl font-bold mb-4">👤 Delegar evento: {{ $evento->titulo }}</h2>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
            <strong>Se encontraron errores:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de delegación --}}
    <form method="POST" action="{{ route('eventos.delegar', $evento->id) }}">
        @csrf

        {{-- Campo: nuevo responsable --}}
        <div class="mb-4">
            <label for="nuevo_responsable_id" class="block font-semibold text-gray-700">
                Delegar a *
            </label>
            <select name="nuevo_responsable_id" id="nuevo_responsable_id" required
                    class="w-full border p-2 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Seleccione usuario --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}">{{ $u->nombre }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Campo: motivo --}}
        <div class="mb-4">
            <label for="motivo" class="block font-semibold text-gray-700">
                Motivo de la delegación *
            </label>
            <textarea name="motivo" id="motivo" rows="4" required
                      class="w-full border p-2 rounded focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Explica brevemente el motivo de la delegación...">{{ old('motivo') }}</textarea>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('eventos.index') }}" class="px-4 py-2 bg-gray-400 text-black rounded hover:bg-gray-500">
                ↩️ Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                💾 Delegar Evento
            </button>
        </div>
    </form>
</div>
@endsection
