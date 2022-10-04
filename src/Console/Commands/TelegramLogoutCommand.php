<?php

namespace PhpTelegramBot\Laravel\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramLogoutCommand extends Command
{
    protected $signature = 'telegram:logout';

    protected $description = 'Sends a logout to the currently registered Telegram Server';

    public function handle(Telegram $bot)
    {
        $response = Request::logOut();

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info($response->getDescription());
    }
}
