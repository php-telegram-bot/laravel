<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BotPublishCommand extends Command
{
    protected $signature = 'bot:publish';

    protected $description = 'Publishes folder structure for Telegram Commands';

    public function handle()
    {
        (new Filesystem())->ensureDirectoryExists(app_path('Telegram/Commands'));
        $this->publish(__DIR__ . '/stubs/example-start-command.stub', app_path('Telegram/Commands/StartCommand.php'));

        $this->info('Publishing complete.');
    }

    protected function publish($source, $destination)
    {
        $content = file_get_contents($source);
        $content = $this->replacePlaceholder($content);
        file_put_contents($destination, $content);
    }

    protected function replacePlaceholder($content): string
    {
        $namespace = \Str::of($this->laravel->getNamespace())->rtrim('\\');

        $content = str_replace(
            ['DummyRootNamespace'],
            [$namespace],
            $content
        );

        return $content;
    }

}
