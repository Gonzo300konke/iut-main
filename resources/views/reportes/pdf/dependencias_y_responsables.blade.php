@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            <th>Organismo</th>
            <th>Unidad</th>
            <th>Código Dep.</th>
            <th>Dependencia</th>
            <th>Responsable</th>
        </tr>
    </thead>
    <tbody>
    @forelse($dependencias as $dep)
        <tr>
            <td>{{ $dep->unidadAdministradora->organismo->nombre ?? 'N/D' }}</td>
            <td>{{ $dep->unidadAdministradora->nombre ?? 'N/D' }}</td>
            <td>{{ $dep->codigo }}</td>
            <td>{{ $dep->nombre }}</td>
            <td>{{ optional($dep->responsable)->nombre ?? 'Sin responsable' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No hay dependencias para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
