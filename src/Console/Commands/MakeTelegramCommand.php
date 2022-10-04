<?php

namespace PhpTelegramBot\Laravel\Console\Commands;

use Illuminate\Support\Str;

class MakeTelegramCommand extends GeneratorCommand
{
    protected $signature = 'make:telegram-command
                            {name : Name of the Telegram Command}
                            {--a|admin : Generate a AdminCommand}
                            {--s|system : Generate a SystemCommand}';

    protected $description = 'Create a new Telegram Bot Command class';

    /*
     * DummyNamespace
     * DummyParent
     * DummyClass
     * {{name}}
     */

    public function handle()
    {
        $name = $this->argument('name'); // start

        if (Str::endsWith($name, ['Command', 'command'])) {
            $name = (string) Str::of($name)->substr(0, -7)->lower();
        } else {
            $name = Str::lower($name);
        }

        $class = Str::studly($name) . 'Command';

        $success = $this->publish(
            __DIR__ . '/stubs/telegram-command.stub',
            app_path("Telegram/Commands/{$class}.php"),
            [
                'DummyNamespace' => $this->getRootNamespace(),
                'DummyParent'    => $this->getParentClassName(),
                'DummyClass'     => $class,
                '{{name}}'       => $name
            ]
        );

        if ($success) {
            $this->info('Telegram Command created successfully');
        }
    }

    protected function getParentClassName()
    {
        if ($this->option('admin')) {
            return 'AdminCommand';
        }

        if ($this->option('system')) {
            return 'SystemCommand';
        }

        return 'UserCommand';
    }
}
