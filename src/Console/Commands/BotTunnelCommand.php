<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Str;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Symfony\Component\Process\Process;

class BotTunnelCommand extends Command implements SignalableCommandInterface
{
    protected $signature = 'bot:tunnel {--s|subdomain=}';

    protected $description = 'Creates a tunnel for local development.';

    public function handle(Telegram $bot)
    {
        $subdomain = $this->option('subdomain') ?: \Str::kebab(config('app.name'));
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
        $webhookUrl = $host . route('telegram.webhook', [], false);
        try {
            $bot->setWebhook($webhookUrl, [
                'drop_pending_updates' => true
            ]);
        } catch (TelegramException $e) {
            $this->error($e->getMessage());
            return;
        }

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
