<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Reporte' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { margin: 0 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; }
        th { background: #f0f0f0; }
        .small { font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <h1>{{ $titulo ?? 'Reporte' }}</h1>
    @isset($subtitulo)
        <h3>{{ $subtitulo }}</h3>
    @endisset

    <p class="small">
        Generado el {{ ($generadoEn ?? now())->format('d/m/Y H:i') }}
    </p>

    {{-- Este archivo es una plantilla genérica de respaldo. La mayoría de los reportes
         usan vistas más específicas en reportes/pdf/*.blade.php --}}

    @yield('contenido')
</body>
</html>
