{{-- Modules/Plantillas/Resources/views/create.blade.php --}}
<x-app-layout>
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Crear Plantilla</h1>

    @if ($errors->any())
        <div class="bg-red-100 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('plantillas.store') }}" method="POST">
        @csrf

        @include('plantillas::partials.form')

        <div class="mt-4 flex justify-end space-x-2">
            <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        </div>
    </form>
</div>
</x-app-layout>
