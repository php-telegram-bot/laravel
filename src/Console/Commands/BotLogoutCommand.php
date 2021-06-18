<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class BotLogoutCommand extends Command
{
    protected $signature = 'bot:logout';

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
