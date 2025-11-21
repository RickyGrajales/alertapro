@php
    $t = $template ?? null;
@endphp

<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block font-semibold">Nombre *</label>
        <input type="text" name="nombre" value="{{ old('nombre', $t->nombre ?? '') }}" required class="w-full border rounded p-2">
    </div>

    <div>
        <label class="block font-semibold">Descripción</label>
        <textarea name="descripcion" class="w-full border rounded p-2">{{ old('descripcion', $t->descripcion ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block font-semibold">Recurrencia</label>
            <select name="recurrencia" class="w-full border rounded p-2">
                @foreach(['Nunca','Diaria','Semanal','Mensual','Anual'] as $r)
                    <option value="{{ $r }}" @selected(old('recurrencia', $t->recurrencia ?? 'Nunca') === $r)>{{ $r }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Activa</label>
            <select name="activa" class="w-full border rounded p-2">
                <option value="1" @selected(old('activa', $t->activa ?? 1) == 1)>Sí</option>
                <option value="0" @selected(old('activa', $t->activa ?? 1) == 0)>No</option>
            </select>
        </div>

        <div>
            <label class="block font-semibold">Organizaciones</label>
            <select name="organizaciones[]" multiple class="w-full border rounded p-2">
                @foreach($organizaciones ?? [] as $org)
                    <option value="{{ $org->id }}"
                        @if( (old('organizaciones') && in_array($org->id, old('organizaciones'))) ||
                             (isset($template) && $template->organizaciones->pluck('id')->contains($org->id)) ) selected @endif>
                        {{ $org->nombre }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500">Mantén Ctrl/Comando para seleccionar varias.</p>
        </div>
    </div>

    {{-- Items dinámicos (básico) --}}
    <div>
        <label class="block font-semibold">Ítems (checklist)</label>
        <div id="items-list" class="space-y-2">
            @php
                $oldItems = old('items', $t ? $t->items->map(function($i){ return $i->toArray(); })->toArray() : []);
            @endphp

            @if($oldItems && count($oldItems))
                @foreach($oldItems as $idx => $it)
                    <div class="p-2 border rounded flex gap-2 items-start">
                        <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $it['id'] ?? '' }}">
                        <input type="text" name="items[{{ $idx }}][titulo]" value="{{ $it['titulo'] ?? '' }}" placeholder="Título" class="flex-1 border rounded p-2">
                        <select name="items[{{ $idx }}][tipo]" class="border rounded p-2">
                            <option value="texto" @selected(($it['tipo'] ?? '') === 'texto')>Texto</option>
                            <option value="archivo" @selected(($it['tipo'] ?? '') === 'archivo')>Archivo</option>
                            <option value="checkbox" @selected(($it['tipo'] ?? '') === 'checkbox')>Checkbox</option>
                        </select>
                        <label class="flex items-center gap-1"><input type="checkbox" name="items[{{ $idx }}][requerido]" value="1" @checked(!empty($it['requerido']))>Req</label>
                        <button type="button" onclick="this.closest('.item').remove()" class="text-red-600">Eliminar</button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-2">
            <button type="button" id="add-item" class="px-3 py-1 bg-gray-200 rounded">+ Añadir ítem</button>
        </div>
    </div>

    {{-- Reglas de notificación (básico) --}}
    <div>
        <label class="block font-semibold">Reglas de Notificación</label>
        <div id="rules-list" class="space-y-2">
            @php
                $oldRules = old('rules', $t ? $t->rules->map(function($r){ return $r->toArray(); })->toArray() : []);
            @endphp

            @if($oldRules && count($oldRules))
                @foreach($oldRules as $ri => $rr)
                    <div class="p-2 border rounded flex gap-2 items-center">
                        <input type="hidden" name="rules[{{ $ri }}][id]" value="{{ $rr['id'] ?? '' }}">
                        <select name="rules[{{ $ri }}][canal]" class="border rounded p-2">
                            <option value="email" @selected(($rr['canal'] ?? '') === 'email')>Email</option>
                            <option value="whatsapp" @selected(($rr['canal'] ?? '') === 'whatsapp')>WhatsApp</option>
                            <option value="sms" @selected(($rr['canal'] ?? '') === 'sms')>SMS</option>
                        </select>
                        <input type="number" name="rules[{{ $ri }}][offset_days]" value="{{ $rr['offset_days'] ?? 0 }}" class="w-20 border rounded p-2">
                        <select name="rules[{{ $ri }}][momento]" class="border rounded p-2">
                            <option value="antes" @selected(($rr['momento'] ?? '') === 'antes')>antes</option>
                            <option value="despues" @selected(($rr['momento'] ?? '') === 'despues')>después</option>
                        </select>
                        <input type="time" name="rules[{{ $ri }}][hora]" value="{{ $rr['hora'] ?? '' }}" class="border rounded p-2">
                        <button type="button" class="text-red-600" onclick="this.closest('.rule').remove()">Eliminar</button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-2">
            <button type="button" id="add-rule" class="px-3 py-1 bg-gray-200 rounded">+ Añadir regla</button>
        </div>
    </div>
</div>

{{-- scripts mínimos para agregar items / rules --}}
@push('scripts')
<script>
document.addEventListener('click', function(e){
    if(e.target && e.target.id === 'add-item'){
        const list = document.getElementById('items-list');
        const idx = list.children.length;
        const div = document.createElement('div');
        div.className = 'p-2 border rounded flex gap-2 items-start item';
        div.innerHTML = `
            <input type="hidden" name="items[${idx}][id]" value="">
            <input type="text" name="items[${idx}][titulo]" placeholder="Título" class="flex-1 border rounded p-2">
            <select name="items[${idx}][tipo]" class="border rounded p-2">
                <option value="texto">Texto</option>
                <option value="archivo">Archivo</option>
                <option value="checkbox">Checkbox</option>
            </select>
            <label class="flex items-center gap-1"><input type="checkbox" name="items[${idx}][requerido]" value="1">Req</label>
            <button type="button" onclick="this.closest('.item').remove()" class="text-red-600">Eliminar</button>
        `;
        list.appendChild(div);
    }

    if(e.target && e.target.id === 'add-rule'){
        const list = document.getElementById('rules-list');
        const idx = list.children.length;
        const div = document.createElement('div');
        div.className = 'p-2 border rounded flex gap-2 items-center rule';
        div.innerHTML = `
            <input type="hidden" name="rules[${idx}][id]" value="">
            <select name="rules[${idx}][canal]" class="border rounded p-2">
                <option value="email">Email</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="sms">SMS</option>
            </select>
            <input type="number" name="rules[${idx}][offset_days]" value="0" class="w-20 border rounded p-2">
            <select name="rules[${idx}][momento]" class="border rounded p-2">
                <option value="antes">antes</option>
                <option value="despues">después</option>
            </select>
            <input type="time" name="rules[${idx}][hora]" class="border rounded p-2">
            <button type="button" class="text-red-600" onclick="this.closest('.rule').remove()">Eliminar</button>
        `;
        list.appendChild(div);
    }
});
</script>
@endpush
