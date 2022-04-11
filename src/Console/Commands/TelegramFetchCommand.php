<?php


namespace Tii\LaravelTelegramBot\Console\Commands;


use Illuminate\Console\Command;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Console\Command\SignalableCommandInterface;

class TelegramFetchCommand extends Command implements SignalableCommandInterface
{

    protected $signature = 'telegram:fetch';

    protected $description = 'Fetches Telegram updates periodically';

    protected bool $shallExit = false;

    public function handle(Telegram $bot)
    {
        $this->callSilent('bot:delete-webhook');

        $options = [
            'timeout' => 5
        ];

        $this->info("Start fetching updates...\n<comment>(Exit with Ctrl + C. This can take a few seconds.)</comment>");
        while (true) {
            if ($this->shallExit) {
                break;
            }

            try {
                $bot->handleGetUpdates($options);
            } catch (TelegramException $e) {
                // Only print message
                $this->error($e->getMessage());
            }
        }
    }

    public function getSubscribedSignals(): array
    {
        return [SIGINT];
    }

    public function handleSignal(int $signal): void
    {
        $this->shallExit = true;
    }
}