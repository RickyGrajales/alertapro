<x-app-layout>
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">📜 Historial de Delegaciones</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Evento</th>
                <th class="p-3">De</th>
                <th class="p-3">A</th>
                <th class="p-3">Motivo</th>
                <th class="p-3">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($delegaciones as $d)
            <tr class="border-b">
                <td class="p-3">{{ $d->id }}</td>
                <td class="p-3">{{ $d->evento->titulo }}</td>
                <td class="p-3">{{ $d->de->nombre ?? '—' }}</td>
                <td class="p-3">{{ $d->para->nombre ?? '—' }}</td>
                <td class="p-3">{{ Str::limit($d->motivo, 60) }}</td>
                <td class="p-3">{{ $d->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-app-layout>

