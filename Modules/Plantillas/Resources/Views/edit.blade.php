{{-- Modules/Plantillas/Resources/views/edit.blade.php --}}
<x-app-layout>
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Editar Plantilla</h1>

    <form action="{{ route('plantillas.update', $plantilla->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('plantillas::partials.form')

        <div class="mt-4 flex justify-end space-x-2">
            <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
        </div>
    </form>
</div>
</x-app-layout>
