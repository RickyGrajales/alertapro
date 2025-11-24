{{-- Modules/Plantillas/Resources/views/partials/form.blade.php --}}
@php
    $isEdit = isset($plantilla);
    $model = $plantilla ?? null;
@endphp

<div class="space-y-4">

    {{-- Nombre --}}
    <div>
        <label class="block font-semibold">Nombre</label>
        <input type="text" name="nombre"
               value="{{ old('nombre', $model->nombre ?? '') }}"
               required
               class="w-full border rounded p-2">
    </div>

    {{-- Descripción --}}
    <div>
        <label class="block font-semibold">Descripción</label>
        <textarea name="descripcion"
                  class="w-full border rounded p-2">{{ old('descripcion', $model->descripcion ?? '') }}</textarea>
    </div>

    {{-- Recurrencia --}}
    <div>
        <label class="block font-semibold">Recurrencia</label>
        <select name="recurrencia" class="w-full border rounded p-2">
            @foreach(['Nunca','Diaria','Semanal','Mensual','Anual'] as $r)
                <option value="{{ $r }}"
                        @selected(old('recurrencia', $model->recurrencia ?? 'Nunca') === $r)>
                        {{ $r }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Activa --}}
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="activa" value="1"
                   @checked(old('activa', $model->activa ?? true))>
            <span class="ml-2">Activa</span>
        </label>
    </div>

    {{-- ORGANIZACIONES --}}
    <div>
        <label class="block font-semibold">Organizaciones</label>

        <select name="organizaciones[]" multiple class="w-full border rounded p-2">
            @foreach($organizaciones as $org)
                <option value="{{ $org->id }}"
                        @selected(in_array($org->id, old('organizaciones', $model?->organizaciones->pluck('id')->toArray() ?? [])))>
                    {{ $org->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- ÍTEMS --}}
    <div>
        <label class="block font-semibold">Ítems</label>
        <small class="text-gray-500 block mb-2">Agregar ítems</small>

        <div id="items-container" class="space-y-2">
            @php $oldItems = old('items', $model?->items->toArray() ?? []); @endphp

            @foreach($oldItems as $i => $item)
                <div class="border p-2 rounded">
                    <input type="text" name="items[{{ $i }}][titulo]"
                           value="{{ $item['titulo'] ?? '' }}"
                           placeholder="Título"
                           class="w-full mb-1">

                    <input type="text" name="items[{{ $i }}][tipo]"
                           value="{{ $item['tipo'] ?? 'texto' }}"
                           placeholder="Tipo"
                           class="w-full mb-1">

                    <textarea name="items[{{ $i }}][detalle]"
                              placeholder="Detalle"
                              class="w-full mb-1">{{ $item['detalle'] ?? '' }}</textarea>

                    <label>
                        <input type="checkbox" name="items[{{ $i }}][requerido]"
                               value="1"
                               @checked(!empty($item['requerido']))>
                        Requerido
                    </label>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-item" class="mt-2 px-3 py-1 bg-gray-200 rounded">
            + Añadir ítem
        </button>
    </div>

    {{-- REGLAS --}}
    <div>
        <label class="block font-semibold">Reglas de notificación</label>

        @php $oldRules = old('rules', $model?->notificationRules->toArray() ?? []); @endphp

        <div id="rules-container" class="space-y-2">
            @foreach($oldRules as $i => $rule)
                <div class="border p-2 rounded">
                    <input type="text" name="rules[{{ $i }}][canal]"
                           placeholder="email / whatsapp / sistema"
                           value="{{ $rule['canal'] ?? '' }}"
                           class="w-full mb-1">

                    <input type="number" name="rules[{{ $i }}][offset_days]"
                           value="{{ $rule['offset_days'] ?? 0 }}"
                           placeholder="días"
                           class="w-full mb-1">

                    <select name="rules[{{ $i }}][momento]" class="w-full mb-1">
                        <option value="antes" @selected(($rule['momento'] ?? '') === 'antes')>Antes</option>
                        <option value="despues" @selected(($rule['momento'] ?? '') === 'despues')>Después</option>
                    </select>

                    <input type="time" name="rules[{{ $i }}][hora]"
                           value="{{ $rule['hora'] ?? '' }}"
                           class="w-full mb-1">

                    <textarea name="rules[{{ $i }}][mensaje]"
                              placeholder="Mensaje"
                              class="w-full">{{ $rule['mensaje'] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-rule" class="mt-2 px-3 py-1 bg-gray-200 rounded">
            + Añadir regla
        </button>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let itemIndex = {{ count($oldItems) }};
    let ruleIndex = {{ count($oldRules) }};

    document.getElementById('add-item').addEventListener('click', function () {
        const c = document.getElementById('items-container');
        const div = document.createElement('div');
        div.className = 'border p-2 rounded';
        div.innerHTML = `
            <input type="text" name="items[${itemIndex}][titulo]" placeholder="Título" class="w-full mb-1">
            <input type="text" name="items[${itemIndex}][tipo]" value="texto" placeholder="Tipo" class="w-full mb-1">
            <textarea name="items[${itemIndex}][detalle]" placeholder="Detalle" class="w-full mb-1"></textarea>
            <label><input type="checkbox" name="items[${itemIndex}][requerido]" value="1"> Requerido</label>
        `;
        c.appendChild(div);
        itemIndex++;
    });

    document.getElementById('add-rule').addEventListener('click', function () {
        const c = document.getElementById('rules-container');
        const div = document.createElement('div');
        div.className = 'border p-2 rounded';
        div.innerHTML = `
            <input type="text" name="rules[${ruleIndex}][canal]" placeholder="email / whatsapp / sistema" class="w-full mb-1">
            <input type="number" name="rules[${ruleIndex}][offset_days]" value="0" class="w-full mb-1">
            <select name="rules[${ruleIndex}][momento]" class="w-full mb-1">
                <option value="antes">Antes</option>
                <option value="despues">Después</option>
            </select>
            <input type="time" name="rules[${ruleIndex}][hora]" class="w-full mb-1">
            <textarea name="rules[${ruleIndex}][mensaje]" placeholder="Mensaje" class="w-full"></textarea>
        `;
        c.appendChild(div);
        ruleIndex++;
    });
});
</script>
@endpush
