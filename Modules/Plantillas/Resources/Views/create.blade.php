@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">➕ Crear Plantilla</h2>

    <form method="POST" action="{{ route('plantillas.store') }}">
        @csrf

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
            <input type="text" name="nombre" class="w-full border p-2 rounded" required>
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" class="w-full border p-2 rounded"></textarea>
        </div>

        <!-- Recurrencia -->
        <div class="mb-4">
            <label class="block font-semibold">Recurrencia</label>
            <select name="recurrencia" class="w-full border p-2 rounded">
                <option value="mensual">Mensual</option>
                <option value="trimestral">Trimestral</option>
                <option value="anual">Anual</option>
            </select>
        </div>

        <!-- Activa -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="activo" value="1" checked class="mr-2">
                Activa
            </label>
        </div>

        <!-- Ítems -->
        <h3 class="font-semibold mb-2">📋 Ítems</h3>
        <div id="items-container"></div>
        <button type="button" onclick="addItem()" class="mt-2 bg-green-600 text-black px-4 py-2 rounded">+ Ítem</button>

        <!-- Reglas -->
        <h3 class="font-semibold mt-6 mb-2">🔔 Reglas de Notificación</h3>
        <div id="rules-container"></div>
        <button type="button" onclick="addRule()" class="mt-2 bg-blue-600 text-black px-4 py-2 rounded">+ Regla</button>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('plantillas.index') }}" class="bg-gray-400 text-black px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">Guardar Plantilla</button>
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

function addItem() {
    document.getElementById('items-container').appendChild(createItemRow());
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


            <input name="rules[${idx}][mensaje]" placeholder="Mensaje" class="w-full border p-2 rounded" value="${data.mensaje||''}">
        </div>
        <button type="button" class="text-red-600 remove-btn">❌</button>`;
    div.querySelector('.remove-btn').onclick = () => div.remove();
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
