@extends('layouts.base')

@section('title', 'Crear Unidad')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Nueva Unidad Administradora</h1>

        <form action="{{ route('unidades.store') }}" method="POST" class="space-y-6" novalidate>
            @csrf

            <div>
                <label for="organismo_id" class="block text-sm font-semibold text-gray-700 mb-2">Organismo</label>
                <select name="organismo_id" id="organismo_id"
                        class="w-full px-4 py-3 border @error('organismo_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                    <option value="">Seleccione...</option>
                    @foreach($organismos as $org)
                        <option value="{{ $org->id }}" {{ old('organismo_id') == $org->id ? 'selected' : '' }}>
                            {{ $org->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('organismo_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="codigo" class="block text-sm font-semibold text-gray-700 mb-2">Código</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                       placeholder="Ej: UA-001"
                       class="w-full px-4 py-3 border @error('codigo') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                @error('codigo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                       placeholder="Nombre de la unidad administradora"
                       class="w-full px-4 py-3 border @error('nombre') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('unidades.index') }}"
                   class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition duration-200">
                    ✗ Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                    ✓ Guardar Unidad
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
