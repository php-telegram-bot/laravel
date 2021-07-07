<?php


namespace Tii\LaravelTelegramBot\Telegram\Conversation;

use Longman\TelegramBot\Commands\Command;

/**
 * Trait LeadsConversation
 * @package Tii\LaravelTelegramBot
 * @mixin Command
 */
trait LeadsConversation
{

    /**
     * @var ConversationWrapper
     * @internal
     */
    private ConversationWrapper $conversation;

    /**
     * @param string|null $key
     * @param string|null $default
     * @return ConversationWrapper|null|mixed
     */
    protected function conversation(string $key = null, string $default = null)
    {
        if (! isset($this->conversation)) {
            if ($message = $this->getMessage()) {
                $user = $message->getFrom();
                $chat = $message->getChat();
            } elseif ($callbackQuery = $this->getCallbackQuery()) {
                $user = $callbackQuery->getFrom();
                $chat = $callbackQuery->getMessage()?->getChat();
            } else {
                return null;
            }

            if (! $user || ! $chat) {
                return null;
            }

            $this->conversation = new ConversationWrapper(
                user_id: $user->getId(),
                chat_id: $chat->getId(),
                command: $this->getName(),
            );
        }

        if (isset($key)) {
            return $this->conversation->get($key, $default);
        }

        return $this->conversation;
    }

}
