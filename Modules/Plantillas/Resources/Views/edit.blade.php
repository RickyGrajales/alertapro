<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">

            <h1 class="text-2xl font-bold text-blue-700 mb-4">
                ✏️ Editar Plantilla
            </h1>

            <form action="{{ route('plantillas.update', $plantilla->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NOMBRE --}}
                <div class="mb-4">
                    <label class="font-semibold">Nombre *</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre', $plantilla->nombre) }}"
                           class="w-full border rounded p-2" required>
                </div>

                {{-- RECURRENCIA --}}
                <div class="mb-4">
                    <label class="font-semibold">Recurrencia *</label>
                    <select name="recurrencia" class="w-full border rounded p-2">
                        @foreach(['Diaria','Semanal','Mensual'] as $r)
                            <option value="{{ $r }}" @selected($plantilla->recurrencia == $r)>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="mb-4">
                    <label class="font-semibold">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full border rounded p-2">{{ old('descripcion', $plantilla->descripcion) }}</textarea>
                </div>

                {{-- ACTIVA --}}
                <div class="mb-4">
                    <label class="font-semibold">Activa</label>
                    <select name="activa" class="w-full border rounded p-2">
                        <option value="1" @selected($plantilla->activa)==1>Sí</option>
                        <option value="0" @selected($plantilla->activa)==0>No</option>
                    </select>
                </div>

                {{-- ORGANIZACIONES --}}
                <div class="mb-6">
                    <label class="font-semibold">Organizaciones asociadas</label>
                    <select name="organizaciones[]" multiple size="5" class="w-full border p-2 rounded">
                        @foreach($organizaciones as $org)
                            <option value="{{ $org->id }}"
                                @selected($plantilla->organizaciones->contains($org->id))>
                                {{ $org->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ============================
                   ITEMS DINÁMICOS
                ============================= --}}
                <hr class="my-6">
                <h2 class="text-xl font-bold mb-2">Ítems de la plantilla</h2>

                <div id="items-container">

                    @foreach($plantilla->items as $i => $item)
                        <div class="border p-3 rounded mb-3 bg-gray-50 item-row">

                            <button type="button"
                                    onclick="this.parentElement.remove()"
                                    class="float-right text-red-600 font-bold">X</button>

                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">

                            <label>Título *</label>
                            <input type="text" name="items[{{ $i }}][titulo]"
                                   value="{{ $item->titulo }}"
                                   class="w-full border p-2 rounded">

                            <label>Detalle</label>
                            <textarea name="items[{{ $i }}][detalle]" class="w-full border p-2 rounded">{{ $item->detalle }}</textarea>

                            <label>Orden</label>
                            <input type="number" name="items[{{ $i }}][orden]"
                                   value="{{ $item->orden }}"
                                   class="w-full border p-2 rounded">

                            <label>Requerido</label>
                            <select name="items[{{ $i }}][requerido]" class="w-full border p-2 rounded">
                                <option value="0" @selected(!$item->requerido)>No</option>
                                <option value="1" @selected($item->requerido)>Sí</option>
                            </select>

                            <label>Tipo</label>
                            <select name="items[{{ $i }}][tipo]" class="w-full border p-2 rounded">
                                <option value="texto" @selected($item->tipo=='texto')>Texto</option>
                                <option value="numero" @selected($item->tipo=='numero')>Número</option>
                                <option value="opcion" @selected($item->tipo=='opcion')>Opción</option>
                            </select>

                        </div>
                    @endforeach

                </div>

                <button type="button" onclick="addItemRow()"
                        class="bg-blue-600 text-white px-3 py-1 rounded">
                    + Añadir ítem
                </button>

                {{-- ============================
                   REGLAS DINÁMICAS
                ============================= --}}
                <hr class="my-6">
                <h2 class="text-xl font-bold mb-2">Reglas de notificación</h2>

                <div id="rules-container">

                    @foreach($plantilla->notificationRules as $r => $rule)
                        <div class="border p-3 rounded bg-green-50 relative mb-3 rule-row">

                            <button type="button" onclick="this.parentElement.remove()"
                                class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                            <label>Canal</label>
                            <select name="rules[{{ $r }}][canal]" class="w-full border p-2 rounded">
                                <option value="email" @selected($rule->canal=='email')>Correo</option>
                                <option value="whatsapp" @selected($rule->canal=='whatsapp')>WhatsApp</option>
                            </select>

                            <label>Días antes/después</label>
                            <input type="number" name="rules[{{ $r }}][offset_days]"
                                   value="{{ $rule->offset_days }}"
                                   class="w-full border p-2 rounded">

                            <label>Momento</label>
                            <select name="rules[{{ $r }}][momento]" class="w-full border p-2 rounded">
                                <option value="antes" @selected($rule->momento=='antes')>Antes</option>
                                <option value="despues" @selected($rule->momento=='despues')>Después</option>
                            </select>

                            <label>Hora</label>
                            <input type="time" name="rules[{{ $r }}][hora]"
                                   value="{{ $rule->hora }}"
                                   class="w-full border p-2 rounded">

                            <label>Mensaje</label>
                            <textarea name="rules[{{ $r }}][mensaje]"
                                      class="w-full border p-2 rounded">{{ $rule->mensaje }}</textarea>

                        </div>
                    @endforeach

                </div>

                <button type="button" onclick="addRuleRow()"
                        class="bg-green-600 text-white px-3 py-1 rounded">
                    + Añadir regla
                </button>

                {{-- BOTONES --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                        Cancelar
                    </a>
                    <button class="px-4 py-2 bg-primary text-white rounded">
                        Guardar cambios
                    </button>
                </div>

            </form>

        </div>
    </div>

{{-- SCRIPTS --}}
<script>
let itemIndex = {{ count($plantilla->items) }};
let ruleIndex = {{ count($plantilla->notificationRules) }};

function addItemRow() {
    let container = document.getElementById('items-container');
    container.insertAdjacentHTML('beforeend', `
        <div class="border p-3 rounded mb-3 bg-gray-50 item-row">

            <button type="button" onclick="this.parentElement.remove()"
                    class="float-right text-red-600 font-bold">X</button>

            <label>Título *</label>
            <input type="text" name="items[${itemIndex}][titulo]" class="w-full border p-2 rounded">

            <label>Detalle</label>
            <textarea name="items[${itemIndex}][detalle]" class="w-full border p-2 rounded"></textarea>

            <label>Orden</label>
            <input type="number" name="items[${itemIndex}][orden]" class="w-full border p-2 rounded">

            <label>Requerido</label>
            <select name="items[${itemIndex}][requerido]" class="w-full border p-2 rounded">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>

            <label>Tipo</label>
            <select name="items[${itemIndex}][tipo]" class="w-full border p-2 rounded">
                <option value="texto">Texto</option>
                <option value="numero">Número</option>
                <option value="opcion">Opción</option>
            </select>
        </div>
    `);

    itemIndex++;
}

function addRuleRow() {
    let container = document.getElementById('rules-container');
    container.insertAdjacentHTML('beforeend', `
        <div class="border p-3 rounded bg-green-50 relative mb-3 rule-row">

            <button type="button" onclick="this.parentElement.remove()"
                    class="absolute top-2 right-2 text-red-600 font-bold">X</button>

            <label>Canal</label>
            <select name="rules[${ruleIndex}][canal]" class="w-full border p-2 rounded">
                <option value="email">Correo</option>
                <option value="whatsapp">WhatsApp</option>
            </select>

            <label>Días antes/después</label>
            <input type="number" name="rules[${ruleIndex}][offset_days]" class="w-full border p-2 rounded">

            <label>Momento</label>
            <select name="rules[${ruleIndex}][momento]" class="w-full border p-2 rounded">
                <option value="antes">Antes</option>
                <option value="despues">Después</option>
            </select>

            <label>Hora</label>
            <input type="time" name="rules[${ruleIndex}][hora]" class="w-full border p-2 rounded">

            <label>Mensaje</label>
            <textarea name="rules[${ruleIndex}][mensaje]" class="w-full border p-2 rounded"></textarea>

        </div>
    `);

    ruleIndex++;
}
</script>

</x-app-layout>
