<?php

return [
    'bot' => [
        'api_token' => env('TELEGRAM_API_TOKEN'),

        'username' => env('TELEGRAM_BOT_USERNAME', ''),

        'api_url' => env('TELEGRAM_API_URL'),
    ],

    'admins' => env('TELEGRAM_ADMINS', '')

];
