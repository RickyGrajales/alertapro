<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label class="font-semibold">Nombre *</label>
        <input type="text" name="nombre" value="{{ old('nombre', $organizacion->nombre ?? '') }}"
               class="w-full border rounded p-2" required>
    </div>

    <div>
        <label class="font-semibold">NIT *</label>
        <input type="text" name="nit" value="{{ old('nit', $organizacion->nit ?? '') }}"
               class="w-full border rounded p-2" required>
    </div>

    <div>
        <label class="font-semibold">Tipo</label>
        <input type="text" name="tipo" value="{{ old('tipo', $organizacion->tipo ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="font-semibold">Representante</label>
        <input type="text" name="representante" value="{{ old('representante', $organizacion->representante ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="font-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email', $organizacion->email ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="font-semibold">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $organizacion->telefono ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="font-semibold">Ciudad</label>
        <input type="text" name="ciudad" value="{{ old('ciudad', $organizacion->ciudad ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div>
        <label class="font-semibold">Departamento</label>
        <input type="text" name="departamento" value="{{ old('departamento', $organizacion->departamento ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Dirección</label>
        <input type="text" name="direccion" value="{{ old('direccion', $organizacion->direccion ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Página Web</label>
        <input type="text" name="pagina_web" value="{{ old('pagina_web', $organizacion->pagina_web ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Descripción</label>
        <textarea name="descripcion" class="w-full border rounded p-2" rows="3">{{ old('descripcion', $organizacion->descripcion ?? '') }}</textarea>
    </div>

    <div>
        <label class="font-semibold">Activo</label>
        <select name="activo" class="w-full border rounded p-2">
            <option value="1" {{ old('activo', $organizacion->activo ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('activo', $organizacion->activo ?? 1) == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div>
        <label class="font-semibold">Logo</label>
        <input type="file" name="logo" class="w-full border rounded p-2">

        @if(!empty($organizacion->logo))
            <img src="{{ asset('storage/' . $organizacion->logo) }}"
                 class="w-24 h-24 mt-2 rounded shadow">
        @endif
    </div>

    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Plantillas asociadas</label>
        <select name="templates[]" class="w-full border rounded p-2" multiple size="5">
            @foreach($templates as $tpl)
                <option value="{{ $tpl->id }}"
                    {{ isset($organizacion) && $organizacion->templates->contains($tpl->id) ? 'selected' : '' }}>
                    {{ $tpl->nombre }}
                </option>
            @endforeach
        </select>
        <small class="text-gray-500">Ctrl + click para seleccionar varias</small>
    </div>

</div>
