@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-2xl font-bold mb-4">📁 Documentos del Evento: {{ $evento->titulo }}</h2>

    <!-- Subir nuevo documento -->
    <form method="POST" action="{{ route('documentos.store', $evento->id) }}" enctype="multipart/form-data" class="mb-6">
        @csrf
        <label class="block mb-2 font-semibold">Subir archivo (PDF, DOC, XLS, JPG, PNG):</label>
        <input type="file" name="archivo" class="w-full border rounded p-2 mb-3" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Subir</button>
    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif

    @if($documentos->count())
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
                @foreach($documentos as $doc)
                <tr class="border-b">
                    <td class="p-2">{{ $doc->nombre }}</td>
                    <td class="p-2">{{ $doc->usuario->nombre ?? '-' }}</td>
                    <td class="p-2">{{ $doc->tipo }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('documentos.download', $doc->id) }}" class="text-blue-600 hover:underline">⬇️ Descargar</a>
                        @if(auth()->user()->rol === 'Admin' || auth()->id() === $doc->user_id)
                            <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este documento?')">
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
@endsection
