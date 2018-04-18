<?php

return [
    /**
     * Bot configuration
     */
    'bot' => [
        'name'    => env('PHP_TELEGRAM_BOT_NAME', ''),
        'api_key' => env('PHP_TELEGRAM_BOT_API_KEY', ''),
    ],

    'database' => [
        'enabled'    => false,
        'connection' => 'default',
    ],

];
