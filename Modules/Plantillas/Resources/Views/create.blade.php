<x-app-layout>

    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">

            <h1 class="text-2xl font-bold text-blue-700 mb-4">➕ Crear Plantilla</h1>

            <form action="{{ route('plantillas.store') }}" method="POST">
                @csrf

                {{-- DATOS BÁSICOS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="font-semibold">Nombre *</label>
                        <input type="text" name="nombre" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="font-semibold">Recurrencia *</label>
                        <select name="recurrencia" class="w-full border rounded p-2">
                            <option value="Diaria">Diaria</option>
                            <option value="Semanal">Semanal</option>
                            <option value="Mensual">Mensual</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="font-semibold">Descripción</label>
                        <textarea name="descripcion" rows="3" class="w-full border rounded p-2"></textarea>
                    </div>

                    <div>
                        <label class="font-semibold">Activa</label>
                        <select name="activa" class="w-full border rounded p-2">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    {{-- ORGANIZACIONES --}}
                    <div class="col-span-1 md:col-span-2">
                        <label class="font-semibold">Organizaciones asociadas</label>
                        <select name="organizaciones[]" multiple size="5" class="w-full border rounded p-2">
                            @foreach($organizaciones as $org)
                                <option value="{{ $org->id }}">{{ $org->nombre }}</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Ctrl + click para seleccionar varias</small>
                    </div>

                </div>

                {{-- -------------------------------
                       Í T E M S
                ----------------------------------}}
                <div class="mb-6 mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="font-semibold text-lg">Ítems</h2>

                        <button type="button"
                            onclick="addItemRow()"
                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            + Añadir ítem
                        </button>
                    </div>

                    <div id="items-container"></div>
                </div>

                {{-- -------------------------------
                     R E G L A S
                ----------------------------------}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="font-semibold text-lg">Reglas de Notificación</h2>

                        <button type="button"
                            onclick="addRuleRow()"
                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            + Añadir regla
                        </button>
                    </div>

                    <div id="rules-container"></div>
                </div>

                {{-- BOTONES --}}
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('plantillas.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</a>
                    <button class="px-4 py-2 bg-primary text-white rounded">Guardar</button>
                </div>

            </form>
        </div>
    </div>

    {{-- ================================
         S C R I P T S   D I N Á M I C O S
    =================================--}}
    <script>
        function addItemRow() {
            const container = document.getElementById('items-container');

            container.insertAdjacentHTML('beforeend', `
                <div class="border p-3 rounded bg-gray-50 relative mb-3">

                    <button type="button" onclick="this.parentElement.remove()"
                        class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                    <div class="grid grid-cols-4 gap-2 mb-2">

                        <div class="col-span-2">
                            <label>Título</label>
                            <input type="text" name="items[][titulo]" class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label>Tipo</label>
                            <select name="items[][tipo]" class="w-full border p-2 rounded">
                                <option value="texto">Texto</option>
                                <option value="numero">Número</option>
                                <option value="checkbox">Checkbox</option>
                            </select>
                        </div>

                        <div>
                            <label>Requerido</label>
                            <select name="items[][requerido]" class="w-full border p-2 rounded">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label>Detalle</label>
                        <textarea name="items[][detalle]" class="w-full border p-2 rounded" rows="2"></textarea>
                    </div>
                </div>
            `);
        }

        function addRuleRow() {
            const container = document.getElementById('rules-container');

            container.insertAdjacentHTML('beforeend', `
                <div class="border p-3 rounded bg-green-50 relative mb-3">

                    <button type="button" onclick="this.parentElement.remove()"
                        class="absolute top-2 right-2 text-red-600 font-bold">X</button>

                    <div class="grid grid-cols-4 gap-3">

                        <div>
                            <label>Canal</label>
                            <select name="rules[][canal]" class="w-full border p-2 rounded">
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="whatsapp">WhatsApp</option>
                            </select>
                        </div>

                        <div>
                            <label>Días antes/después</label>
                            <input type="number" name="rules[][offset_days]" class="w-full border p-2 rounded" value="0">
                        </div>

                        <div>
                            <label>Momento</label>
                            <select name="rules[][momento]" class="w-full border p-2 rounded">
                                <option value="antes">Antes</option>
                                <option value="despues">Después</option>
                            </select>
                        </div>

                        <div>
                            <label>Hora</label>
                            <input type="time" name="rules[][hora]" class="w-full border p-2 rounded">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label>Mensaje</label>
                        <textarea name="rules[][mensaje]" rows="2" class="w-full border p-2 rounded"></textarea>
                    </div>
                </div>
            `);
        }
    </script>

</x-app-layout>
