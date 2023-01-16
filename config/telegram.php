<?php
return [
    'bot' => [
        'api_token' => env('TELEGRAM_API_TOKEN'),
        'secret_token' => env('TELEGRAM_SECRET_TOKEN'), // any unique string that will set for webhook link
        'username' => env('TELEGRAM_BOT_USERNAME', ''), // w/o @
        'api_url' => env('TELEGRAM_API_URL'),
    ],
    'admins' => env('TELEGRAM_ADMINS', '') // comma separated chatid's
];
