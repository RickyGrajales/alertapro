<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-white-600 mb-6">Crear Usuario</h1>

            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif


                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Contraseña</label>
                    <input type="password" name="password" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Rol</label>
                    <select name="rol" required class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="Empleado">Empleado</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Organización</label>
                    <input type="number" name="organizacion_id" 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">
                        Guardar
                    </button>
                    <a href="{{ route('usuarios.index') }}" 
                       class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
