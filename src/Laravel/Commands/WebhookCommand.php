<?php

/*
 * This file is part of the PhpTelegramBot/Laravel package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpTelegramBot\Laravel\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

use function json_encode;

use const JSON_PRETTY_PRINT;

class WebhookCommand extends Command
{
    protected $signature = 'telegram:webhook {webhook?}
    {--delete : Delete webhook}
    {--info : Get webhook info}';

    protected $description = 'Set, delete, or get webhook info for Telegram Bot';

    /** @var \PhpTelegramBot\Laravel\PhpTelegramBotContract */
    protected $telegramBot;

    public function __construct(PhpTelegramBotContract $telegramBot)
    {
        parent::__construct();

        $this->telegramBot = $telegramBot;
    }

    public function handle(): void
    {
        $webhook = $this->argument('webhook');
        $delete  = $this->option('delete');
        $info    = $this->option('info');

        if (! ($webhook || $delete || $info)) {
            $this->error('Not enough arguments!');
            $this->error('php artisan telegram:webhook {webhook?} {--delete} {--info}');
            return;
        }

        if ($delete && ! $this->deleteWebhook()) {
            return;
        }

        if ($webhook && ! $this->setWebhook($webhook)) {
            return;
        }

        if ($info && ! $this->showWebhookInfo()) {
            return;
        }

        $this->info('All done!');
    }

    private function setWebhook(string $webhook): bool
    {
        try {
            $this->telegramBot->setWebhook($webhook);
            $this->info('Webhook set successfully!');
        } catch (TelegramException $e) {
            $this->error("Couldn't set webhook");
            $this->error($e->getMessage());
            return false;
        }

        return true;
    }

    private function deleteWebhook(): bool
    {
        try {
            $this->telegramBot->deleteWebhook();
            $this->info('Webhook deleted successfully!');
        } catch (TelegramException $e) {
            $this->error("Couldn't delete webhook");
            $this->error($e->getMessage());
            return false;
        }

        return true;
    }

    private function showWebhookInfo(): bool
    {
        try {
            $request = Request::getWebhookInfo();
            if (! $request->isOk()) {
                throw new TelegramException($request->getDescription());
            }
            $this->info('Current webhook info:');
            $this->info(json_encode($request->getResult(), JSON_PRETTY_PRINT));
        } catch (TelegramException $e) {
            $this->error("Couldn't get webhook info");
            $this->error($e->getMessage());
            return false;
        }

        return true;
    }
}
