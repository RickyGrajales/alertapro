<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-blue-700">✏️ Editar Organización</h1>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('organizaciones.update', $organizacion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('organizaciones::partials.form')

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('organizaciones.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
