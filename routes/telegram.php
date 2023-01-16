<?php

Route::post('/api/telegram/webhook/{token}', static function (\Longman\TelegramBot\Telegram $bot, $token) {
    if ($token != config('telegram.bot.secret_token')) {
        abort(400);
    }

    $bot->handle();
})->middleware('telegram.network')->name('telegram.webhook');
