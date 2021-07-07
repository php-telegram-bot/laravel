<?php

namespace Tii\LaravelTelegramBot\Telegram\InlineKeyboardButton;


use Illuminate\Support\Facades\Cache;
use Longman\TelegramBot\Commands\Command;
use Tii\LaravelTelegramBot\Telegram\CallbackPayload;

/**
 * Trait CallbackQueryCache
 * @package Tii\LaravelTelegramBot\Services
 * @mixin Command
 */
trait RemembersCallbackPayload
{
    /**
     * @var CallbackPayload
     * @internal
     */
    private CallbackPayload $payload;

    protected function payload(): ?CallbackPayload
    {
        if (! isset($this->payload)) {
            $data = $this->getCallbackQuery()?->getData();
            if ($data === null) {
                return null;
            }

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
