<?php

namespace Tii\LaravelTelegramBot;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

/**
 * Trait CallbackQueryCache
 * @package Tii\LaravelTelegramBot\Services
 * @mixin Command
 */
trait RemembersCallbackPayload
{

    protected function makeInlineButton(string $text, array $payload = [], string $className = null)
    {
        // Find valid hash
        do {
            $hash = Str::random(32);
            $cacheKey = 'CallbackQuery:'.$hash;
        } while (Cache::has($cacheKey));

        // Assemble button
        $button = new InlineKeyboardButton([
            'text' => $text,
            'callback_data' => $hash
        ]);

        // Save payload
        $payload['__class'] = $className ?? get_class($this);
        Cache::put($cacheKey, $payload);

        return $button;
    }

    protected function getCallbackPayload(CallbackQuery $callbackQuery = null): ?array
    {
        $callbackQuery ??= $this->getCallbackQuery();
        $data = $callbackQuery->getData();
        $cacheKey = 'CallbackQuery:'.$data;

        if (! Cache::has($cacheKey)) {
            return null;
        }

        return Cache::get($cacheKey);
    }

}
