<?php

return [
    /**
     * Bot configuration
     */
    'bot' => [
        'name'    => env('PHP_TELEGRAM_BOT_NAME', 'Test Name'),
        'api_key' => env('PHP_TELEGRAM_BOT_API_KEY', '489567508:AAEJgd80WMYbl7NisJYpkWCJLt2o_0RkpXs'),
    ],

    /**
     * Database integration
     */
    'database' => [
        'enabled'    => false,
        'connection' => env('DB_CONNECTION', 'mysql'),
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

    'admins' => [
        // Admin ids
    ],

    /**
     * Request limiter
     */
    'limiter' => [
        'enabled'  => false,
        'interval' => 1,
    ],

    'upload_path'   => '',
    'download_path' => '',
];
