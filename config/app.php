<?php

return [

    'name' => env('APP_NAME', 'HBYS'),

    'env' => env('APP_ENV', 'local'),

    'debug' => (bool) env('APP_DEBUG', true),

    'url' => env('APP_URL', 'http://localhost:8000'),

    'timezone' => 'UTC',

    'locale' => 'tr',

    'fallback_locale' => 'en',

    'faker_locale' => 'tr_TR',

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    'maintenance' => [
        'driver' => 'file',
    ],

];