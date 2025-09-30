<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Crear Organización</h1>

            <form action="{{ route('organizaciones.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input name="nombre" required class="w-full border-gray-300 rounded p-2" value="{{ old('nombre') }}">
                </div>

                <div>
                    <label class="block text-gray-700">NIT</label>
                    <input name="nit" required class="w-full border-gray-300 rounded p-2" value="{{ old('nit') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Email</label>
                    <input name="email" type="email" required class="w-full border-gray-300 rounded p-2" value="{{ old('email') }}">
                </div>

                <div class="flex space-x-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                    <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
