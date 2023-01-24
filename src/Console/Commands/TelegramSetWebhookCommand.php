<?php

namespace PhpTelegramBot\Laravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;

class TelegramSetWebhookCommand extends Command
{
    protected $signature = 'telegram:set-webhook
                            {hostname? : Hostname to set}
                            {--d|drop-pending-updates : Drop all pending updates}
                            {--a|all-update-types : Explicitly allow all updates (including "chat_member")}
                            {--allowed-updates= : Define allowed updates (comma-seperated)}';

    protected $description = 'Use this method to specify a url and receive incoming updates via an outgoing webhook';

    public function handle(Telegram $bot)
    {
        $hostname = $this->argument('hostname');
        if (! $hostname) {
            $hostname = $this->ask('Which hostname do you like to set?', config('app.url'));
        }

        if (! Str::of($hostname)->startsWith('http')) {
            $schema = match (app()->environment()) {
                'local' => 'http',
                default => 'https'
            };
            $hostname = "{$schema}://{$hostname}";
        }

        $url = $hostname . route('telegram.webhook', [
                'token' => config('telegram.bot.api_token')
            ], false);

        $options = [];
        if ($this->option('drop-pending-updates')) {
            $options['drop_pending_updates'] = true;
        }

        if ($this->option('all-update-types')) {
            $options['allowed_updates'] = Update::getUpdateTypes();
        } elseif ($allowedUpdates = $this->option('allowed-updates')) {
            $options['allowed_updates'] = Str::of($allowedUpdates)->explode(',');
        }

        $response = $bot->setWebhook($url, $options);

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info("Telegram Webhook set to <comment>{$url}</comment>");
    }
}
