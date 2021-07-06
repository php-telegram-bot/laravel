<?php

namespace Tii\LaravelTelegramBot;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Tii\LaravelTelegramBot\Telegram\CallbackPayload;

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
            'text'          => $text,
            'callback_data' => $hash
        ]);

        // Save payload
        $payload['__class'] = $className ?? get_class($this);
        Cache::put($cacheKey, $payload);

        return $button;
    }

    /**
     * @var CallbackPayload
     * @internal
     */
    private CallbackPayload $payload;

    protected function payload(): ?CallbackPayload
    {
        if (! isset($this->payload)) {
            $callbackQuery ??= $this->getCallbackQuery();
            $data = $callbackQuery->getData();
            $cacheKey = 'CallbackQuery:'.$data;

            if (! Cache::has($cacheKey)) {
                return null;
            }

            $payload = Cache::get($cacheKey);
            $this->payload = new CallbackPayload($payload);
        }

        return $this->payload;
    }

}
