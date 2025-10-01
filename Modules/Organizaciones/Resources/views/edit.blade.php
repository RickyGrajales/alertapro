<x-app-layout> 
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">Editar Organización</h1>

            <form action="{{ route('organizaciones.update', $organizacion) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input name="nombre" required 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('nombre', $organizacion->nombre) }}">
                </div>

                <div>
                    <label class="block text-gray-700">NIT</label>
                    <input name="nit" required 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('nit', $organizacion->nit) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Tipo</label>
                    <input name="tipo" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('tipo', $organizacion->tipo) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Representante</label>
                    <input name="representante" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('representante', $organizacion->representante) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Email</label>
                    <input name="email" type="email" required 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('email', $organizacion->email) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Teléfono</label>
                    <input name="telefono" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('telefono', $organizacion->telefono) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Dirección</label>
                    <input name="direccion" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('direccion', $organizacion->direccion) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Ciudad</label>
                    <input name="ciudad" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('ciudad', $organizacion->ciudad) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Departamento</label>
                    <input name="departamento" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('departamento', $organizacion->departamento) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Página Web</label>
                    <input name="pagina_web" 
                           class="w-full border-gray-300 rounded p-2" 
                           value="{{ old('pagina_web', $organizacion->pagina_web) }}">
                </div>

                <div>
                    <label class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full border-gray-300 rounded p-2">{{ old('descripcion', $organizacion->descripcion) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700">Logo</label>
                    @if($organizacion->logo)
                        <img src="{{ asset('storage/' . $organizacion->logo) }}" 
                             alt="Logo actual" class="h-16 mb-2">
                    @endif
                    <input type="file" name="logo" accept="image/*" 
                           class="w-full border-gray-300 rounded p-2">
                </div>

                <div>
                    <label class="block text-gray-700">Estado</label>
                    <select name="activo" class="w-full border-gray-300 rounded p-2">
                        <option value="1" {{ $organizacion->activo ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$organizacion->activo ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button class="bg-blue-600 text-black px-4 py-2 rounded">Actualizar</button>
                    <a href="{{ route('organizaciones.index') }}" 
                       class="bg-gray-600 text-black px-4 py-2 rounded">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
