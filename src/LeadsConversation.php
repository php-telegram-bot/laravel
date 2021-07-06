<?php


namespace Tii\LaravelTelegramBot;

use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Entity;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Tii\LaravelTelegramBot\Telegram\ConversationWrapper;

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

    protected function conversation(): ?ConversationWrapper
    {
        if (! isset($this->conversation)) {
            if ($message = $this->getMessage()) {
                $user = $message->getFrom();
                $chat = $message->getChat();
            } else if ($callbackQuery = $this->getCallbackQuery()) {
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

        return $this->conversation;
    }

}
