<?php


namespace Tii\LaravelTelegramBot\Telegram\Commands;


use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class GenericmessageCommand extends SystemCommand
{

    protected $name = 'Genericmessage';
    protected $description = '';
    protected $version = '1.0.0';

    public function execute(): ServerResponse
    {
        if ($response = $this->executeActiveConversation()) {
            return $response;
        }

        // Check if GenericmessageCommand is defined
        $class = app()->getNamespace() . 'Telegram\Commands\GenericmessageCommand';
        if (is_subclass_of($this, SystemCommand::class)) {
            return (new $class($this->telegram, $this->update))->execute();
        }

        return Request::emptyResponse();
    }


}
