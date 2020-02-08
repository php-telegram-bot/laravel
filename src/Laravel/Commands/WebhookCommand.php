<?php

declare(strict_types=1);

namespace PhpTelegramBot\Laravel\Commands;

use Illuminate\Console\Command;
use Longman\TelegramBot\Exception\TelegramException;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class WebhookCommand extends Command
{
    protected $signature = 'telegram:webhook {url?}
    {--delete : Force the operation to run when in production}';

    protected $description = 'Set or delete webhook for Telegram bot';

    /** @var \PhpTelegramBot\Laravel\PhpTelegramBotContract */
    protected $telegramBot;

    public function __construct(PhpTelegramBotContract $telegramBot)
    {
        parent::__construct();

        $this->telegramBot = $telegramBot;
    }

    public function handle()
    {
        $webhook = $this->argument('url');
        $delete = $this->option('delete');

        if (! ($webhook || $delete)) {
            $this->error('Not enough arguments!');
            $this->error('php artisan telegram:webhook {url?} {--delete}');
            return;
        }

        if ($delete) {
            try {
                $this->telegramBot->deleteWebhook();
                $this->info('Webhook deleted succesfully!');
            } catch (TelegramException $e) {
                $this->error("Couldn't delete webhook");
                $this->error($e->getMessage());
                return;
            }
        }


        if ($webhook) {
            try {
                $this->telegramBot->setWebhook($webhook);
                $this->info('Webhook set succesfully!');
            } catch (TelegramException $e) {
                $this->error("Couldn't set webhook");
                $this->error($e->getMessage());
                return;
            }
        }

        $this->info('All done!');
    }
}
