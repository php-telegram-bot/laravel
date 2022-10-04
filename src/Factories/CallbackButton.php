<?php


namespace PhpTelegramBot\Laravel\Factories;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

class CallbackButton
{

    protected string $className;
    protected array $data;

    public function __call(string $name, array $arguments): self
    {
        // ->withXxxxx($value)
        if (Str::startsWith($name, 'with')) {
            $key = (string) Str::of($name)->after('with')->snake();
            $value = head($arguments);

            return $this->with($key, $value);
        }

        throw new \BadMethodCallException("Call to undefined method CallbackButton::{$name}()");
    }

    public function with(string $key, mixed $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function new(): self
    {
        return clone $this;
    }

    public function returnTo(string $className): self
    {
        $this->className = $className;
        return $this;
    }

    public function make(string $text, array $payload = []): InlineKeyboardButton
    {
        // Find valid hash
        do {
            $hash = Str::random(32);
            $cacheKey = 'CallbackQuery:'.$hash;
        } while (Cache::has($cacheKey));

        // Save payload
        $payload = $payload + $this->data;
        if (isset($this->className)) {
            $payload['__class'] = $this->className;
        }
        Cache::put($cacheKey, $payload);

        // Assemble button
        return new InlineKeyboardButton([
            'text'          => $text,
            'callback_data' => $hash
        ]);
    }

}
