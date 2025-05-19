<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Aquí puedes controlar el guard por defecto y las opciones de reseteo
    | de contraseña. Hemos añadido el guard "api" para Sanctum usando el
    | provider "usuarios".
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Define cada guard de autenticación para tu aplicación. Hemos añadido
    | el guard "api" con driver Sanctum apuntando al provider "usuarios".
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'usuarios',
        ],

        'api' => [
            'driver'   => 'sanctum',
            'provider' => 'usuarios',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Define cómo se recuperan los usuarios desde tu almacenamiento de datos.
    | Aquí hemos configurado el provider "usuarios" para que use el modelo
    | App\Models\Usuario.
    |
    */

    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Usuario::class,
        ],

        // Si quisieras usar el modelo User por defecto, podrías dejar:
        // 'users' => [
        //     'driver' => 'eloquent',
        //     'model'  => App\Models\User::class,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    |
    | Configura las opciones de restablecimiento de contraseña para el provider
    | "usuarios".
    |
    */

    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Duración en segundos antes de que caduque la confirmación de contraseña.
    |
    */

    'password_timeout' => 10800,

];
