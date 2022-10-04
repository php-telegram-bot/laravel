<?php


namespace PhpTelegramBot\Laravel\Telegram\Commands;


use Illuminate\Support\Facades\App;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use PhpTelegramBot\Laravel\Facades\Telegram;
use PhpTelegramBot\Laravel\Telegram\Conversation\ConversationWrapper;
use PhpTelegramBot\Laravel\Telegram\InlineKeyboardButton\RemembersCallbackPayload;
use PhpTelegramBot\Laravel\Telegram\UsesEffectiveEntities;

class CallbackqueryCommand extends SystemCommand
{
    use RemembersCallbackPayload, UsesEffectiveEntities;

    protected $name = 'callbackquery';
    protected $description = 'Handles CallbackQueries';
    protected $version = '1.0';

    public function execute(): ServerResponse
    {
        $return = Telegram::call($this->getUpdate());
        if ($return instanceof ServerResponse) {
            return $return;
        }

        // Check if we have data for that hash in the Cache
        if ($class = $this->payload()?->get('__class')) {
            if (class_exists($class) && is_subclass_of($class, Command::class)) {
                /** @var Command $command */
                $command = new $class($this->telegram, $this->update);
                return $command->preExecute();
            }
        }

        // Check if conversation is active
        $user = $this->getEffectiveUser($this->getUpdate());
        $chat = $this->getEffectiveChat($this->getUpdate());

        $conversation = new Conversation(
            user_id: $user->getId(),
            chat_id: $chat->getId()
        );

        if ($conversation->exists() && ($command = $conversation->getCommand())) {
            return $this->getTelegram()->executeCommand($command);
        }

        // Check if own CallbackqueryCommand class is available
        $class = App::getNamespace() . 'Telegram\\Commands\\CallbackqueryCommand';
        if (class_exists($class) && is_subclass_of($class, SystemCommand::class)) {
            /** @var SystemCommand $command */
            $command = new $class($this->telegram, $this->update);
            return $command->preExecute();
        }

        return Request::emptyResponse();
    }
}
