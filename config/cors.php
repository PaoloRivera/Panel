<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CORS Options
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar los ajustes para solicitudes de diferentes orígenes (CORS).
    |
    */

    'paths' => ['*'], // Permite CORS en todas las rutas (puedes restringir según sea necesario)

    'allowed_methods' => ['*'], // Permite todos los métodos (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => [
        'http://127.0.0.1:5173',
        'http://localhost:5173',
        'http://127.0.0.1:8080',
        'http://localhost:8080',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Permite todos los encabezados

    'exposed_headers' => ['Authorization', 'X-RateLimit-Limit', 'X-RateLimit-Remaining'],

    'max_age' => 0,

    'supports_credentials' => true, // Si usas cookies de sesión o autenticación con Sanctum, déjalo en true

];
