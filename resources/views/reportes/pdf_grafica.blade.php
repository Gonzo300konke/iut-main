@extends('layouts.base')

@section('title', $title ?? 'Datos de gráfica')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg">
    <h1 class="text-2xl font-bold mb-4">{{ $title }}</h1>

    @if(!empty($filters))
        <div class="mb-4 text-sm text-gray-600">
            <strong>Filtros aplicados:</strong>
            <pre style="white-space:pre-wrap">{{ json_encode($filters, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    @endif

    <table style="width:100%; border-collapse:collapse; font-size:12px;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px; border-bottom:1px solid #ddd;">Etiqueta</th>
                <th style="text-align:right; padding:6px; border-bottom:1px solid #ddd;">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $label => $value)
                <tr>
                    <td style="padding:6px; border-bottom:1px solid #f3f3f3;">{{ $label }}</td>
                    <td style="padding:6px; border-bottom:1px solid #f3f3f3; text-align:right;">{{ is_numeric($value) ? number_format($value, 2, ',', '.') : $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
