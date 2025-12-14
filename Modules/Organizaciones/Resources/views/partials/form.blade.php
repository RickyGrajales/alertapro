<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- NOMBRE --}}
    <div>
        <label class="font-semibold">Nombre *</label>
        <input type="text" name="nombre"
               value="{{ old('nombre', $organizacion->nombre ?? '') }}"
               class="w-full border rounded p-2" required>
    </div>

    {{-- NIT --}}
    <div>
        <label class="font-semibold">NIT *</label>
        <input type="text" name="nit"
               value="{{ old('nit', $organizacion->nit ?? '') }}"
               class="w-full border rounded p-2" required>
    </div>

    {{-- TIPO --}}
    <div>
        <label class="font-semibold">Tipo *</label>
        <select name="tipo" class="w-full border rounded p-2">
            @foreach(['Fundación','Colegio','Universidad','ONG','Otro'] as $tipo)
                <option value="{{ $tipo }}"
                    {{ old('tipo', $organizacion->tipo ?? '') == $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- REPRESENTANTE --}}
    <div>
        <label class="font-semibold">Representante</label>
        <input type="text" name="representante"
               value="{{ old('representante', $organizacion->representante ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="font-semibold">Correo electrónico *</label>
        <input type="email" name="email"
               value="{{ old('email', $organizacion->email ?? '') }}"
               class="w-full border rounded p-2" required>
    </div>

    {{-- TELÉFONO --}}
    <div>
        <label class="font-semibold">Teléfono</label>
        <input type="text" name="telefono"
               value="{{ old('telefono', $organizacion->telefono ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- DIRECCIÓN --}}
    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Dirección</label>
        <input type="text" name="direccion"
               value="{{ old('direccion', $organizacion->direccion ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- CIUDAD --}}
    <div>
        <label class="font-semibold">Ciudad</label>
        <input type="text" name="ciudad"
               value="{{ old('ciudad', $organizacion->ciudad ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- DEPARTAMENTO --}}
    <div>
        <label class="font-semibold">Departamento</label>
        <input type="text" name="departamento"
               value="{{ old('departamento', $organizacion->departamento ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- PÁGINA WEB --}}
    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Página Web</label>
        <input type="text" name="pagina_web"
               value="{{ old('pagina_web', $organizacion->pagina_web ?? '') }}"
               class="w-full border rounded p-2">
    </div>

    {{-- LOGO --}}
    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Logo (opcional)</label>
        <input type="file" name="logo" accept="image/*"
               class="w-full border rounded p-2">

        @if(isset($organizacion) && $organizacion->logo)
            <img src="{{ asset('storage/'.$organizacion->logo) }}"
                 class="h-20 mt-2">
        @endif
    </div>

    {{-- DESCRIPCIÓN --}}
    <div class="col-span-1 md:col-span-2">
        <label class="font-semibold">Descripción</label>
        <textarea name="descripcion" rows="3"
                  class="w-full border rounded p-2">{{ old('descripcion', $organizacion->descripcion ?? '') }}</textarea>
    </div>

    {{-- ACTIVO --}}
    <div>
        <label class="font-semibold">Activa</label>
        <select name="activo" class="w-full border rounded p-2">
            <option value="1" {{ old('activo', $organizacion->activo ?? 1)==1 ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ old('activo', $organizacion->activo ?? 1)==0 ? 'selected' : '' }}>No</option>
        </select>
    </div>

</div>
