<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario {{ $usuario->nombre_completo }}</title>
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
        .tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .tag-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .tag-green {
            background: #dcfce7;
            color: #15803d;
        }
        .tag-red {
            background: #fee2e2;
            color: #b91c1c;
        }
        .tag-purple {
            background: #ede9fe;
            color: #6b21a8;
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
        <p class="small">Reporte de Usuario</p>
    </div>

    <div class="section">
        <div class="section-title">Información Personal</div>
        <div class="field">
            <div class="field-label">Nombre completo</div>
            <div class="field-value">{{ $usuario->nombre_completo }}</div>
        </div>
        <div class="field">
            <div class="field-label">Cédula</div>
            <div class="field-value">{{ $usuario->cedula }}</div>
        </div>
        <div class="field">
            <div class="field-label">Correo</div>
            <div class="field-value">{{ $usuario->correo }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Información del Sistema</div>
        <div class="field">
            <div class="field-label">Rol</div>
            <div class="field-value">
                <span class="tag tag-blue">{{ $usuario->rol->nombre ?? 'Sin asignar' }}</span>
            </div>
        </div>
        <div class="field">
            <div class="field-label">Estado</div>
            <div class="field-value">
                @if($usuario->activo)
                    <span class="tag tag-green">Activo</span>
                @else
                    <span class="tag tag-red">Inactivo</span>
                @endif
            </div>
        </div>
        @if($usuario->is_admin)
            <div class="field">
                <div class="field-label">Permisos</div>
                <div class="field-value">
                    <span class="tag tag-purple">Administrador</span>
                </div>
            </div>
        @endif
        <div class="field">
            <div class="field-label">Creado</div>
            <div class="field-value">{{ optional($usuario->created_at)->format('d/m/Y H:i') }}</div>
        </div>
        <div class="field">
            <div class="field-label">Actualizado</div>
            <div class="field-value">{{ optional($usuario->updated_at)->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Actividad</div>
        <div class="field">
            <div class="field-label">Reportes generados</div>
            <div class="field-value">{{ $usuario->reportes->count() }}</div>
        </div>
        <div class="field">
            <div class="field-label">Movimientos registrados</div>
            <div class="field-value">{{ $usuario->movimientos->count() }}</div>
        </div>
    </div>

    <p class="small">Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>

