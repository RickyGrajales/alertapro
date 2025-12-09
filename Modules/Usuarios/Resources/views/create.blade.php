<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Crear Usuario</h1>

            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Errores --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Nombre --}}
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Correo --}}
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="+573001234567">
                </div>

                {{-- Contraseña --}}
                <div>
                    <label class="block text-gray-700">Contraseña</label>
                    <input type="password" name="password" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Confirmación --}}
                <div>
                    <label class="block text-gray-700">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                {{-- Rol --}}
                <div>
                    <label class="block text-gray-700">Rol</label>
                    <select name="rol" required class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="Empleado">Empleado</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>



                {{-- Estado --}}
                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1" @selected(old('activo') == 1)>Sí</option>
                        <option value="0" @selected(old('activo') == 0)>No</option>
                    </select>
                </div>

                {{-- Organización --}}
                <div>
                    <label class="block text-gray-700">Organización</label>
                    <select name="organizacion_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="">-- Sin organización --</option>

                        @foreach($organizaciones as $org)
                            <option value="{{ $org->id }}" @selected(old('organizacion_id') == $org->id)>
                                {{ $org->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botones --}}
                <div class="flex space-x-4">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Guardar
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
