@extends('reportes.pdf')

@section('contenido')
@foreach($organismos as $organismo)
    <h2>{{ $organismo->nombre }} ({{ $organismo->codigo }})</h2>
    <table>
        <thead>
            <tr>
                <th>Código Unidad</th>
                <th>Nombre Unidad</th>
                <th>Nro. Dependencias</th>
            </tr>
        </thead>
        <tbody>
        @forelse($organismo->unidadesAdministradoras as $unidad)
            <tr>
                <td>{{ $unidad->codigo }}</td>
                <td>{{ $unidad->nombre }}</td>
                <td style="text-align:right;">{{ $unidad->dependencias->count() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Sin unidades administradoras.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <br>
@endforeach
@endsection
