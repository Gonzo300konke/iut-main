# Sistema de Auditoría

## Descripción

Sistema completo de auditoría que registra todas las operaciones (CREATE, UPDATE, DELETE) en la base de datos, incluyendo:
- Usuario que realizó la acción
- Tabla y registro modificado
- Valores anteriores y nuevos
- Timestamp de la acción
- IP del usuario
- User Agent del navegador

## Tabla `auditoria`

```sql
CREATE TABLE auditoria (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT UNSIGNED NULL,
    tabla VARCHAR(100) NOT NULL,
    registro_id BIGINT UNSIGNED NOT NULL,
    operacion ENUM('CREATE', 'UPDATE', 'DELETE') NOT NULL,
    valores_anteriores JSON NULL,
    valores_nuevos JSON NULL,
    descripcion TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_auditoria_tabla_registro (tabla, registro_id),
    INDEX idx_auditoria_usuario_fecha (usuario_id, created_at),
    INDEX idx_auditoria_tabla_operacion (tabla, operacion),
    INDEX idx_auditoria_fecha (created_at)
);
```

## Uso

### 1. Usando el Trait AuditableTrait (Automático)

Agrega el trait a cualquier modelo que desees auditar:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;

class Bien extends Model
{
    use AuditableTrait;
    
    protected $table = 'bienes';
    // ... resto del modelo
}
```

Esto registrará automáticamente todas las operaciones CREATE, UPDATE y DELETE.

### 2. Registro Manual

Si necesitas registrar eventos específicos o personalizados:

```php
use App\Models\Auditoria;

Auditoria::registrar(
    tabla: 'bienes',
    registro_id: 1,
    operacion: 'UPDATE',
    valores_anteriores: ['estado' => 'ACTIVO'],
    valores_nuevos: ['estado' => 'DAÑADO'],
    descripcion: 'Cambio de estado: ACTIVO -> DAÑADO'
);
```

### 3. Consultar Auditoría

```php
use App\Models\Auditoria;

// Auditoría de un bien específico
$auditoria = Auditoria::where('tabla', 'bienes')
    ->where('registro_id', 1)
    ->orderBy('created_at', 'desc')
    ->get();

// Auditoría por usuario
$auditoria = Auditoria::where('usuario_id', auth()->id())
    ->orderBy('created_at', 'desc')
    ->limit(50)
    ->get();

// Auditoría por operación
$creaciones = Auditoria::where('operacion', 'CREATE')->get();
$eliminaciones = Auditoria::where('operacion', 'DELETE')->get();

// Auditoría en rango de fechas
$auditoria = Auditoria::whereBetween('created_at', [$inicio, $fin])->get();
```

### 4. Acceder a los datos

```php
$registro = Auditoria::find(1);

// Usuario que realizó la acción
$usuario = $registro->usuario;

// Información del cambio
$registro->tabla;              // 'bienes'
$registro->registro_id;        // 1
$registro->operacion;          // 'UPDATE'
$registro->valores_anteriores; // ['estado' => 'ACTIVO', ...]
$registro->valores_nuevos;     // ['estado' => 'DAÑADO', ...]
$registro->descripcion;        // 'Cambio de estado...'
$registro->ip_address;         // '192.168.1.1'
$registro->user_agent;         // 'Mozilla/5.0...'
$registro->created_at;         // timestamp de la acción
```

## Campos auditados automáticamente

Con el trait AuditableTrait, se auditan automáticamente los siguientes modelos (una vez que agregues el trait):

- `Bien` (bienes)
- `Movimiento` (movimientos)
- `Dependencia` (dependencias)
- `UnidadAdministradora` (unidades_administradoras)
- `Organismo` (organismos)
- `Usuario` (usuarios)
- etc.

## Consideraciones de rendimiento

- La tabla `auditoria` crecerá significativamente. Considera archivar registros antiguos.
- Los índices están optimizados para búsquedas frecuentes: tabla+registro, usuario+fecha, operación.
- Para consultas complejas, usa índices adicionales según tus necesidades.

## Ejemplo completo

```php
// Controller
public function actualizarBien(Request $request, $bien_id)
{
    $bien = Bien::find($bien_id);
    
    $bien->update($request->validated());
    
    // La auditoría se registra automáticamente gracias al trait
    
    return response()->json(['success' => true, 'bien' => $bien]);
}

// Consultar cambios posteriores
$auditoria = Auditoria::where('tabla', 'bienes')
    ->where('registro_id', $bien_id)
    ->where('operacion', 'UPDATE')
    ->latest()
    ->get();
```

## Modificar el timestamp de cambio de estado

En la tabla `bienes`, se agregó el campo `fecha_cambio_estado` para registrar cuándo cambió el estado:

```php
$bien = Bien::find(1);
$bien->update([
    'estado' => 'DAÑADO',
    'fecha_cambio_estado' => now()
]);

// Se registra automáticamente en auditoría
```
