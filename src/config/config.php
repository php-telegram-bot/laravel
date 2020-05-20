<?php

declare(strict_types=1);

return [
    /**
     * Bot configuration
     */
    'bot'      => [
        'name'    => env('PHP_TELEGRAM_BOT_NAME', ''),
        'api_key' => env('PHP_TELEGRAM_BOT_API_KEY', ''),
    ],

    /**
     * Database integration
     */
    'database' => [
        'enabled'    => false,
        'connection' => env('DB_CONNECTION', 'mysql'),
        'prefix'     => env('PHP_TELEGRAM_BOT_TABLE_PREFIX', ''),
    ],

    'commands' => [
        'before'  => true,
        'paths'   => [
            // Custom command paths
        ],
        'configs' => [
            // Custom commands configs
        ],
    ],

    'admins'  => [
        // Admin ids
    ],

    /**
     * Request limiter
     */
    'limiter' => [
        'enabled'  => false,
        'interval' => 1,
    ],

    'upload_path'   => env('PHP_TELEGRAM_BOT_UPLOAD_PATH', ''),
    'download_path' => env('PHP_TELEGRAM_BOT_DOWNLOAD_PATH', ''),
];
