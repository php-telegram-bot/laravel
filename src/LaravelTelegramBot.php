<?php

namespace Tii\LaravelTelegramBot;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Update;
use Tii\LaravelTelegramBot\Telegram\Conversation\ConversationWrapper;

class LaravelTelegramBot
{

    protected array $conversation = [];

    public function conversation(callable $closure)
    {
        $this->conversation[] = $closure;
    }

    public function callConversation(Update $update, ConversationWrapper $conversation): ?ServerResponse
    {
        foreach ($this->conversation as $callback) {
            $return = $callback($update, $conversation);

            if ($return instanceof ServerResponse) {
                return $return;
            }
        }
    }

}
