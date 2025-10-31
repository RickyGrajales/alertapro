@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-2xl font-bold mb-4">📨 Historial de Notificaciones</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <table class="min-w-full border-collapse text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Evento</th>
                <th class="p-3">Usuario</th>
                <th class="p-3">Canal</th>
                <th class="p-3">Mensaje</th>
                <th class="p-3">Fecha Envío</th>
                <th class="p-3">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $log->evento->titulo ?? '-' }}</td>
                    <td class="p-3">{{ $log->usuario->nombre ?? '-' }}</td>
                    <td class="p-3 capitalize">{{ $log->canal }}</td>
                    <td class="p-3">{{ $log->mensaje }}</td>
                    <td class="p-3">{{ $log->enviado_en ? $log->enviado_en->format('d/m/Y H:i') : '-' }}</td>
                    <td class="p-3">
                        @if($log->exitoso)
                            <span class="text-green-600 font-semibold">✅ Enviado</span>
                        @else
                            <span class="text-red-600 font-semibold">❌ Falló</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-gray-500">Sin registros aún.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection
