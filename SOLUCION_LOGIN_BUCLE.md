# Solución al Bucle Infinito en Login

## Problema
El sistema entraba en un bucle infinito al intentar iniciar sesión, impidiendo el acceso al sistema.

## Causas Identificadas

### 1. **Driver de Sesiones incorrecto**
- La configuración usaba `SESSION_DRIVER=database` pero la tabla `sessions` no existía en la base de datos
- Laravel no podía persistir la sesión después del login exitoso
- Esto causaba que el usuario pareciera no autenticado después del login

### 2. **Falta de Middleware RedirectIfAuthenticated**
- El middleware `guest` no estaba personalizado para el modelo `Usuario`
- Laravel usaba el middleware default que no funcionaba correctamente con la tabla `usuarios`

### 3. **Uso de `intended()` en redirecciones**
- El método `intended()` podía causar redirecciones circulares en algunos casos
- Se simplificó usando redirecciones directas

## Soluciones Aplicadas

### 1. Cambio del Driver de Sesiones
**Archivo modificado:** `.env`
```env
# Antes
SESSION_DRIVER=database

# Después
SESSION_DRIVER=file
```

**Razón:** El driver `file` es más simple y no requiere tabla adicional. Es perfecto para aplicaciones pequeñas/medianas.

### 2. Creación de Middleware Personalizado
**Archivo creado:** `app/Http/Middleware/RedirectIfAuthenticated.php`

Este middleware:
- Verifica si el usuario está autenticado
- Redirige según el rol del usuario (admin → usuarios, normal → bienes)
- Permite el acceso a rutas de login solo para usuarios no autenticados

**Registro del middleware:** `bootstrap/app.php`
```php
$middleware->alias([
    'redirigir.rol' => \App\Http\Middleware\RedirigirPorRol::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
]);
```

### 3. Simplificación de Redirecciones
**Archivo modificado:** `app/Http/Controllers/AuthController.php`

- Eliminado el uso de `intended()` 
- Redirecciones directas después del login
- Evita posibles redirecciones circulares

### 4. Configuración del Modelo Usuario
**Archivo modificado:** `app/Models/Usuario.php`

- Agregado `remember_token` a los atributos ocultos
- Asegura el correcto funcionamiento de la funcionalidad "Recordarme"

## Pasos para Verificar la Solución

1. **Limpiar cachés:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

2. **Limpiar sesiones antiguas:**
- Las sesiones antiguas se guardaron en `storage/framework/sessions/`
- Se eliminaron automáticamente para evitar conflictos

3. **Probar el login:**
- Acceder a `/login`
- Ingresar credenciales válidas
- El sistema debe redirigir correctamente según el rol

## Rutas del Sistema

### Públicas
- `/` - Página de inicio
- `/login` (GET) - Formulario de login
- `/login` (POST) - Procesar login

### Protegidas (requieren autenticación)
- `/bienes` - Gestión de bienes (todos los usuarios)
- `/usuarios` - Gestión de usuarios (solo admin)
- `/organismos`, `/dependencias`, `/responsables`, etc.

## Configuración de Autenticación

### Guardia Web
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'usuarios',
    ],
],
```

### Proveedor de Usuarios
```php
'providers' => [
    'usuarios' => [
        'driver' => 'eloquent',
        'model' => App\Models\Usuario::class,
    ],
],
```

## Notas Adicionales

### Si prefieres usar driver `database` para sesiones:
1. Crear la migración de sesiones:
```bash
php artisan session:table
php artisan migrate
```

2. Cambiar en `.env`:
```env
SESSION_DRIVER=database
```

### Ventajas del driver `file`:
- ✅ Más simple, sin configuración adicional
- ✅ No requiere tabla en base de datos
- ✅ Funciona inmediatamente
- ✅ Perfecto para desarrollo y aplicaciones medianas

### Ventajas del driver `database`:
- ✅ Mejor para múltiples servidores (load balancing)
- ✅ Permite consultas SQL sobre sesiones
- ✅ Fácil limpieza de sesiones expiradas

## Solución Completada ✓

El sistema ahora debe funcionar correctamente:
- ✅ Login sin bucles
- ✅ Sesiones persistentes
- ✅ Redirección según rol
- ✅ Funcionalidad "Recordarme"
- ✅ Logout correcto
