<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 space-y-8">

        <!-- ======= RESUMEN GENERAL ======= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Eventos -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm uppercase font-semibold">Eventos Activos</h3>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $eventosActivos ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('eventos.index') }}" class="text-blue-600 text-sm mt-4 inline-block hover:underline">
                    Ver detalles →
                </a>
            </div>

            <!-- Usuarios -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm uppercase font-semibold">Usuarios Registrados</h3>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ $usuarios ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('usuarios.index') }}" class="text-green-600 text-sm mt-4 inline-block hover:underline">
                    Ver usuarios →
                </a>
            </div>

            <!-- Organizaciones -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm uppercase font-semibold">Organizaciones</h3>
                        <p class="text-3xl font-bold text-purple-700 mt-2">{{ $organizaciones ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-building text-purple-600 text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('organizaciones.index') }}" class="text-purple-600 text-sm mt-4 inline-block hover:underline">
                    Ver organizaciones →
                </a>
            </div>

            <!-- Notificaciones -->
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm uppercase font-semibold">Notificaciones Enviadas</h3>
                        <p class="text-3xl font-bold text-orange-700 mt-2">{{ $notificaciones ?? 0 }}</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-bell text-orange-600 text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('notificaciones.index') }}" class="text-orange-600 text-sm mt-4 inline-block hover:underline">
                    Ver historial →
                </a>
            </div>
        </div>

        <!-- ======= GRÁFICO Y ACTIVIDAD ======= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Gráfico de Eventos -->
            <div class="col-span-2 bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-bold text-gray-800 mb-4">📊 Estadísticas de Eventos</h2>
                <canvas id="graficoEventos" height="100"></canvas>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-bold text-gray-800 mb-4">🕒 Actividad Reciente</h2>

                @if(isset($actividades) && count($actividades) > 0)
                    <ul class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($actividades as $actividad)
                            <li class="border-b pb-2">
                                <p class="text-gray-800 font-semibold">{{ $actividad['usuario'] ?? 'Sistema' }}</p>
                                <p class="text-gray-600 text-sm">{{ $actividad['descripcion'] ?? 'Sin descripción' }}</p>
                                <span class="text-xs text-gray-500">{{ $actividad['fecha'] ?? now()->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">No hay actividad registrada recientemente.</p>
                @endif
            </div>
        </div>

        <!-- ======= ESTADO GENERAL ======= -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📅 Próximos Eventos</h2>
            @if(isset($proximosEventos) && count($proximosEventos) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Título</th>
                                <th class="px-4 py-2 text-left">Responsable</th>
                                <th class="px-4 py-2 text-left">Fecha Límite</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                                <th class="px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proximosEventos as $evento)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium">{{ $evento->titulo }}</td>
                                    <td class="px-4 py-2">{{ $evento->responsable->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $evento->due_date?->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-xs text-white 
                                            @if($evento->estado == 'Pendiente') bg-yellow-500
                                            @elseif($evento->estado == 'Completado') bg-green-600
                                            @else bg-gray-500 @endif">
                                            {{ $evento->estado }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('eventos.show', $evento) }}" class="text-blue-600 hover:underline">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-sm">No hay eventos próximos a vencer.</p>
            @endif
        </div>
    </div>

    <!-- ======= SCRIPT DEL GRÁFICO ======= -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoEventos').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pendientes', 'En Proceso', 'Completados'],
                datasets: [{
                    label: 'Cantidad de eventos',
                    data: [{{ $pendientes ?? 0 }}, {{ $enProceso ?? 0 }}, {{ $completados ?? 0 }}],
                    backgroundColor: ['#facc15', '#3b82f6', '#22c55e'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</x-app-layout>
