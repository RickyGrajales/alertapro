{{-- Modules/Organizaciones/Resources/views/partials/form-fields.blade.php --}}
@php
    // Si la vista es "create" no existirá $organizacion
    $o = $organizacion ?? null;
@endphp

<div class="grid grid-cols-1 gap-4">
    {{-- Nombre --}}
    <div>
        <label class="block text-gray-700 font-semibold">Nombre *</label>
        <input name="nombre" required
               class="w-full border-gray-300 rounded p-2"
               value="{{ old('nombre', $o->nombre ?? '') }}">
    </div>

    {{-- NIT y Tipo --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-semibold">NIT *</label>
            <input name="nit" required
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('nit', $o->nit ?? '') }}">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Tipo</label>
            <input name="tipo"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('tipo', $o->tipo ?? '') }}">
        </div>
    </div>

    {{-- Representante y Email --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-semibold">Representante</label>
            <input name="representante"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('representante', $o->representante ?? '') }}">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Email</label>
            <input name="email" type="email"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('email', $o->email ?? '') }}">
        </div>
    </div>

    {{-- Teléfono y Página web --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-semibold">Teléfono</label>
            <input name="telefono"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('telefono', $o->telefono ?? '') }}">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Página web</label>
            <input name="pagina_web"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('pagina_web', $o->pagina_web ?? '') }}">
        </div>
    </div>

    {{-- Dirección, Ciudad y Departamento --}}
    <div>
        <label class="block text-gray-700 font-semibold">Dirección</label>
        <input name="direccion"
               class="w-full border-gray-300 rounded p-2"
               value="{{ old('direccion', $o->direccion ?? '') }}">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-semibold">Ciudad</label>
            <input name="ciudad"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('ciudad', $o->ciudad ?? '') }}">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Departamento</label>
            <input name="departamento"
                   class="w-full border-gray-300 rounded p-2"
                   value="{{ old('departamento', $o->departamento ?? '') }}">
        </div>
    </div>

    {{-- Descripción --}}
    <div>
        <label class="block text-gray-700 font-semibold">Descripción</label>
        <textarea name="descripcion" rows="4"
                  class="w-full border-gray-300 rounded p-2">{{ old('descripcion', $o->descripcion ?? '') }}</textarea>
    </div>

    {{-- Activo --}}
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="activo" value="1"
               {{ old('activo', isset($o) ? $o->activo : true) ? 'checked' : '' }}>
        <label class="text-gray-700">Activo</label>
    </div>

    {{-- Logo --}}
    <div>
        <label class="block text-gray-700 font-semibold">Logo (JPG, PNG, máx. 2MB)</label>
        <input type="file" name="logo" accept="image/*" class="w-full border-gray-300 rounded p-2">

        @if(isset($o) && $o->logo)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$o->logo) }}" alt="Logo de {{ $o->nombre }}" class="h-20 object-contain border rounded">
            </div>
        @endif
    </div>

    {{-- Plantillas --}}
    <div>
        <label class="block text-gray-700 font-semibold">Plantillas asociadas</label>
        <select name="templates[]" multiple
                class="w-full border-gray-300 rounded p-2">
            @foreach($templates as $template)
                @php
                    $selectedTemplates = old('templates', isset($o) && $o->templates ? $o->templates->pluck('id')->toArray() : []);
            @endphp
            <option value="{{ $template->id }}" {{ in_array($template->id, $selectedTemplates) ? 'selected' : '' }}>
                    {{ $template->nombre }}
            </option>

            @endforeach
        </select>
        <p class="text-sm text-gray-500">Selecciona una o varias plantillas asociadas a esta organización.</p>
    </div>
</div>
