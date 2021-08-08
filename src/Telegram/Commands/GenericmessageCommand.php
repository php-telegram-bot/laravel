<?php

namespace Tii\LaravelTelegramBot\Telegram\Commands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Tii\LaravelTelegramBot\Facades\Bot;
use Tii\LaravelTelegramBot\Telegram\Conversation\ConversationWrapper;
use Tii\LaravelTelegramBot\Telegram\UsesEffectiveEntities;

class GenericmessageCommand extends SystemCommand
{
    use UsesEffectiveEntities;

    protected $name = 'genericmessage';
    protected $description = 'Handles Genericmessages';
    protected $version = '1.0';

    public function execute(): ServerResponse
    {
        $user = $this->getEffectiveUser();
        $chat = $this->getEffectiveChat();

        // Check Conversation
        $conversation = new ConversationWrapper(
            user_id: $user->getId(),
            chat_id: $chat->getId()
        );

        if ($conversation->exists()) {
            $return = Bot::callConversation($this->getUpdate(), $conversation);
            if ($return instanceof ServerResponse) {
                return $return;
            }

            if ($command = $conversation->getConversation()->getCommand()) {
                return $this->getTelegram()->executeCommand($command);
            }
        }

        return Request::emptyResponse();
    }

}