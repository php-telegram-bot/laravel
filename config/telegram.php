<?php

return [
    'bot' => [
        'api_url' => env('TELEGRAM_API_URL'),

        'api_token' => env('TELEGRAM_API_TOKEN'),

        'username' => env('TELEGRAM_BOT_USERNAME', '')
    ],

    'admins' => env('TELEGRAM_ADMINS', '')

];
