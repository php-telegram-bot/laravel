<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Longman\TelegramBot\Telegram;

class BotSetWebhookCommand extends Command
{
    protected $signature = 'bot:set-webhook
                            {hostname? : Hostname to set}
                            {--d|drop-pending-updates : Pass to drop all pending updates}';

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

        $response = $bot->setWebhook($url, $options);

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info("Telegram Webhook set to <comment>{$url}</comment>");
    }
}
