<form action="{{ isset($plantilla) ? route('plantillas.update', $plantilla) : route('plantillas.store') }}" 
      method="POST">

    @csrf
    @if(isset($plantilla))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- NOMBRE --}}
        <div>
            <label class="font-semibold">Nombre *</label>
            <input type="text" name="nombre" 
                   value="{{ old('nombre', $plantilla->nombre ?? '') }}"
                   class="w-full border rounded p-2" required>
        </div>

        {{-- RECURRENCIA --}}
        <div>
            <label class="font-semibold">Recurrencia *</label>
            <select name="recurrencia" class="w-full border rounded p-2">
                <option value="Diaria"   {{ old('recurrencia', $plantilla->recurrencia ?? '') == 'Diaria' ? 'selected' : '' }}>Diaria</option>
                <option value="Semanal"  {{ old('recurrencia', $plantilla->recurrencia ?? '') == 'Semanal' ? 'selected' : '' }}>Semanal</option>
                <option value="Mensual"  {{ old('recurrencia', $plantilla->recurrencia ?? '') == 'Mensual' ? 'selected' : '' }}>Mensual</option>
            </select>
        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="col-span-1 md:col-span-2">
            <label class="font-semibold">Descripción</label>
            <textarea name="descripcion" rows="3"
                      class="w-full border rounded p-2">{{ old('descripcion', $plantilla->descripcion ?? '') }}</textarea>
        </div>

        {{-- ESTADO --}}
        <div>
            <label class="font-semibold">Activa</label>
            <select name="activa" class="w-full border rounded p-2">
                <option value="1" {{ old('activa', $plantilla->activa ?? 1) == 1 ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('activa', $plantilla->activa ?? 1) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- ORGANIZACIONES --}}
        <div class="col-span-1 md:col-span-2">
            <label class="font-semibold">Organizaciones asociadas</label>
            <select name="organizaciones[]" multiple size="5"
                    class="w-full border rounded p-2">
                @foreach($organizaciones as $org)
                    <option value="{{ $org->id }}"
                        {{ isset($plantilla) && $plantilla->organizaciones->contains($org->id) ? 'selected' : '' }}>
                        {{ $org->nombre }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500">Ctrl + click para seleccionar varias</small>
        </div>

    </div>

    {{-- -------------------------------
         Í T E M S   D I N Á M I C O S
    ----------------------------------}}
    <div class="mt-6">
        <h3 class="font-bold mb-2">Ítems</h3>

        <div id="items-container" class="space-y-2">
            @if(isset($plantilla))
                @foreach($plantilla->items as $index => $item)
                    <div class="flex gap-2 item-row">
                        <input type="text" name="items[]" value="{{ $item->texto }}"
                               class="w-full border rounded p-2" placeholder="Nombre del ítem">
                        <button type="button" class="bg-red-600 text-white px-3 rounded remove-item">X</button>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button" id="add-item" 
                class="mt-2 bg-green-600 text-white px-4 py-1 rounded">
            + Añadir ítem
        </button>
    </div>

    {{-- -------------------------------
         R E G L A S   D I N Á M I C A S
    ----------------------------------}}
    <div class="mt-6">
        <h3 class="font-bold mb-2">Reglas de Notificación</h3>

        <div id="rules-container" class="space-y-2">
            @if(isset($plantilla))
                @foreach($plantilla->rules as $index => $rule)
                    <div class="flex gap-2 rule-row">
                        <input type="text" name="rules[]" 
                               value="{{ $rule->descripcion }}"
                               class="w-full border rounded p-2" placeholder="Ej: Enviar correo si no cumple">
                        <button type="button" class="bg-red-600 text-white px-3 rounded remove-rule">X</button>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button" id="add-rule" 
                class="mt-2 bg-blue-600 text-white px-4 py-1 rounded">
            + Añadir regla
        </button>
    </div>

    <div class="mt-8 flex justify-between">
        <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</a>
        <button class="px-4 py-2 bg-primary text-white rounded">Guardar</button>
    </div>

</form>

{{-- JAVASCRIPT PARA ÍTEMS Y REGLAS --}}
<script>
document.getElementById('add-item').addEventListener('click', function () {
    const container = document.getElementById('items-container');
    container.insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 item-row">
            <input type="text" name="items[]" class="w-full border rounded p-2" placeholder="Nombre del ítem">
            <button type="button" class="bg-red-600 text-white px-3 rounded remove-item">X</button>
        </div>
    `);
});

document.getElementById('items-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-row').remove();
    }
});

document.getElementById('add-rule').addEventListener('click', function () {
    const container = document.getElementById('rules-container');
    container.insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 rule-row">
            <input type="text" name="rules[]" class="w-full border rounded p-2" placeholder="Descripción de la regla">
            <button type="button" class="bg-red-600 text-white px-3 rounded remove-rule">X</button>
        </div>
    `);
});

document.getElementById('rules-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-rule')) {
        e.target.closest('.rule-row').remove();
    }
});
</script>
