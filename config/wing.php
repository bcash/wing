<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WING Console Configuration
    |--------------------------------------------------------------------------
    |
    | Default settings for Behringer WING console communication
    |
    */

    'default_ip' => env('WING_IP', '192.168.8.200'),
    'default_port' => env('WING_PORT', 2223),
    'default_rate' => env('WING_RATE', 15),

    'console' => [
        'model' => env('WING_MODEL', 'WING Rack'),
        'name' => env('WING_NAME', 'StarryNight'),
        'firmware' => env('WING_FIRMWARE', '3.1.0'),
        'wing_edit_version' => env('WING_EDIT_VERSION', '3.2.1'),
    ],

    'sync' => [
        'direction' => env('WING_SYNC_DIRECTION', 'Mixer → PC'),
        'auto_connect' => env('WING_AUTO_CONNECT', true),
        'auto_sync' => env('WING_AUTO_SYNC', true),
    ],

    'dump' => [
        'default_output' => env('WING_DUMP_OUTPUT', 'wing_dump'),
        'max_file_size' => 32768, // 32 KB
        'max_depth' => 10,
    ],
];

