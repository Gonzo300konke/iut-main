@extends('reportes.pdf')

@section('contenido')
@foreach($unidades as $unidad)
    <h2>{{ $unidad->nombre }} ({{ $unidad->codigo }})</h2>
    <table>
        <thead>
            <tr>
                <th>Código Dependencia</th>
                <th>Nombre Dependencia</th>
                <th>Responsable</th>
                <th>Nro. Bienes</th>
            </tr>
        </thead>
        <tbody>
        @forelse($unidad->dependencias as $dependencia)
            <tr>
                <td>{{ $dependencia->codigo }}</td>
                <td>{{ $dependencia->nombre }}</td>
                <td>{{ optional($dependencia->responsable)->nombre ?? 'Sin responsable' }}</td>
                <td style="text-align:right;">{{ $dependencia->bienes->count() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Sin dependencias asociadas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <br>
@endforeach
@endsection
