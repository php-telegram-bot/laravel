<?php

Route::post('/api/telegram', static function (\Longman\TelegramBot\Telegram $bot) {
    $bot->handle();
})->name('telegram.webhook');
