<?php

namespace PhpTelegramBot\Laravel\Telegram;

use Longman\TelegramBot\Entities\Chat;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Entities\User;

trait UsesEffectiveEntities
{

    protected function getEffectiveUser(Update $update): ?User
    {
        $type = $update->getUpdateType();

        $user = $update->$type['from']
            ?? $update->poll_answer['user']
            ?? null;

        return $user ? new User($user) : null;
    }

    protected function getEffectiveChat(Update $update): ?Chat
    {
        $type = $update->getUpdateType();

        $chat = $update->$type['chat']
            ?? $update->callback_query['message']['chat']
            ?? null;

        return $chat ? new Chat($chat) : null;
    }

    protected function getEffectiveMessage(Update $update): ?Message
    {
        $message = $update->edited_channel_post
            ?? $update->channel_post
            ?? $update->callback_query['message']
            ?? $update->edited_message
            ?? $update->message
            ?? null;

        return $message ? new Message($message) : null;
    }

}