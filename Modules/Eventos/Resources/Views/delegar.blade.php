<x-app-layout>
<div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-2xl font-bold mb-4">👤 Delegar evento: {{ $evento->titulo }}</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('eventos.delegar', $evento->id) }}">
        @csrf

        <div class="mb-4">
            <label for="nuevo_responsable_id" class="block font-semibold text-gray-700">
                Delegar a *
            </label>
            <select name="nuevo_responsable_id" id="nuevo_responsable_id" required class="w-full border p-2 rounded">
                <option value="">-- Seleccione usuario --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}">{{ $u->nombre }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="motivo" class="block font-semibold text-gray-700">
                Motivo de la delegación *
            </label>
            <textarea name="motivo" id="motivo" rows="4" required
                      class="w-full border p-2 rounded"
                      placeholder="Explica brevemente el motivo...">{{ old('motivo') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('eventos.index') }}" class="px-4 py-2 bg-gray-400 rounded">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Delegar Evento</button>
        </div>
    </form>
</div>
</x-app-layout>
