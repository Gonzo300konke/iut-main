<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autenticación por Defecto
    |--------------------------------------------------------------------------
    |
    | Esta opción controla la "guardia" de autenticación y la configuración de
    | la contraseña por defecto. Puedes cambiar estos valores predeterminados
    | según los requisitos de tu aplicación.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios', // Usamos "usuarios" en lugar de "users"
    ],

    /*
    |--------------------------------------------------------------------------
    | Guardias de Autenticación
    |--------------------------------------------------------------------------
    |
    | Las guardias de autenticación definen cómo se autentican los usuarios en
    | cada solicitud. Laravel incluye una excelente implementación "session"
    | basada en sesiones, ideal para aplicaciones web tradicionales.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios', // Apunta al nuevo proveedor
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Proveedores de Usuarios
    |--------------------------------------------------------------------------
    |
    | Todos los proveedores de autenticación tienen un "proveedor" de usuarios
    | que define cómo se recuperan los usuarios de tu base de datos.
    |
    | Aquí estamos definiendo un nuevo proveedor llamado 'usuarios'.
    |
    */

    'providers' => [
        'usuarios' => [ // NUEVO PROVEEDOR
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class, // ¡APUNTANDO A TU MODELO!
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Restablecimiento de Contraseñas
    |--------------------------------------------------------------------------
    |
    | Puedes especificar múltiples configuraciones de restablecimiento de
    | contraseña si lo necesitas.
    |
    */

    'passwords' => [
        'usuarios' => [ // Usamos "usuarios" para el reseteo
            'provider' => 'usuarios',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Opciones de Creación de Contraseñas
    |--------------------------------------------------------------------------
    |
    | Puedes especificar opciones sobre cómo Laravel debe crear y almacenar
    | los hashes de contraseña.
    |
    */

    'password_timeout' => 10800,

];
