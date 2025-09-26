<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Editar Usuario</h1>

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ $usuario->nombre }}" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" value="{{ $usuario->email }}" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Rol</label>
                    <select name="rol" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="Empleado" @selected($usuario->rol === 'Empleado')>Empleado</option>
                        <option value="Supervisor" @selected($usuario->rol === 'Supervisor')>Supervisor</option>
                        <option value="Admin" @selected($usuario->rol === 'Admin')>Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1" @selected($usuario->activo)>Sí</option>
                        <option value="0" @selected(!$usuario->activo)>No</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Organización</label>
                    <input type="number" name="organizacion_id" value="{{ $usuario->organizacion_id }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Actualizar
                    </button>
                    <a href="{{ route('usuarios.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
