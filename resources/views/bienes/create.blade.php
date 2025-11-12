@extends('layouts.base')

@section('title', 'Crear Bien')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Nuevo Bien</h1>

            <form action="{{ route('bienes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Dependencia -->
                <div>
                    <label for="dependencia_id" class="block text-sm font-semibold text-gray-700 mb-2">Dependencia</label>
                    <select name="dependencia_id" id="dependencia_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Seleccione...</option>
                        @foreach($dependencias as $dep)
                            <option value="{{ $dep->id }}" {{ old('dependencia_id') == $dep->id ? 'selected' : '' }}>
                                {{ $dep->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('dependencia_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsable: se asigna a nivel de Dependencia -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Responsable</label>
                    <div id="responsable_display" class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700">Seleccione una dependencia para ver el responsable asignado</div>
                </div>

                <!-- Código -->
                <div>
                    <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-2">Código</label>
                    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Ej: BN-001">
                    @error('codigo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                              placeholder="Describe el bien...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-semibold text-gray-700 mb-2">Precio (Bs.)</label>
                    <input type="number" name="precio" id="precio" value="{{ old('precio', '0.00') }}"
                           step="0.01" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="0.00">
                    @error('precio')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fotografía -->
                <div>
                    <label for="fotografia" class="block text-sm font-semibold text-gray-700 mb-2">Fotografía</label>
                    <input type="file" name="fotografia" id="fotografia"
                           accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                    <p class="text-gray-500 text-xs mt-2">Formatos admitidos: JPG, PNG, WEBP. Máx 2MB.</p>
                    @error('fotografia')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ubicación -->
                <div>
                    <label for="ubicacion" class="block text-sm font-semibold text-gray-700 mb-2">Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Oficina 101">
                    @error('ubicacion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                    <select name="estado" id="estado"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Seleccione...</option>
                        @foreach(\App\Enums\EstadoBien::cases() as $estado)
                            <option value="{{ $estado->value }}" {{ old('estado') == $estado->value ? 'selected' : '' }}>
                                {{ ucfirst($estado->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de registro -->
                <div>
                    <label for="fecha_registro" class="block text-sm font-semibold text-gray-700 mb-2">
                        📅 Fecha de Registro
                    </label>
                    <div class="relative">
                        <input type="date" name="fecha_registro" id="fecha_registro" value="{{ old('fecha_registro', now()->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               style="font-size: 16px;">
                        <span class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                            📆
                        </span>
                    </div>
                    @error('fecha_registro')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-2">Selecciona la fecha en la que se registró el bien</p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('bienes.index') }}"
                       class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition duration-200">
                        ✗ Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                        ✓ Guardar Bien
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mostrar responsable según la dependencia seleccionada (cargadas en el servidor con dependencia.responsable)
    const dependenciaSelect = document.getElementById('dependencia_id');
    const responsableDisplay = document.getElementById('responsable_display');

    const dependencias = {
        @foreach($dependencias as $d)
            '{{ $d->id }}': {
                nombre: `{{ addslashes($d->nombre) }}`,
                responsable: {!! json_encode($d->responsable ? $d->responsable->nombre : null) !!}
            },
        @endforeach
    };

    function actualizarResponsable() {
        const id = dependenciaSelect.value;
        if (!id) {
            responsableDisplay.textContent = 'Seleccione una dependencia para ver el responsable asignado';
            return;
        }
        const dep = dependencias[id];
        if (dep && dep.responsable) {
            responsableDisplay.textContent = dep.responsable;
        } else {
            responsableDisplay.textContent = 'No hay responsable asignado para esta dependencia';
        }
    }

    dependenciaSelect.addEventListener('change', actualizarResponsable);
    // Inicializar
    actualizarResponsable();
</script>
@endpush

