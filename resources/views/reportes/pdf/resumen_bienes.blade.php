@extends('reportes.pdf')

@section('contenido')
<table>
    <thead>
        <tr>
            @if($dimension === 'estado')
                <th>Estado</th>
            @elseif($dimension === 'dependencia')
                <th>Dependencia</th>
            @elseif($dimension === 'tipo_bien')
                <th>Tipo de bien</th>
            @else
                <th>Clave</th>
            @endif
            <th>Cantidad de bienes</th>
            <th>Total estimado</th>
        </tr>
    </thead>
    <tbody>
    @forelse($resumen as $fila)
        <tr>
            <td>
                @if($dimension === 'estado')
                    {{ $fila->estado ?? 'N/D' }}
                @elseif($dimension === 'dependencia')
                    {{ $fila->dependencia->nombre ?? ('ID '.$fila->dependencia_id) }}
                @elseif($dimension === 'tipo_bien')
                    {{ $fila->tipo_bien ?? 'N/D' }}
                @else
                    {{ $fila->clave ?? 'N/D' }}
                @endif
            </td>
            <td style="text-align:right;">{{ (int) $fila->cantidad }}</td>
            <td style="text-align:right;">{{ number_format((float)($fila->total ?? 0), 2, ',', '.') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No hay datos para mostrar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
