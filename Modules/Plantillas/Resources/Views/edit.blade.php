@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">✏️ Editar Plantilla</h2>

    <form method="POST" action="{{ route('plantillas.update', $plantilla) }}">
        @csrf
        @method('PUT')

        <!-- Mensajes de error -->
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
            <input type="text" name="nombre" class="w-full border p-2 rounded" value="{{ $plantilla->nombre }}" required>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" class="w-full border p-2 rounded">{{ $plantilla->descripcion }}</textarea>
        </div>

        <!-- Recurrencia -->
        <div class="mb-4">
            <label class="block font-semibold">Recurrencia</label>
            <select name="recurrencia" class="w-full border p-2 rounded">
                <option value="mensual" {{ $plantilla->recurrencia=='mensual'?'selected':'' }}>Mensual</option>
                <option value="trimestral" {{ $plantilla->recurrencia=='trimestral'?'selected':'' }}>Trimestral</option>
                <option value="anual" {{ $plantilla->recurrencia=='anual'?'selected':'' }}>Anual</option>
            </select>
        </div>

        <!-- Activa -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" value="1" {{ $plantilla->activo ? 'checked':'' }} class="mr-2">
                Activa
            </label>
        </div>

        <!-- Ítems -->
        <h3 class="font-semibold mb-2">📋 Ítems</h3>
        <div id="items-container">
            @foreach($plantilla->items as $item)
            <div class="p-3 border rounded mb-2">
                <input type="text" name="items[{{ $item->id }}][nombre]" class="w-full border p-2 mb-2 rounded" value="{{ $item->nombre }}">
                <textarea name="items[{{ $item->id }}][descripcion]" class="w-full border p-2 mb-2 rounded">{{ $item->descripcion }}</textarea>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="items[{{ $item->id }}][obligatorio]" value="1" {{ $item->obligatorio?'checked':'' }} class="mr-2"> Obligatorio
                </label>
                <button type="button" class="text-red-600 ml-4 remove-btn" onclick="this.parentElement.remove()">❌</button>
            </div>
            @endforeach
        </div>
        <button type="button" onclick="addItem()" class="mt-2 bg-green-600 text-white px-4 py-2 rounded">+ Ítem</button>

        <!-- Reglas -->
        <h3 class="font-semibold mt-6 mb-2">🔔 Reglas de Notificación</h3>
        <div id="rules-container">
            @foreach($plantilla->rules as $rule)
            <div class="p-3 border rounded flex gap-3 mb-2">
                <div class="flex-1">
                    <select name="rules[{{ $rule->id }}][canal]" class="w-full border p-2 mb-2 rounded">
                        <option value="email" {{ $rule->canal=='email'?'selected':'' }}>Email</option>
                        <option value="whatsapp" {{ $rule->canal=='whatsapp'?'selected':'' }}>WhatsApp</option>
                        <option value="sistema" {{ $rule->canal=='sistema'?'selected':'' }}>Sistema</option>
                    </select>

                    <div class="mb-2">
                        <label class="block font-semibold flex items-center">
                            Días de aviso
                            <span class="ml-2 text-gray-400 cursor-pointer" 
                                  title="Usa negativos para días antes, 0 para mismo día, positivos para después">ℹ️</span>
                        </label>
                        <input type="number" 
                               name="rules[{{ $rule->id }}][offset]" 
                               placeholder="-3 = 3 días antes, 0 = mismo día, 2 = después" 
                               class="w-full border p-2 rounded" 
                               value="{{ $rule->offset }}">
                        <small class="text-gray-500">Ej: -3 = 3 días antes, 0 = mismo día, 2 = después</small>
                    </div>

                    <input name="rules[{{ $rule->id }}][mensaje]" class="w-full border p-2 rounded" value="{{ $rule->mensaje }}">
                </div>
                <button type="button" class="text-red-600 remove-btn" onclick="this.parentElement.remove()">❌</button>
            </div>
            @endforeach
        </div>
        <button type="button" onclick="addRule()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">+ Regla</button>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('plantillas.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar Plantilla</button>
        </div>
    </form>
</div>

<script>
function createItemRow() {
    const idx = Date.now();
    const div = document.createElement('div');
    div.className = "p-3 border rounded mb-2";
    div.innerHTML = `
        <input type="text" name="items[${idx}][nombre]" placeholder="Nombre del ítem" class="w-full border p-2 mb-2 rounded">
        <textarea name="items[${idx}][descripcion]" placeholder="Descripción" class="w-full border p-2 mb-2 rounded"></textarea>
        <label class="inline-flex items-center">
            <input type="checkbox" name="items[${idx}][obligatorio]" value="1" class="mr-2"> Obligatorio
        </label>
        <button type="button" class="text-red-600 ml-4 remove-btn" onclick="this.parentElement.remove()">❌</button>`;
    return div;
}

function addItem() {
    document.getElementById('items-container').appendChild(createItemRow());
}

function createRuleRow() {
    const idx = Date.now();
    const div = document.createElement('div');
    div.className = "p-3 border rounded flex gap-3 mb-2";
    div.innerHTML = `
        <div class="flex-1">
            <select name="rules[${idx}][canal]" class="w-full border p-2 mb-2 rounded">
                <option value="email">Email</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="sistema">Sistema</option>
            </select>

            <div class="mb-2">
    <label class="block font-semibold flex items-center">
        Días de aviso
        <span class="ml-2 text-gray-400 cursor-pointer" 
              title="Usa negativos para días antes, 0 = mismo día, positivos = después">ℹ️</span>
    </label>
    <input type="number" 
           name="rules[${idx}][offset]" 
           placeholder="-3 = 3 días antes, 0 = mismo día, 2 = después" 
           class="w-full border p-2 rounded" 
           min="-30" max="30" required>
    <small class="text-gray-500">Ej: -3 = 3 días antes, 0 = mismo día, 2 = después</small>
</div>


            <input name="rules[${idx}][mensaje]" placeholder="Mensaje" class="w-full border p-2 rounded">
        </div>
        <button type="button" class="text-red-600 remove-btn" onclick="this.parentElement.remove()">❌</button>`;
    return div;
}

function addRule() {
    document.getElementById('rules-container').appendChild(createRuleRow());
}

// Validación en vivo de offset
document.addEventListener('input', function(e) {
    if (e.target.matches('input[name*="[offset]"]')) {
        const value = parseInt(e.target.value, 10);
        let errorSpan = e.target.parentElement.querySelector('.error-span');

        if (value < -30 || value > 30 || isNaN(value)) {
            if (!errorSpan) {
                errorSpan = document.createElement('span');
                errorSpan.className = 'error-span text-red-600 text-sm';
                e.target.parentElement.appendChild(errorSpan);
            }
            errorSpan.innerText = "El valor debe estar entre -30 y 30.";
            e.target.classList.add("border-red-500");
        } else {
            if (errorSpan) errorSpan.remove();
            e.target.classList.remove("border-red-500");
        }
    }
});

</script>
@endsection
