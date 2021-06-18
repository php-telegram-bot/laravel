<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class BotCloseCommand extends Command
{
    protected $signature = 'bot:close';

    protected $description = 'Sends a close to the currently registered Telegram Server';

    public function handle(Telegram $bot)
    {
        $response = Request::close();

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info($response->getDescription());
    }
}
