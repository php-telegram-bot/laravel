<?php

namespace PhpTelegramBot\Laravel\Console\Commands;

use Illuminate\Filesystem\Filesystem;

class TelegramPublishCommand extends GeneratorCommand
{
    protected $signature = 'telegram:publish';

    protected $description = 'Publishes folder structure for Telegram Commands';

    public function handle()
    {
        (new Filesystem())->ensureDirectoryExists(app_path('Telegram/Commands'));
        $success = $this->publish(
            __DIR__ . '/stubs/example-start-command.stub',
            app_path('Telegram/Commands/StartCommand.php'),
            [
                'DummyRootNamespace' => $this->getRootNamespace(),
            ]
        );

        if ($success) {
            $this->info('Publishing complete.');
        }
    }

}
