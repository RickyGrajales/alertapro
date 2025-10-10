@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">✏️ Editar Plantilla</h2>

    <form method="POST" action="{{ route('plantillas.update', $plantilla->id) }}">
        @csrf
        @method('PUT')

        <!-- Errores -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>⚠️ Se encontraron errores:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Nombre -->
        <div class="mb-4">
            <label class="block font-semibold">Nombre *</label>
            <input type="text" name="nombre" class="w-full border p-2 rounded" 
                   value="{{ old('nombre', $plantilla->nombre) }}" required>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" class="w-full border p-2 rounded">{{ old('descripcion', $plantilla->descripcion) }}</textarea>
        </div>

        <!-- Recurrencia -->
        <div class="mb-4">
            <label class="block font-semibold">Recurrencia</label>
            <select name="recurrencia" class="w-full border p-2 rounded">
                @foreach(['diaria','semanal','mensual','trimestral','anual'] as $r)
                    <option value="{{ $r }}" {{ old('recurrencia', $plantilla->recurrencia) == $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Activa -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" value="1" {{ $plantilla->activo ? 'checked' : '' }} class="mr-2">
                Activa
            </label>
        </div>

        <!-- Ítems -->
        <h3 class="font-semibold mb-2">📋 Ítems</h3>
        <div id="items-container">
            @foreach($plantilla->items as $item)
                <script>window.initialItems = window.initialItems || [];</script>
                <script>
                    window.initialItems.push(@json($item));
                </script>
            @endforeach
        </div>
        <button type="button" onclick="addItem()" class="mt-2 bg-green-600 text-black px-4 py-2 rounded">+ Ítem</button>

        <!-- Reglas -->
        <h3 class="font-semibold mt-6 mb-2">🔔 Reglas de Notificación</h3>
        <div id="rules-container">
            @foreach($plantilla->rules as $rule)
                <script>window.initialRules = window.initialRules || [];</script>
                <script>
                    window.initialRules.push(@json($rule));
                </script>
            @endforeach
        </div>
        <button type="button" onclick="addRule()" class="mt-2 bg-blue-600 text-black px-4 py-2 rounded">+ Regla</button>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('plantillas.index') }}" class="bg-gray-400 text-black px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">Actualizar Plantilla</button>
        </div>
    </form>
</div>

<script>
function createItemRow(data = {}) {
    const idx = Date.now();
    const div = document.createElement('div');
    div.className = "p-3 border rounded mb-2";
    div.innerHTML = `
        <input type="text" name="items[${idx}][nombre]" placeholder="Nombre del ítem" class="w-full border p-2 mb-2 rounded" value="${data.nombre||''}">
        <textarea name="items[${idx}][descripcion]" placeholder="Descripción" class="w-full border p-2 mb-2 rounded">${data.descripcion||''}</textarea>
        <label class="inline-flex items-center">
            <input type="checkbox" name="items[${idx}][obligatorio]" value="1" ${data.obligatorio?'checked':''} class="mr-2"> Obligatorio
        </label>
        <button type="button" class="text-red-600 ml-4 remove-btn">❌</button>`;
    div.querySelector('.remove-btn').onclick = () => div.remove();
    return div;
}

function createRuleRow(data = {}) {
    const idx = Date.now();
    const div = document.createElement('div');
    div.className = "p-3 border rounded flex gap-3 mb-2";
    div.innerHTML = `
        <div class="flex-1">
            <select name="rules[${idx}][canal]" class="w-full border p-2 mb-2 rounded">
                <option value="email" ${data.canal==='email'?'selected':''}>Email</option>
                <option value="whatsapp" ${data.canal==='whatsapp'?'selected':''}>WhatsApp</option>
                <option value="sistema" ${data.canal==='sistema'?'selected':''}>Sistema</option>
            </select>
            <input type="number" name="rules[${idx}][offset]" placeholder="Días de aviso" class="w-full border p-2 rounded mb-2" value="${data.offset||0}" min="-30" max="30">
            <input name="rules[${idx}][mensaje]" placeholder="Mensaje" class="w-full border p-2 rounded" value="${data.mensaje||''}">
        </div>
        <button type="button" class="text-red-600 remove-btn">❌</button>`;
    div.querySelector('.remove-btn').onclick = () => div.remove();
    return div;
}

function addItem() { document.getElementById('items-container').appendChild(createItemRow()); }
function addRule() { document.getElementById('rules-container').appendChild(createRuleRow()); }

// Rellenar con datos existentes
window.addEventListener('DOMContentLoaded', () => {
    (window.initialItems || []).forEach(item => document.getElementById('items-container').appendChild(createItemRow(item)));
    (window.initialRules || []).forEach(rule => document.getElementById('rules-container').appendChild(createRuleRow(rule)));
});
</script>
@endsection
