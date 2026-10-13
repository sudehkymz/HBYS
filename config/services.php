<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services / AI Model Integrations
    |--------------------------------------------------------------------------
    */

    'openai' => [
        'api_key' => env('OPENAI_API_KEY', ''),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
    ],
];
