<?php

namespace PhpTelegramBot\Laravel\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramDeleteWebhookCommand extends Command
{
    protected $signature = 'telegram:delete-webhook
                            {--d|drop-pending-updates : Pass to drop all pending updates}';

    protected $description = 'Use this method to remove webhook integration if you decide to switch back to getUpdates';

    public function handle(Telegram $bot)
    {
        $options = [];
        if ($this->option('drop-pending-updates')) {
            $options['drop_pending_updates'] = true;
        }

        $response = Request::deleteWebhook($options);

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info($response->getDescription());
    }
}
