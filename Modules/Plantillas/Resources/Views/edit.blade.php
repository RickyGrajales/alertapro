<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 bg-white shadow rounded">

        <h1 class="text-2xl font-bold mb-4 text-blue-700">Editar Plantilla</h1>

        <form action="{{ route('plantillas.update', $plantilla->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Información general --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div>
                    <label class="font-semibold">Nombre *</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre', $plantilla->nombre) }}"
                           class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="font-semibold">Recurrencia</label>
                    <select name="recurrencia" class="w-full border rounded p-2">
                        <option value="Diaria"   @selected($plantilla->recurrencia === 'Diaria')>Diaria</option>
                        <option value="Semanal"  @selected($plantilla->recurrencia === 'Semanal')>Semanal</option>
                        <option value="Mensual"  @selected($plantilla->recurrencia === 'Mensual')>Mensual</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">Descripción</label>
                    <textarea name="descripcion" class="w-full border rounded p-2" rows="3">
                        {{ old('descripcion', $plantilla->descripcion) }}
                    </textarea>
                </div>

                <div>
                    <label class="font-semibold">Activa</label>
                    <select name="activa" class="w-full border rounded p-2">
                        <option value="1" @selected($plantilla->activa == 1)>Sí</option>
                        <option value="0" @selected($plantilla->activa == 0)>No</option>
                    </select>
                </div>

            </div>

            {{-- Organizaciones --}}
            <div class="mb-6">
                <label class="font-semibold">Organizaciones asociadas</label>
                <select name="organizaciones[]" class="w-full border rounded p-2" multiple size="5">
                    @foreach($organizaciones as $org)
                        <option value="{{ $org->id }}"
                            @selected($plantilla->organizaciones->contains($org->id))>
                            {{ $org->nombre }}
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Ctrl + click para seleccionar varias</small>
            </div>

            {{-- Ítems --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-lg">Ítems</h2>
                    <button type="button" onclick="addItemRow()"
                        class="bg-blue-600 text-white px-3 py-1 rounded">+ Añadir ítem</button>
                </div>

                <div id="items-container">
                    @foreach($plantilla->items as $i => $item)
                        <div class="border p-3 rounded bg-gray-50 relative mb-3">

                            {{-- Botón eliminar --}}
                            <button type="button" onclick="this.parentElement.remove()"
                                class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">

                            <label>Título *</label>
                            <input type="text" name="items[{{ $i }}][titulo]"
                                   value="{{ $item->titulo }}"
                                   class="w-full border p-2 rounded mb-2" required>

                            <label>Detalle</label>
                            <textarea name="items[{{ $i }}][detalle]"
                                class="w-full border p-2 rounded mb-2"
                                rows="2">{{ $item->detalle }}</textarea>

                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label>Orden</label>
                                    <input type="number" name="items[{{ $i }}][orden]"
                                           value="{{ $item->orden }}"
                                           class="w-full border p-2 rounded">
                                </div>

                                <div>
                                    <label>Tipo</label>
                                    <select name="items[{{ $i }}][tipo]" class="w-full border p-2 rounded">
                                        <option value="texto"    @selected($item->tipo === 'texto')>Texto</option>
                                        <option value="archivo"  @selected($item->tipo === 'archivo')>Archivo</option>
                                        <option value="checkbox" @selected($item->tipo === 'checkbox')>Checkbox</option>
                                        <option value="numero"   @selected($item->tipo === 'numero')>Número</option>
                                        <option value="fecha"    @selected($item->tipo === 'fecha')>Fecha</option>
                                    </select>
                                </div>

                                <div>
                                    <label>Requerido</label>
                                    <select name="items[{{ $i }}][requerido]" class="w-full border p-2 rounded">
                                        <option value="1" @selected($item->requerido == 1)>Sí</option>
                                        <option value="0" @selected($item->requerido == 0)>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Reglas --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-semibold text-lg">Reglas de Notificación</h2>
                    <button type="button" onclick="addRuleRow()"
                        class="bg-green-600 text-white px-3 py-1 rounded">+ Añadir regla</button>
                </div>

                <div id="rules-container">
                    @foreach($plantilla->rules as $r => $rule)
                        <div class="border p-3 rounded bg-green-50 relative mb-3">

                            <button type="button" onclick="this.parentElement.remove()"
                                class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                            <input type="hidden" name="rules[{{ $r }}][id]" value="{{ $rule->id }}">

                            <div class="grid grid-cols-4 gap-2 mb-2">
                                <div>
                                    <label>Canal</label>
                                    <select name="rules[{{ $r }}][canal]" class="w-full border p-2 rounded">
                                        <option value="email"    @selected($rule->canal === 'email')>Email</option>
                                        <option value="whatsapp" @selected($rule->canal === 'whatsapp')>WhatsApp</option>
                                        <option value="sms"      @selected($rule->canal === 'sms')>SMS</option>
                                    </select>
                                </div>

                                <div>
                                    <label>Momento</label>
                                    <select name="rules[{{ $r }}][momento]" class="w-full border p-2 rounded">
                                        <option value="antes"   @selected($rule->momento === 'antes')>Antes</option>
                                        <option value="despues" @selected($rule->momento === 'despues')>Después</option>
                                    </select>
                                </div>

                                <div>
                                    <label>Días</label>
                                    <input type="number" name="rules[{{ $r }}][offset_days]"
                                           value="{{ $rule->offset_days }}"
                                           class="w-full border p-2 rounded">
                                </div>

                                <div>
                                    <label>Hora</label>
                                    <input type="time" name="rules[{{ $r }}][hora]"
                                           value="{{ $rule->hora }}"
                                           class="w-full border p-2 rounded">
                                </div>
                            </div>

                            <label>Mensaje</label>
                            <textarea name="rules[{{ $r }}][mensaje]"
                                class="w-full border p-2 rounded"
                                rows="2">{{ $rule->mensaje }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('plantillas.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
            </div>

        </form>
    </div>
</x-app-layout>

{{-- SCRIPTS --}}
@push('scripts')
<script>
    function addItemRow() {
        const container = document.getElementById('items-container');
        const index = container.children.length;

        const html = `
            <div class="border p-3 rounded bg-gray-50 relative mb-3">

                <button type="button" onclick="this.parentElement.remove()"
                    class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                <label>Título *</label>
                <input type="text" name="items[${index}][titulo]" class="w-full border p-2 rounded mb-2" required>

                <label>Detalle</label>
                <textarea name="items[${index}][detalle]" class="w-full border p-2 rounded mb-2" rows="2"></textarea>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label>Orden</label>
                        <input type="number" name="items[${index}][orden]" value="${index + 1}"
                               class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Tipo</label>
                        <select name="items[${index}][tipo]" class="w-full border p-2 rounded">
                            <option value="texto">Texto</option>
                            <option value="archivo">Archivo</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="numero">Número</option>
                            <option value="fecha">Fecha</option>
                        </select>
                    </div>

                    <div>
                        <label>Requerido</label>
                        <select name="items[${index}][requerido]" class="w-full border p-2 rounded">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML("beforeend", html);
    }

    function addRuleRow() {
        const container = document.getElementById('rules-container');
        const index = container.children.length;

        const html = `
            <div class="border p-3 rounded bg-green-50 relative mb-3">

                <button type="button" onclick="this.parentElement.remove()"
                    class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                <div class="grid grid-cols-4 gap-2 mb-2">
                    <div>
                        <label>Canal</label>
                        <select name="rules[${index}][canal]" class="w-full border p-2 rounded">
                            <option value="email">Email</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>

                    <div>
                        <label>Momento</label>
                        <select name="rules[${index}][momento]" class="w-full border p-2 rounded">
                            <option value="antes">Antes</option>
                            <option value="despues">Después</option>
                        </select>
                    </div>

                    <div>
                        <label>Días</label>
                        <input type="number" name="rules[${index}][offset_days]" value="1"
                               class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Hora</label>
                        <input type="time" name="rules[${index}][hora]" class="w-full border p-2 rounded">
                    </div>
                </div>

                <label>Mensaje</label>
                <textarea name="rules[${index}][mensaje]" class="w-full border p-2 rounded" rows="2"></textarea>
            </div>
        `;

        container.insertAdjacentHTML("beforeend", html);
    }
</script>
@endpush
