<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pipeline
    |--------------------------------------------------------------------------
    |
    | The pipeline for the feature to travel through.
    |
    */
    'pipeline' => ['database', 'in_memory'],
    
    //    'pipeline' => ['in_memory'], // remove 'database' temporarily

    /*
    |--------------------------------------------------------------------------
    | Gateways
    |--------------------------------------------------------------------------
    |
    | Configures the different gateway options
    |
    */

    'gateways' => [
        'in_memory' => [
            'file' => env('FEATURE_FLAG_IN_MEMORY_FILE', '.features.php'),
            'driver' => 'in_memory',
        ],
        'database' => [
            'driver' => 'database',
            'cache' => [
                'ttl' => 600,
            ],
            'connection' => env('FEATURE_FLAG_DATABASE_CONNECTION'),
            'table' => env('FEATURE_FLAG_DATABASE_TABLE', 'features'),
        ],
        'gate' => [
            'driver' => 'gate',
            'gate' => env('FEATURE_FLAG_GATE_GATE', 'feature'),
            'guard' => env('FEATURE_FLAG_GATE_GUARD'),
            'cache' => [
                'ttl' => 600,
            ],
        ],
        'redis' => [
            'driver' => 'redis',
            'prefix' => env('FEATURE_FLAG_REDIS_PREFIX', 'features'),
            'connection' => env('FEATURE_FLAG_REDIS_CONNECTION', 'default'),
        ],
    ],

    'flags' => [
        'new_dashboard' => [
            'description' => 'Enable the new dashboard design',
            'default' => true,
        ],
        'beta_feature' => [
            'description' => 'Enable beta feature for testing',
            'default' => false,
        ],
    ],
];
