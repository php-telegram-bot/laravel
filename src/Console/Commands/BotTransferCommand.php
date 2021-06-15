<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class BotTransferCommand extends Command
{
    protected $signature = 'bot:transfer
                            {hostname? : Hostname of the new Telegram Bot API Server}
                            {--r|reset : Resets the Bot API Url}';

    protected $description = 'Transfers the Bot to another Bot Api Server';

    public function handle(Telegram $bot)
    {
        if (! $this->argument('hostname') && ! $this->option('reset')) {
            $this->warn('You need to specify either a hostname or the -r flag to reset to the original Bot API Servers');
            return;
        }

        $hostname = $this->option('reset') ? '' : $this->argument('hostname');

        $response = Request::logOut();
        if (! $response->isOk()) {
            $this->error($response->getDescription());
            return;
        }

        $this->setDotEnvVariable('TELEGRAM_API_URL', $hostname,
            comment: 'Don\'t edit directly. Call `php artisan bot:transfer` instead'
        );

        if ($this->option('reset')) {
            $this->info('Bot API URL reset to <comment>https://api.telegram.org</comment>');
        } else {
            $this->info("Bot API Url set to: <comment>{$hostname}</comment>");
        }
    }

    protected function setDotEnvVariable($key, $value, $comment = null)
    {
        $dotEnv = file_get_contents(base_path('.env'));

        if ($comment) {
            $value .= ' # ' . $comment;
        }

        $found = false;
        $newFile = '';
        foreach (explode("\n", $dotEnv) as $line) {
            if (Str::of($line)->before('=')->trim() == $key) {
                $line = $key . '=' . $value;
                $found = true;
            }

            $newFile .= $line . "\n";
        }

        if (! $found) {
            $newFile .= $key . '=' . $value . "\n";
        }

        file_put_contents(base_path('.env'), $newFile);
    }
}
