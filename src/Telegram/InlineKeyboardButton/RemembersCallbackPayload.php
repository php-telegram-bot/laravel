<?php

namespace Tii\LaravelTelegramBot\Telegram\InlineKeyboardButton;


use Illuminate\Support\Facades\Cache;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Entities\Update;

/**
 * Trait CallbackQueryCache
 * @package Tii\LaravelTelegramBot\Services
 * @method Update getUpdate()
 */
trait RemembersCallbackPayload
{
    /**
     * @var CallbackPayload
     * @internal
     */
    private CallbackPayload $payload;

    /**
     * @param string|null $key
     * @param string|null $default
     * @return CallbackPayload|null|mixed
     */
    protected function payload(string $key = null, string $default = null)
    {
        if (! isset($this->payload)) {
            $update = $this->getUpdate();
            $data = $update->getCallbackQuery()?->getData();
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

        if (isset($key)) {
            return $this->payload->get($key, $default);
        }

        return $this->payload;
    }

}
