<?php


namespace PhpTelegramBot\Laravel\Telegram\Conversation;

use Longman\TelegramBot\Entities\Update;

/**
 * Trait LeadsConversation
 * @package PhpTelegramBot\Laravel
 * @method Update getUpdate()
 * @method string getName()
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
            $this->conversation = new ConversationWrapper($this->getUpdate(), $this->getName());
        }

        if (isset($key)) {
            return $this->conversation->get($key, $default);
        }

        return $this->conversation;
    }

}
