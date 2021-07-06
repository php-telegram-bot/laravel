<?php


namespace Tii\LaravelTelegramBot\Telegram\Commands;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Tii\LaravelTelegramBot\RemembersCallbackPayload;

class CallbackqueryCommand extends SystemCommand
{
    use RemembersCallbackPayload;

    protected $name = 'callbackquery';
    protected $description = 'Handles CallbackQueries';
    protected $version = '1.0';

    public function execute(): ServerResponse
    {
        $callbackQuery = $this->getCallbackQuery();

        // Check if we have data for that hash in the Cache
        if ($data = $this->getCallbackPayload()) {
            $class = $data['__class'] ?? null;
            if (class_exists($class) && is_subclass_of($class, Command::class)) {
                /** @var Command $command */
                $command = new $class($this->telegram, $this->update);
                return $command->execute();
            }
        }

        // Check if conversation is active
        $user = $callbackQuery->getFrom() ?? null;
        $chat = $callbackQuery->getMessage()->getChat() ?? null;
        $conversation = new Conversation($user->getId(), $chat->getId());
        if ($conversation->exists() && $command = $conversation->getCommand()) {
            return $this->getTelegram()->executeCommand($command);
        }

        // Check if own CallbackqueryCommand class is available
        $class = App::getNamespace().'Telegram\\Commands\\CallbackqueryCommand';
        if (class_exists($class) && is_subclass_of($class, SystemCommand::class)) {
            /** @var SystemCommand $command */
            $command = new $class($this->telegram, $this->update);
            return $command->execute();
        }

        return Request::emptyResponse();
    }
}
