<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mikrotik Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the mikrotik connections below you wish
    | to use as your default connection for all router work.
    |
    */

    'default' => env('MIKROTIK_ROS7_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Mikrotik Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the mikrotik connections setup for your application.
    | This supports a hybrid approach: you can define static connections
    | here (e.g. for testing) or pass dynamic arrays from your database
    | (like the `routers` table) directly to the Facade at runtime.
    |
    */

    'connections' => [

        'default' => [
            'host'       => env('MIKROTIK_ROS7_HOST', '192.168.1.1'),
            'username'   => env('MIKROTIK_ROS7_USERNAME', 'admin'),
            'password'   => env('MIKROTIK_ROS7_PASSWORD', ''),
            'port'       => env('MIKROTIK_ROS7_PORT', 443),
            'verify_ssl' => env('MIKROTIK_ROS7_VERIFY_SSL', false),
            'timeout'    => env('MIKROTIK_ROS7_TIMEOUT', 10),
            'debug'      => env('MIKROTIK_ROS7_DEBUG', false),
        ],

    ],
];
