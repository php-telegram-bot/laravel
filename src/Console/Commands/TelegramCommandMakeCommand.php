<?php

namespace Tii\LaravelTelegramBot\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class TelegramCommandMakeCommand extends GeneratorCommand
{
    protected $signature = 'make:telegram-command
                            {name : Name of the Telegram Command (must end with "Command")}
                            {--a|admin : Generate a AdminCommand}
                            {--s|system : Generate a SystemCommand}';

    protected $description = 'Create a new Telegram Bot Command class';

    protected $type = 'Telegram Command';

    public function handle()
    {
        if (! \Str::endsWith($this->getNameInput(), 'Command')) {
            $this->error('The name "' . $this->getNameInput() . '" must end with "Command".');

            return false;
        }

        return parent::handle();
    }


    protected function getStub()
    {
        return __DIR__ . '/stubs/telegram-command.stub';
    }

    protected function alreadyExists($rawName)
    {
        return class_exists($this->rootNamespace() . 'Telegram\\Commands\\' . $rawName);
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $parent = $this->getParentClassName();
        $stub = $this->replaceParent($stub, $parent);

        $commandName = \Str::of(class_basename($name))->beforeLast('Command')->lower();
        $stub = $this->replaceCommandName($stub, $commandName);

        return $stub;
    }

    protected function getParentClassName()
    {
        if ($this->hasOption('admin')) {
            return 'AdminCommand';
        }

        if ($this->hasOption('system')) {
            return 'SystemCommand';
        }

        return 'UserCommand';
    }

    protected function replaceParent($stub, $name)
    {
        return str_replace(['DummyParent', '{{parent}}', '{{ parent }}'], $name, $stub);
    }

    protected function replaceCommandName($stub, $commandName)
    {
        return str_replace(['DummyName', '{{name}}', '{{ name }}'], $commandName, $stub);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Telegram\Commands';
    }

}
