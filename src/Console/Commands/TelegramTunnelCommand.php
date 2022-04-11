<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Symfony\Component\Process\Process;

class TelegramTunnelCommand extends Command implements SignalableCommandInterface
{
    protected $signature = 'telegram:tunnel';

    protected $description = 'Creates a tunnel for local development.';

    public function handle(Telegram $bot)
    {
        $subdomain = config('expose.subdomain') ?? Str::kebab(config('app.name'));
        $exposeHost = config('expose.host');
        $exposePort = config('expose.port');
        $exposeToken = config('expose.token');

        $options = collect([
            base_path('vendor/bin/expose'),
            'share', config('app.url'),
            '--subdomain', $subdomain
        ]);

        if (isset($exposeHost)) {
            $options->push('--server-host', $exposeHost);
        }
        if (isset($exposePort)) {
            $options->push('--server-port', $exposePort);
        }
        if (isset($exposeToken)) {
            $options->push('--auth', $exposeToken);
        }

        $process = new Process($options->toArray());
        $process->setTimeout(0);
        $process->setIdleTimeout(0);
        $process->start();

        /** @var Collection $host */
        $process->waitUntil(function ($type, $output) use (&$host) {
            $host = Str::of($output)->match('/Expose-URL:\s+(.+)\b/');
            return $host->isNotEmpty();
        });

        if ($host->isEmpty()) {
            $this->error($process->getOutput());
            return;
        }

        // Register Webhook to Telegram
        $webhookUrl = $host . route('telegram.webhook', [
                'token' => config('telegram.bot.api_token')
            ], false);
        $bot->setWebhook($webhookUrl, [
            'drop_pending_updates' => true
        ]);

        $this->info('Registered Telegram Webhook on <comment>' . $webhookUrl . '</comment>');
        $process->wait();
    }

    public function getSubscribedSignals(): array
    {
        return [SIGINT];
    }

    public function handleSignal(int $signal): void
    {
        $response = Request::deleteWebhook([
            'drop_pending_updates' => true
        ]);

        if ($response->getResult()) {
            $this->info('Telegram Webhook was deleted');
        } else {
            $this->error('Could not delete Telegram Webhook');
        }

        exit;
    }
}
