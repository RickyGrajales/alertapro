@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">👤 Delegar evento: {{ $evento->titulo }}</h2>

    <form action="{{ route('delegaciones.store') }}" method="POST">
        @csrf
        <input type="hidden" name="evento_id" value="{{ $evento->id }}">

        <div class="mb-4">
            <label class="block font-semibold">Delegar a *</label>
            <select name="to_user_id" required class="w-full border p-2 rounded">
                <option value="">-- Seleccione usuario --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}">{{ $u->nombre }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Motivo *</label>
            <textarea name="motivo" rows="4" required class="w-full border p-2 rounded">{{ old('motivo') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('eventos.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Delegar</button>
        </div>
    </form>
</div>
@endsection
