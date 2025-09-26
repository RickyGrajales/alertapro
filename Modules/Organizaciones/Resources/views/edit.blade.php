<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Editar Organización</h1>

            <form action="{{ route('organizaciones.update', $organizacion->id) }}" 
                  method="POST" 
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ $organizacion->nombre }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">NIT</label>
                    <input type="text" name="nit" value="{{ $organizacion->nit }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Tipo</label>
                    <select name="tipo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="Fundación" @selected($organizacion->tipo === 'Fundación')>Fundación</option>
                        <option value="Colegio" @selected($organizacion->tipo === 'Colegio')>Colegio</option>
                        <option value="Universidad" @selected($organizacion->tipo === 'Universidad')>Universidad</option>
                        <option value="ONG" @selected($organizacion->tipo === 'ONG')>ONG</option>
                        <option value="Otro" @selected($organizacion->tipo === 'Otro')>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Representante</label>
                    <input type="text" name="representante" value="{{ $organizacion->representante }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="email" name="email" value="{{ $organizacion->email }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="{{ $organizacion->telefono }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Dirección</label>
                    <input type="text" name="direccion" value="{{ $organizacion->direccion }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700">Ciudad</label>
                        <input type="text" name="ciudad" value="{{ $organizacion->ciudad }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-gray-700">Departamento</label>
                        <input type="text" name="departamento" value="{{ $organizacion->departamento }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700">Página Web</label>
                    <input type="text" name="pagina_web" value="{{ $organizacion->pagina_web }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>

                <div>
                    <label class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm">{{ $organizacion->descripcion }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700">Activo</label>
                    <select name="activo" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="1" @selected($organizacion->activo)>Sí</option>
                        <option value="0" @selected(!$organizacion->activo)>No</option>
                    </select>
                </div>

                <div class="flex space-x-4 mt-6">
                    <button type="submit" 
                            class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                        Actualizar
                    </button>
                    <a href="{{ route('organizaciones.index') }}" 
                       class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
