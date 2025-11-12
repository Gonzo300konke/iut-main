<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Unidad {{ $unidadAdministradora->codigo }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 24px;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.5;
        }
        h1, h2 { margin: 0 0 12px 0; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h1 {
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #111827;
        }
        .field { margin-bottom: 10px; }
        .field-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 14px;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 13px;
        }
        table thead { background: #f3f4f6; }
        table th,
        table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }
        .small {
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Gestión de Inventario de Bienes</h1>
        <p class="small">Reporte de Unidad Administradora</p>
    </div>

    <div class="section">
        <div class="section-title">Datos de la Unidad</div>
        <div class="field">
            <div class="field-label">Código</div>
            <div class="field-value">{{ $unidadAdministradora->codigo }}</div>
        </div>
        <div class="field">
            <div class="field-label">Nombre</div>
            <div class="field-value">{{ $unidadAdministradora->nombre }}</div>
        </div>
        <div class="field">
            <div class="field-label">Organismo</div>
            <div class="field-value">{{ $unidadAdministradora->organismo->nombre ?? '—' }}</div>
        </div>
        <div class="field">
            <div class="field-label">Fecha de creación</div>
            <div class="field-value">{{ optional($unidadAdministradora->created_at)->format('d/m/Y H:i') }}</div>
        </div>
        <div class="field">
            <div class="field-label">Última actualización</div>
            <div class="field-value">{{ optional($unidadAdministradora->updated_at)->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Dependencias Asociadas</div>
        <div class="field">
            <div class="field-label">Total registradas</div>
            <div class="field-value">{{ $unidadAdministradora->dependencias->count() }}</div>
        </div>

        @if ($unidadAdministradora->dependencias->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unidadAdministradora->dependencias as $dependencia)
                        <tr>
                            <td>{{ $dependencia->codigo }}</td>
                            <td>{{ $dependencia->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="small">No hay dependencias registradas para esta unidad.</p>
        @endif
    </div>

    <p class="small">Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>

