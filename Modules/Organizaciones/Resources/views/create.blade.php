<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Crear Organización</h1>

            <form action="{{ route('organizaciones.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" required class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">NIT</label>
                    <input type="text" name="nit" required class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Tipo</label>
                    <select name="tipo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="Fundación">Fundación</option>
                        <option value="Colegio">Colegio</option>
                        <option value="Universidad">Universidad</option>
                        <option value="ONG">ONG</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" required class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Ciudad</label>
                    <input type="text" name="ciudad" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Departamento</label>
                    <input type="text" name="departamento" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">
                        Guardar
                    </button>
                    <a href="{{ route('organizaciones.index') }}" class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
