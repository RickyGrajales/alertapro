<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">

            <h1 class="text-2xl font-bold mb-4 text-blue-700">➕ Crear Organización</h1>

            <form action="{{ route('organizaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('organizaciones::partials.form')

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('organizaciones.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
