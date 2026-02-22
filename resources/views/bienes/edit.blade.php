@extends('layouts.base')

@section('title', 'Editar Bien')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            {{-- Encabezado idéntico a Create --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-5">
                <h1 class="text-xl font-bold text-white flex items-center gap-2">
                    <x-heroicon-o-pencil-square class="w-5 h-5 text-blue-100" />
                    Editar Bien: <span class="text-blue-200 font-mono">{{ $bien->codigo }}</span>
                </h1>
                <p class="text-blue-100 text-xs mt-1 opacity-90">
                    Modifique la información técnica o administrativa del activo patrimonial seleccionado.
                </p>
            </div>

            <form action="{{ route('bienes.update', $bien) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                {{-- Sección 1: Ubicación Administrativa --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 border-b pb-2 flex items-center gap-2">
                        <x-heroicon-o-home-modern class="w-5 h-5 text-blue-600" /> Asignación Administrativa
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="dependencia_id" class="block text-sm font-bold text-gray-700 mb-2">Dependencia</label>
                            <select name="dependencia_id" id="dependencia_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                                <option value="">Sin asignar (Almacén Central)</option>
                                @foreach($dependencias as $dep)
                                    <option value="{{ $dep->id }}" {{ old('dependencia_id', $bien->dependencia_id) == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Responsable de la Dependencia</label>
                            <div id="responsable_display"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 italic text-sm flex items-center h-[50px]">
                                {{ $bien->dependencia->responsable->nombre ?? 'Cargando responsable...' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Identificación del Bien --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 border-b pb-2 flex items-center gap-2">
                        <x-heroicon-o-identification class="w-5 h-5 text-blue-600" /> Identificación Técnica
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Código --}}
                        <div>
                            <label for="codigo" class="block text-sm font-bold text-gray-700 mb-2">Código del Bien</label>
                            <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $bien->codigo) }}"
                                maxlength="8" inputmode="numeric"
                                class="w-full px-4 py-3 border @error('codigo') border-red-500 @else border-gray-300 @enderror rounded-lg font-mono focus:ring-2 focus:ring-blue-500 outline-none transition uppercase">

                            <div id="sugerencia-container" class="mt-1 hidden">
                                <button type="button" id="btn-sugerencia" class="text-[10px] text-blue-600 hover:underline font-bold italic">
                                    💡 ¿Restaurar código original: <span id="span-sugerencia"></span>?
                                </button>
                            </div>
                        </div>

                        {{-- Tipo de Bien --}}
                        <div>
                            <label for="tipo_bien" class="block text-sm font-bold text-gray-700 mb-2">Tipo de Bien</label>
                            <select name="tipo_bien" id="tipo_bien" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                                @foreach($tiposBien as $value => $label)
                                    <option value="{{ $value }}" {{ old('tipo_bien', $bien->tipo_bien->value ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label for="estado" class="block text-sm font-bold text-gray-700 mb-2">Estado Físico</label>
                            <select name="estado" id="estado" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition bg-white">
                                @foreach($estados as $value => $label)
                                    <option value="{{ $value }}" {{ old('estado', $bien->estado->value ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="descripcion" class="block text-sm font-bold text-gray-700">Descripción General</label>
                            <span id="char-count" class="text-[10px] font-bold text-gray-400">0 / 255</span>
                        </div>
                        <textarea name="descripcion" id="descripcion" rows="2" required maxlength="255"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('descripcion', $bien->descripcion) }}</textarea>
                    </div>
                </div>

                {{-- Sección 3: Valores y Archivos --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Precio (Bs.)</label>
                        <input type="number" name="precio" step="0.01" min="0" value="{{ old('precio', $bien->precio) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fecha de Adquisición</label>
                        <input type="date" name="fecha_registro" value="{{ old('fecha_registro', optional($bien->fecha_registro)->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fotografía (Opcional)</label>
                        @if($bien->fotografia)
                            <div class="mb-2 flex items-center gap-2 p-2 border rounded bg-gray-50">
                                <img src="{{ asset('storage/' . $bien->fotografia) }}" class="w-10 h-10 object-cover rounded">
                                <span class="text-[10px] text-gray-500">Imagen actual preservada</span>
                            </div>
                        @endif
                        <input type="file" name="fotografia" accept="image/*"
                            class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                {{-- Contenedor dinámico (Campos extra según tipo) --}}
                <div id="campos-tipo-bien" class="transition-all duration-300"></div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-8 border-t border-gray-100">
                    <a href="{{ route('bienes.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Cancelar</a>
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                        Actualizar Activo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /* 1. Datos de Dependencias */
        const dependenciasData = @json($dependencias->mapWithKeys(fn($d) => [$d->id => $d->responsable->nombre ?? 'Sin responsable']));
        const depSelect = document.getElementById('dependencia_id');
        const respDisplay = document.getElementById('responsable_display');

        depSelect.addEventListener('change', function () {
            respDisplay.textContent = dependenciasData[this.value] || 'Seleccione una dependencia...';
            respDisplay.classList.toggle('text-gray-900', !!this.value);
            respDisplay.classList.toggle('font-bold', !!this.value);
        });

        /* 2. Código Original Sugerido (para restaurar si se cambia) */
        const codigoOriginal = "{{ $bien->codigo }}";
        const codigoInput = document.getElementById('codigo');
        const sugerenciaContainer = document.getElementById('sugerencia-container');
        const spanSugerencia = document.getElementById('span-sugerencia');

        codigoInput.addEventListener('input', function (e) {
            this.value = this.value.replace(/\D/g, '');
            if (this.value !== codigoOriginal) {
                spanSugerencia.textContent = codigoOriginal;
                sugerenciaContainer.classList.remove('hidden');
            } else {
                sugerenciaContainer.classList.add('hidden');
            }
        });

        document.getElementById('btn-sugerencia').addEventListener('click', () => {
            codigoInput.value = codigoOriginal;
            sugerenciaContainer.classList.add('hidden');
        });

        /* 3. Contador Caracteres */
        const descTextarea = document.getElementById('descripcion');
        const charCount = document.getElementById('char-count');

        descTextarea.addEventListener('input', function () {
            charCount.textContent = `${this.value.length} / 255`;
            charCount.classList.toggle('text-red-500', this.value.length >= 255);
        });

        /* 4. Campos Dinámicos (Completos, igual que Create) */
        const camposPorTipo = {
            'ELECTRONICO': [
                { name: 'serial', label: 'Número de Serie', type: 'text' },
                { name: 'subtipo', label: 'Subtipo', type: 'text' },
                { name: 'procesador', label: 'Procesador', type: 'text' },
                { name: 'memoria', label: 'RAM/Memoria', type: 'text' },
                { name: 'almacenamiento', label: 'Almacenamiento', type: 'text' },
                { name: 'pantalla', label: 'Pantalla', type: 'text' },
                { name: 'garantia', label: 'Garantía hasta', type: 'date' }
            ],
            'VEHICULO': [
                { name: 'placa', label: 'Número de Placa', type: 'text' },
                { name: 'marca', label: 'Marca', type: 'text' },
                { name: 'modelo', label: 'Modelo', type: 'text' },
                { name: 'anio', label: 'Año', type: 'text' },
                { name: 'motor', label: 'Serial de Motor', type: 'text' },
                { name: 'chasis', label: 'Serial de Carrocería', type: 'text' },
                { name: 'combustible', label: 'Tipo de Combustible', type: 'text' },
                { name: 'kilometraje', label: 'Kilometraje', type: 'text' }
            ],
            'MOBILIARIO': [
                { name: 'material', label: 'Material de Fabricación', type: 'text' },
                { name: 'color', label: 'Color', type: 'text' },
                { name: 'dimensiones', label: 'Dimensiones (Largo x Ancho)', type: 'text' },
                { name: 'capacidad', label: 'Capacidad', type: 'text' },
                { name: 'cantidad_piezas', label: 'Cantidad de Piezas', type: 'number' },
                { name: 'acabado', label: 'Tipo de Acabado', type: 'text' }
            ],
            'OTROS': [
                { name: 'especificaciones', label: 'Especificaciones Extra', type: 'textarea' },
                { name: 'cantidad', label: 'Cantidad de Unidades', type: 'number' },
                { name: 'presentacion', label: 'Presentación/Formato', type: 'text' }
            ]
        };

        const tipoBienSelect = document.getElementById('tipo_bien');
        const container = document.getElementById('campos-tipo-bien');

        // Datos del subtipo actual cargados desde el controller
        const subtipoData = @json($subtipoData ?? []);
        const oldValues = @json(old() ?? []);

        tipoBienSelect.addEventListener('change', function () {
            const tipo = this.value;
            container.innerHTML = '';
            if (!tipo || !camposPorTipo[tipo]) return;

            let html = `
                <div class="bg-blue-50/50 border border-blue-100 p-6 rounded-xl space-y-4 animate-fade-in">
                    <h3 class="text-blue-800 font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        <x-heroicon-o-information-circle class="w-5 h-5" /> Detalles Técnicos del ${tipo}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            `;

            camposPorTipo[tipo].forEach(campo => {
                // Prioridad: Old Input -> Datos subtipo BD -> Vacío
                const val = oldValues[campo.name] || subtipoData[campo.name] || '';
                const isFull = campo.type === 'textarea' ? 'md:col-span-2' : '';
                html += `
                    <div class="${isFull}">
                        <label class="block text-xs font-bold text-blue-700 mb-1">${campo.label}</label>
                        ${campo.type === 'textarea'
                        ? `<textarea name="${campo.name}" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">${val}</textarea>`
                        : `<input type="${campo.type}" name="${campo.name}" value="${val}" class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white uppercase">`
                    }
                    </div>`;
            });

            html += `</div></div>`;
            container.innerHTML = html;
        });

        // Inicializar al cargar
        window.onload = () => {
            descTextarea.dispatchEvent(new Event('input'));
            tipoBienSelect.dispatchEvent(new Event('change'));
        };

        /* 5. Validación antes de enviar */
        const formEdit = document.querySelector('form[action*="bienes"]');
        if (formEdit) {
            formEdit.addEventListener('submit', function (e) {
                const codigo = document.getElementById('codigo').value.trim();
                const descripcion = document.getElementById('descripcion').value.trim();
                const tipo = tipoBienSelect.value;
                const estado = document.getElementById('estado')?.value || '';

                if (!codigo || codigo.length !== 8) {
                    e.preventDefault();
                    alert('El código debe contener exactamente 8 dígitos.');
                    return;
                }
                if (!descripcion) {
                    e.preventDefault();
                    alert('La descripción es obligatoria.');
                    return;
                }
                if (!tipo) {
                    e.preventDefault();
                    alert('Debe seleccionar el tipo de bien.');
                    return;
                }
                if (!estado) {
                    e.preventDefault();
                    alert('Debe seleccionar el estado del bien.');
                    return;
                }
            });
        }
    </script>
@endpush
