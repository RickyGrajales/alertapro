<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📬 Historial de Notificaciones</h2>

        <div class="bg-white p-6 rounded-xl shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 text-left">Evento</th>
                            <th class="p-3 text-left">Usuario</th>
                            <th class="p-3 text-left">Canal</th>
                            <th class="p-3 text-left">Mensaje</th>
                            <th class="p-3 text-left">Fecha de Envío</th>
                            <th class="p-3 text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3">{{ $log->evento->titulo ?? '-' }}</td>
                                <td class="p-3">{{ $log->usuario->nombre ?? '-' }}</td>
                                <td class="p-3 capitalize">{{ $log->canal }}</td>
                                <td class="p-3">{{ Str::limit($log->mensaje, 60) }}</td>
                                <td class="p-3">{{ $log->enviado_en_formatted }}</td>
                                <td class="p-3 text-center">
                                    @if($log->exitoso)
                                        <span class="text-green-600 font-semibold">✅ Enviado</span>
                                    @else
                                        <span class="text-red-600 font-semibold" title="{{ $log->error }}">
                                            ❌ Falló
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">
                                    Sin registros aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación si aplica -->
            @if(method_exists($logs, 'links'))
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
