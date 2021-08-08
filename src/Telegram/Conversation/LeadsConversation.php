<?php


namespace Tii\LaravelTelegramBot\Telegram\Conversation;

use Longman\TelegramBot\Entities\Update;

/**
 * Trait LeadsConversation
 * @package Tii\LaravelTelegramBot
 * @method Update getUpdate()
 */
trait LeadsConversation
{

    /**
     * @internal
     */
    protected ?ConversationWrapper $conversation;

    /**
     * @param  string|null  $key
     * @param  string|null  $default
     * @return ?ConversationWrapper|mixed
     */
    protected function conversation(string $key = null, string $default = null)
    {
        if (! isset($this->conversation)) {
            $update = $this->getUpdate();

            if ($message = $update?->getMessage()) {
                $user = $message->getFrom();
                $chat = $message->getChat();
            } elseif ($callbackQuery = $update?->getCallbackQuery()) {
                $user = $callbackQuery->getFrom();
                $chat = $callbackQuery->getMessage()?->getChat();
            }

            if (! isset($user) || ! isset($chat)) {
                return null;
            }

            $this->conversation = new ConversationWrapper(
                user_id: $user->getId(),
                chat_id: $chat->getId(),
                command: $this->getName()
            );
        }

        if (isset($key)) {
            return $this->conversation->get($key, $default);
        }

        return $this->conversation;
    }

}
