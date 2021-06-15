<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Telegram;
use Str;

class BotRegisterCommand extends Command
{
    protected $signature = 'bot:register {hostname?}';

    protected $description = 'Registers the current webhook URL at Telegram';

    public function handle(Telegram $bot)
    {
        if ($url = $this->argument('hostname')) {

            if (! Str::of($url)->startsWith('http')) {
                $schema = match(app()->environment()) {
                    'local' => 'http',
                    default => 'https'
                };
                $url = "{$schema}://{$url}";
            }

            $url .= route('telegram.webhook', [], false);
        } else {
            $url = route('telegram.webhook');
        }

        $this->info($url);

        $response = $bot->setWebhook($url);

        if (! $response->isOk()) {
            $this->error($response->getDescription());
        }

        $this->info("Telegram Webhook registered as <comment>{$url}</comment>");
    }
}
