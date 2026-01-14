@extends('layouts.base')

@section('title', 'Nueva Dependencia')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Dependencia</h1>

        <form action="{{ route('dependencias.store') }}" method="POST" class="space-y-6" novalidate>
            @csrf

            <div>
                <label for="unidad_administradora_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Unidad Administradora
                </label>
                <select name="unidad_administradora_id" id="unidad_administradora_id"
                        class="w-full px-4 py-3 border @error('unidad_administradora_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                    <option value="">Seleccione...</option>
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->id }}" {{ old('unidad_administradora_id') == $unidad->id ? 'selected' : '' }}>
                            {{ $unidad->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('unidad_administradora_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                       placeholder="Ej: Dirección de Finanzas"
                       class="w-full px-4 py-3 border @error('nombre') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-2">Código</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                       placeholder="Ej: DEP-001"
                       class="w-full px-4 py-3 border @error('codigo') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-mono">
                @error('codigo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="responsable_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Responsable (opcional)
                </label>
                <select name="responsable_id" id="responsable_id"
                        class="w-full px-4 py-3 border @error('responsable_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                    <option value="">-- Ninguno --</option>
                    @foreach($responsables as $resp)
                        <option value="{{ $resp->id }}" {{ old('responsable_id') == $resp->id ? 'selected' : '' }}>
                            {{ $resp->nombre }}
                            @if($resp->cedula) ({{ $resp->cedula }}) @endif
                            - {{ $resp->tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('responsable_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('dependencias.index') }}"
                   class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition duration-200">
                    ✗ Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                    ✓ Guardar Dependencia
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Restricción para que solo acepte números y guiones en el código
    document.getElementById('codigo').addEventListener('input', function (e) {
        const regex = /^[0-9\-]*$/;
        if (!regex.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9\-]/g, '');
        }
    });
</script>
@endsection
