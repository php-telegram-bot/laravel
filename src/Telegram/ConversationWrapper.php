<?php

namespace Tii\LaravelTelegramBot\Telegram;

use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Telegram;

class ConversationWrapper
{

    protected Conversation $conversation;

    public function __construct($user_id, $chat_id, $command = '')
    {
        $this->conversation = new Conversation(
            user_id: $user_id,
            chat_id: $chat_id,
            command: $command
        );
    }

    public function all(): array
    {
        return $this->conversation->notes;
    }

    public function get(string $key, string $default = null): mixed
    {
        return data_get($this->conversation->notes, $key, $default);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function remember(array $data, bool $keepPreviousData = false)
    {
        if (! $keepPreviousData) {
            $this->conversation->notes = [];
        }

        foreach ($data as $key => $value) {
            $this->conversation->notes[$key] = $value;
        }

        $this->conversation->update();
    }

    public function exists(): bool
    {
        return $this->conversation->exists();
    }

    public function end(): void
    {
        $this->conversation->stop();
    }

    public function cancel(): void
    {
        $this->conversation->cancel();
    }

}
