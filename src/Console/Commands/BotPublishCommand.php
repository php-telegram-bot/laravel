<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;

class BotPublishCommand extends Command
{
    protected $signature = 'bot:publish';

    protected $description = 'Publishes folder structure for Telegram Commands';

    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'telegram']);

        $namespace = $this->laravel->getNamespace();
        $this->replaceInFile(
            "namespace App\\Telegram\\Commands;",
            "namespace {$namespace}Telegram\\Commands;",
            app_path('Telegram/Commands/StartCommand.php'));

        $this->info('Publishing complete.');
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

}
