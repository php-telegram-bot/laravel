<?php

Route::any('/api/telegram', static function (\Longman\TelegramBot\Telegram $bot) {
    $bot->handle();
})->middleware('telegram.network')->name('telegram.webhook');
