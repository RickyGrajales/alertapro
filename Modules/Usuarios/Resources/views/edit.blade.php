<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Editar Usuario</h1>

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="+573001234567">
                </div>

                {{-- Rol --}}
                <div>
                    <label class="block text-gray-700">Rol</label>
                    <select name="rol" class="w-full border-gray-300 rounded-lg shadow-sm">
                        @foreach($roles as $rol)
                            <option value="{{ $rol }}" 
                                @selected($usuario->getRoleNames()->contains($rol))>
                                {{ $rol }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Activo --}}
                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1" @selected($usuario->activo == 1)>Sí</option>
                        <option value="0" @selected($usuario->activo == 0)>No</option>
                    </select>
                </div>

                {{-- Organización --}}
                <div>
                    <label class="block text-gray-700">Organización</label>
                    <select name="organizacion_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">-- Sin organización --</option>

                        @foreach($organizaciones as $org)
                            <option value="{{ $org->id }}" 
                                @selected($usuario->organizacion_id == $org->id)>
                                {{ $org->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Contraseña opcional --}}
                <div>
                    <label class="block text-gray-700">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password"
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Botones --}}
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
