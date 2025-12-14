<x-app-layout>
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-700">📄 Detalle de la Reprogramación</h1>
        <a href="{{ route('reprogramaciones.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
            ↩️ Volver al listado
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Contenido --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Información del evento --}}
        <div class="border rounded-lg p-4 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">📅 Información del Evento</h2>
            <p><strong>Título:</strong> {{ $reprogramacion->evento->titulo ?? 'Evento eliminado' }}</p>
            <p><strong>Descripción:</strong> {{ $reprogramacion->evento->descripcion ?? 'Sin descripción' }}</p>
            <p><strong>Fecha Anterior:</strong> 
                {{ \Carbon\Carbon::parse($reprogramacion->fecha_anterior)->format('d/m/Y') }}
            </p>
            <p><strong>Nueva Fecha:</strong> 
                <span class="text-blue-700 font-semibold">
                    {{ \Carbon\Carbon::parse($reprogramacion->nueva_fecha)->format('d/m/Y') }}
                </span>
            </p>
            <p><strong>Estado Actual:</strong> 
                {!! $reprogramacion->evento->estadoBadge ?? '<span class="text-gray-500">Desconocido</span>' !!}
            </p>
        </div>

        {{-- Información de la reprogramación --}}
        <div class="border rounded-lg p-4 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">🔁 Detalle de la Reprogramación</h2>
            <p><strong>Motivo:</strong> {{ $reprogramacion->motivo }}</p>
            <p><strong>Registrado por:</strong> {{ $reprogramacion->usuario->nombre ?? 'Usuario desconocido' }}</p>
            <p><strong>Fecha de Registro:</strong> 
                {{ $reprogramacion->created_at->format('d/m/Y H:i') }}
            </p>

            {{-- Evidencia --}}
            <p class="mt-3">
                <strong>Evidencia:</strong>
                @if($reprogramacion->evidencia)
                    <a href="{{ asset('storage/'.$reprogramacion->evidencia) }}" 
                       target="_blank"
                       class="text-blue-600 hover:underline">
                       📎 Ver evidencia adjunta
                    </a>
                @else
                    <span class="text-gray-500 italic">No se adjuntó evidencia</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Botones inferiores --}}
    <div class="flex justify-end space-x-3 mt-8 border-t pt-4">
        <a href="{{ route('reprogramaciones.edit', $reprogramacion->id) }}"
           class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 transition">
           ✏️ Editar
        </a>

        <form action="{{ route('reprogramaciones.destroy', $reprogramacion->id) }}" 
              method="POST" 
              onsubmit="return confirm('¿Desea eliminar esta reprogramación?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition">
                🗑 Eliminar
            </button>
        </form>
    </div>
</div>
</x-app-layout>

