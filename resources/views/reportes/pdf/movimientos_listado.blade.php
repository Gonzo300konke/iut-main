@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Usuario</th>
            <th>Bien / Sujeto</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
    @forelse($movimientos as $mov)
        <tr>
            <td>{{ optional($mov->fecha)->format('d/m/Y H:i') }}</td>
            <td>{{ $mov->tipo }}</td>
            <td>{{ $mov->usuario->nombre_completo ?? 'N/D' }}</td>
            <td>
                @if($mov->bien)
                    Bien {{ $mov->bien->codigo }} — {{ $mov->bien->descripcion }}
                @elseif($mov->subject)
                    {{ class_basename($mov->subject_type) }} #{{ $mov->subject_id }}
                @else
                    —
                @endif
            </td>
            <td>{{ $mov->observaciones }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No hay movimientos para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
