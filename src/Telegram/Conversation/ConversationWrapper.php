<?php

namespace PhpTelegramBot\Laravel\Telegram\Conversation;

use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Update;

class ConversationWrapper
{

    protected Conversation $conversation;
    protected array $temporary = [];

    public function __construct(Update $update, $command = '')
    {
        if ($message = $update->getMessage() ?? $update->getEditedMessage()) {
            $user = $message->getFrom();
            $chat = $message->getChat();
        } elseif ($callbackQuery = $update->getCallbackQuery()) {
            $user = $callbackQuery->getFrom();
            $chat = $callbackQuery->getMessage()?->getChat();
        }

        // TODO: Use getEffective*() Methods that should be created in \Bot Facade

        if (! isset($user) || ! isset($chat)) {
            throw new \InvalidArgumentException('Could not determine user or chat for ConversationWrapper');
        }

        $this->conversation = new Conversation(
            user_id: $user->getId(),
            chat_id: $chat->getId(),
            command: $command
        );

        $notes = &$this->conversation->notes;
        $notes['vars'] ??= [];
        $notes['persist'] ??= [];

        if ($this->conversation->exists()) {
            // Remove temporary variables
            foreach ($notes['vars'] as $key => $value) {
                if (array_search($key, $notes['persist']) === false) {
                    // Is temporary
                    $this->temporary[$key] = $value;
                    unset($notes['vars'][$key]);
                }
            }
            $this->conversation->update();
        }
    }

    public function all(): array
    {
        return $this->conversation->notes['vars'] + $this->temporary;
    }

    public function get(string $key, string $default = null): mixed
    {
        return data_get($this->conversation->notes['vars'], $key)
            ?? data_get($this->temporary, $key, $default);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function persist(array $data): self
    {
        $notes = &$this->conversation->notes;
        foreach ($data as $key => $value) {
            $notes['vars'][$key] = $value;
            $notes['persist'][] = $key;
        }
        $this->conversation->update();

        return $this;
    }

    public function remember(array $data = [], bool $keepPreviousData = false): self
    {
        $notes = &$this->conversation->notes;

        if ($keepPreviousData) {
            foreach ($this->temporary as $key => $value) {
                $notes['vars'][$key] = $value;
            }
        }

        foreach ($data as $key => $value) {
            $notes['vars'][$key] = $value;
            $index = array_search($key, $notes['persist']);
            if ($index !== false) {
                unset($notes['persist'][$index]);
            }
        }

        $notes['persist'] = array_values($notes['persist']);
        $this->conversation->update();
        return $this;
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
