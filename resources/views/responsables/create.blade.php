@extends('layouts.base')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">👤 Registrar Responsable</h1>

    <div id="alert-success" class="hidden mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        ✅ <span id="success-message"></span>
    </div>
    <div id="alert-error" class="hidden mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
        ⚠️ <span id="error-message"></span>
    </div>

    <form action="{{ route('responsables.buscar') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
            <input type="text" name="cedula" id="cedula" autocomplete="off"
                   class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2" required>
        </div>

        <div id="datos-responsable" class="hidden p-4 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
            <p><strong>Nombre:</strong> <span id="nombre"></span></p>
            <p><strong>Cédula:</strong> <span id="cedula-show"></span></p>
            <p><strong>Tipo:</strong> <span id="tipo"></span></p>
        </div>

        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Guardar Responsable
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cedulaInput = document.getElementById('cedula');
    const datosBox = document.getElementById('datos-responsable');
    const alertSuccess = document.getElementById('alert-success');
    const alertError = document.getElementById('alert-error');

    let timeout = null;

    cedulaInput.addEventListener('input', function () {
        clearTimeout(timeout);
        const cedula = this.value.trim();

        if (cedula.length < 6) {
            datosBox.classList.add('hidden');
            return;
        }

        timeout = setTimeout(() => {
            fetch("{{ route('responsables.buscar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ cedula })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('nombre').textContent = data.data.nombre;
                    document.getElementById('cedula-show').textContent = data.data.cedula;
                    document.getElementById('tipo').textContent = data.data.tipo;

                    datosBox.classList.remove('hidden');
                    alertSuccess.classList.remove('hidden');
                    document.getElementById('success-message').textContent = data.message;
                } else {
                    datosBox.classList.add('hidden');
                    alertError.classList.remove('hidden');
                    document.getElementById('error-message').textContent = 'No encontrado';
                }
            });
        }, 500);
    });
});
</script>
@endsection
