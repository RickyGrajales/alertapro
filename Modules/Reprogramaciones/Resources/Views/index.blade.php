@extends('layouts.app')

@section('title', '🔁 Reprogramaciones')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-8">
    
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-blue-700">🔁 Historial de Reprogramaciones</h1>
        <a href="{{ route('eventos.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
            ↩️ Volver a Eventos
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de Reprogramaciones --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">#</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Evento</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Motivo</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Fecha Anterior</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Nueva Fecha</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Usuario</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Evidencia</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Registrado</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($reprogramaciones as $index => $rep)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-sm font-medium text-gray-800">
                            {{ $rep->evento->titulo ?? 'Evento eliminado' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $rep->motivo }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($rep->fecha_anterior)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-sm text-blue-700 font-semibold">{{ \Carbon\Carbon::parse($rep->nueva_fecha)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $rep->usuario->nombre ?? 'Desconocido' }}</td>

                        {{-- Evidencia --}}
                        <td class="px-4 py-2 text-sm">
                            @if($rep->evidencia)
                                <a href="{{ asset('storage/'.$rep->evidencia) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                   📎 Ver evidencia
                                </a>
                            @else
                                <span class="text-gray-400 italic">Sin evidencia</span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-sm text-gray-600">
                            {{ $rep->created_at->format('d/m/Y H:i') }}
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-2 text-center text-sm">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('reprogramaciones.show', $rep->id) }}"
                                   class="text-blue-600 hover:underline">👁 Ver</a>

                                <a href="{{ route('reprogramaciones.edit', $rep->id) }}"
                                   class="text-yellow-600 hover:underline">✏️ Editar</a>

                                <form action="{{ route('reprogramaciones.destroy', $rep->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar esta reprogramación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">🗑 Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                            No hay reprogramaciones registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
