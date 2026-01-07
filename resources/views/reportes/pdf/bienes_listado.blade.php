@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Dependencia</th>
            <th>Unidad</th>
            <th>Organismo</th>
            <th>Precio estimado</th>
        </tr>
    </thead>
    <tbody>
    @forelse($bienes as $bien)
        <tr>
            <td>{{ $bien->codigo }}</td>
            <td>{{ $bien->descripcion }}</td>
            <td>{{ $bien->estado ?? '' }}</td>
            <td>{{ $bien->dependencia->nombre ?? '' }}</td>
            <td>{{ $bien->dependencia->unidadAdministradora->nombre ?? '' }}</td>
            <td>{{ $bien->dependencia->unidadAdministradora->organismo->nombre ?? '' }}</td>
            <td style="text-align:right;">{{ number_format((float)($bien->precio ?? 0), 2, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7">No hay datos para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
