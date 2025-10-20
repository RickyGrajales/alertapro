<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">✏️ Editar Reprogramación</h1>

        <form action="{{ route('reprogramaciones.update', $reprogramacion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Evento</label>
                <input type="text" value="{{ $reprogramacion->evento->titulo ?? 'N/A' }}" disabled class="w-full border rounded p-2 bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Motivo *</label>
                <input type="text" name="motivo" value="{{ old('motivo', $reprogramacion->motivo) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-semibold">Nueva fecha *</label>
                <input type="date" name="nueva_fecha" value="{{ old('nueva_fecha', $reprogramacion->nueva_fecha->format('Y-m-d')) }}" required class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-semibold">Evidencia actual</label>
                @if($reprogramacion->evidencia)
                    <a href="{{ asset('storage/'.$reprogramacion->evidencia) }}" target="_blank" class="text-blue-600 underline">Ver evidencia</a>
                @else
                    <p class="text-gray-500">No hay evidencia adjunta.</p>
                @endif
            </div>

            <div class="flex justify-end space-x-3">
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">💾 Actualizar</button>
                <a href="{{ route('reprogramaciones.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">↩️ Volver</a>
            </div>
        </form>
    </div>
</x-app-layout>
