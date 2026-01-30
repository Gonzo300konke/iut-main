@extends('layouts.base')

@section('title', 'Crear Bien')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Nuevo Bien</h1>

        <form action="{{ route('bienes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Dependencia --}}
            <div>
                <label for="dependencia_id" class="block text-sm font-semibold text-gray-700 mb-2">Dependencia</label>
                <select name="dependencia_id" id="dependencia_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
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

            {{-- Responsable --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Responsable</label>
                <div id="responsable_display"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 italic text-gray-500">
                    Seleccione una dependencia para ver el responsable
                </div>
            </div>

            {{-- Código --}}
            <div>
                <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-2">Código del Bien</label>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    value="{{ old('codigo', $codigoSugerido ?? '') }}"
                    maxlength="8"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    autocomplete="off"
                    placeholder="00000001"
                    onpaste="return false"
                    ondrop="return false"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono focus:ring-2 focus:ring-blue-500 transition"
                >

                <p id="codigo-error" class="text-red-500 text-[10px] mt-1 hidden italic font-bold">
                    Solo se permiten números (0–9).
                </p>

                @error('codigo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Precio y fecha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Precio (Bs.)</label>
                    <input type="number" name="precio" step="0.01" min="0"
                        value="{{ old('precio', '0.00') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    @error('precio')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Registro</label>
                    <input type="date" name="fecha_registro"
                        value="{{ old('fecha_registro', now()->format('Y-m-d')) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    @error('fecha_registro')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Ubicación --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ubicación Física</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
            </div>

            {{-- Fotografía --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fotografía</label>
                <input type="file" name="fotografia" accept="image/*"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white">
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                <select name="estado"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Seleccione...</option>
                    @foreach(\App\Enums\EstadoBien::cases() as $estado)
                        <option value="{{ $estado->value }}" {{ old('estado') == $estado->value ? 'selected' : '' }}>
                            {{ $estado->label() }}
                        </option>
                    @endforeach
                </select>
                @error('estado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Bien</label>
                <select name="tipo_bien" id="tipo_bien"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Seleccione...</option>
                    @foreach($tiposBien as $value => $label)
                        <option value="{{ $value }}" {{ old('tipo_bien') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_bien')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t">
                <a href="{{ route('bienes.index') }}"
                    class="px-6 py-3 bg-gray-100 rounded-lg">Cancelar</a>
                <button class="px-6 py-3 bg-blue-600 text-white rounded-lg">
                    Guardar Bien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* Responsable */
    const dependencias = @json(
        $dependencias->mapWithKeys(fn($d) => [$d->id => $d->responsable?->nombre])
    );
    const depSel = document.getElementById('dependencia_id');
    const resp = document.getElementById('responsable_display');

    depSel.addEventListener('change', () => {
        resp.textContent = dependencias[depSel.value] ?? 'No hay responsable asignado';
    });

    /* Código solo números */
    const codigo = document.getElementById('codigo');
    const error = document.getElementById('codigo-error');
    let t;

    function showError() {
        error.classList.remove('hidden');
        clearTimeout(t);
        t = setTimeout(() => error.classList.add('hidden'), 1500);
    }

    codigo.addEventListener('keydown', e => {
        if (
            ['Backspace','Delete','Tab','ArrowLeft','ArrowRight'].includes(e.key) ||
            e.ctrlKey || e.metaKey
        ) return;

        if (!/^[0-9]$/.test(e.key)) {
            e.preventDefault();
            showError();
        }
    });

    codigo.addEventListener('input', () => {
        if (/\D/.test(codigo.value)) {
            codigo.value = codigo.value.replace(/\D/g, '');
            showError();
        }
    });

    codigo.addEventListener('blur', () => {
        if (codigo.value) {
            codigo.value = codigo.value.padStart(8, '0').slice(-8);
        }
    });
</script>
@endpush
