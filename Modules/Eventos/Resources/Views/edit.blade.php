<x-app-layout>
<div class="container mx-auto p-6 max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">✏️ Editar Evento</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
            <strong>Corrige los siguientes errores:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('eventos.update', $evento) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Título *</label>
            <input type="text" name="titulo" value="{{ old('titulo', $evento->titulo) }}" required
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" class="w-full border p-2 rounded" rows="3">{{ old('descripcion', $evento->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Fecha de vencimiento *</label>
            <input type="date" name="due_date" value="{{ old('due_date', $evento->due_date->format('Y-m-d')) }}"
                   required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Estado *</label>
            <select name="estado" class="w-full border p-2 rounded">
                @foreach(['Pendiente', 'En Proceso', 'Completado'] as $estado)
                    <option value="{{ $estado }}" {{ $evento->estado == $estado ? 'selected' : '' }}>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Responsable *</label>
            <select name="responsable_id" required class="w-full border p-2 rounded">
                <option value="">-- Seleccione --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}" {{ $evento->responsable_id == $u->id ? 'selected' : '' }}>
                        {{ $u->nombre }} ({{ $u->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Plantilla (opcional)</label>
            <select name="plantilla_id" class="w-full border p-2 rounded">
                <option value="">-- Ninguna --</option>
                @foreach($plantillas as $p)
                    <option value="{{ $p->id }}" {{ $evento->plantilla_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('eventos.index') }}" class="bg-gray-400 text-black px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
        </div>
    </form>
</div>
</x-app-layout>

