<x-app-layout>
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📋 Detalle del Evento</h2>
        <a href="{{ route('eventos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ⬅ Volver
        </a>
    </div>

    {{-- =========================================
    🧾 INFORMACIÓN PRINCIPAL DEL EVENTO
    ========================================== --}}
    <div class="bg-white shadow rounded p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="font-semibold text-gray-700">Título:</p>
                <p>{{ $evento->titulo }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Responsable:</p>
                <p>{{ $evento->responsable->nombre ?? 'Sin asignar' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Fecha límite:</p>
                <p>{{ $evento->due_date ? $evento->due_date->format('d/m/Y') : 'No definida' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Estado:</p>
                <span class="px-2 py-1 text-sm rounded
                    @if($evento->estado == 'Completado') bg-green-100 text-green-700
                    @elseif($evento->estado == 'En Proceso') bg-yellow-100 text-yellow-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ $evento->estado }}
                </span>
            </div>
        </div>

        @if(!empty($evento->descripcion))
            <div class="mt-6">
                <p class="font-semibold text-gray-700">Descripción:</p>
                <p class="text-gray-800">{{ $evento->descripcion }}</p>
            </div>
        @endif

        {{-- =========================================
        📋 CHECKLIST DESDE PLANTILLA
        ========================================== --}}
        @if($evento->plantilla && $evento->plantilla->items->count())
            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-3">
                    Checklist generado ({{ $evento->plantilla->nombre }})
                </h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-2 border border-gray-300">#</th>
                            <th class="p-2 border border-gray-300">Ítem</th>
                            <th class="p-2 border border-gray-300">Descripción</th>
                            <th class="p-2 border border-gray-300">Obligatorio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evento->plantilla->items as $i => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2">{{ $i + 1 }}</td>
                                <td class="border p-2">{{ $item->nombre }}</td>
                                <td class="border p-2">{{ $item->descripcion ?? '-' }}</td>
                                <td class="border p-2">{{ $item->obligatorio ? '✔ Sí' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- =========================================
    📎 DOCUMENTOS ASOCIADOS AL EVENTO
    ========================================== --}}
    <div class="mt-8 bg-white shadow rounded p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-paperclip text-blue-600"></i> Documentos del evento
        </h3>

        {{-- Subir nuevo documento (solo Admin o responsable) --}}
        @if(auth()->user()->hasRole('Admin') || auth()->id() === $evento->responsable_id)
            <form method="POST" action="{{ route('documentos.store', $evento->id) }}" 
                  enctype="multipart/form-data" class="mb-6">
                @csrf
                <label class="block mb-2 font-semibold">Subir archivo (PDF, DOC, XLS, JPG, PNG):</label>
                <input type="file" name="archivo" class="w-full border rounded p-2 mb-3" required>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    📤 Subir
                </button>
            </form>
        @endif

        {{-- Lista de documentos --}}
        @if(isset($evento->documentos) && $evento->documentos->count() > 0)
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nombre</th>
                        <th class="p-2 text-left">Usuario</th>
                        <th class="p-2 text-left">Tipo</th>
                        <th class="p-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evento->documentos as $doc)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2">{{ $doc->nombre }}</td>
                            <td class="p-2">{{ $doc->usuario->nombre ?? '-' }}</td>
                            <td class="p-2">{{ $doc->tipo ?? 'N/A' }}</td>
                            <td class="p-2 flex gap-2">
                                <a href="{{ route('documentos.download', $doc->id) }}" 
                                   class="text-blue-600 hover:underline">⬇️ Descargar</a>
                                @if(auth()->user()->hasRole('Admin') || auth()->id() === $doc->user_id)
                                    <form action="{{ route('documentos.destroy', $doc->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('¿Eliminar este documento?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">🗑 Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">No hay documentos asociados a este evento.</p>
        @endif
    </div>
</div>
</x-app-layout>

