<?php


namespace PhpTelegramBot\Laravel\Telegram\InlineKeyboardButton;


class CallbackPayload
{

    public function __construct(protected array $payload)
    {
    }

    public function all(): array
    {
        return $this->payload;
    }

    public function get(string $key, string $default = null): mixed
    {
        return data_get($this->payload, $key, $default);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

}
