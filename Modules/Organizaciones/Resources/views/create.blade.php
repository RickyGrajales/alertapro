<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Crear Organización</h1>

            <form action="{{ route('organizaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                    <label class="block text-gray-700">Tipo</label>
                    <input name="tipo" class="w-full border-gray-300 rounded p-2" value="{{ old('tipo') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Representante</label>
                    <input name="representante" class="w-full border-gray-300 rounded p-2" value="{{ old('representante') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Email</label>
                    <input name="email" type="email" class="w-full border-gray-300 rounded p-2" value="{{ old('email') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input name="telefono" class="w-full border-gray-300 rounded p-2" value="{{ old('telefono') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Dirección</label>
                    <input name="direccion" class="w-full border-gray-300 rounded p-2" value="{{ old('direccion') }}">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Ciudad</label>
                        <input name="ciudad" class="w-full border-gray-300 rounded p-2" value="{{ old('ciudad') }}">
                    </div>
                    <div>
                        <label class="block text-gray-700">Departamento</label>
                        <input name="departamento" class="w-full border-gray-300 rounded p-2" value="{{ old('departamento') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700">Página Web</label>
                    <input name="pagina_web" class="w-full border-gray-300 rounded p-2" value="{{ old('pagina_web') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Logo</label>
                    <input type="file" name="logo" class="w-full border-gray-300 rounded p-2">
                </div>

                <div>
                    <label class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="4" class="w-full border-gray-300 rounded p-2">{{ old('descripcion') }}</textarea>
                </div>

                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="activo" value="1" checked class="mr-2">
                        Activo
                    </label>
                </div>

                <div class="flex space-x-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                    <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
