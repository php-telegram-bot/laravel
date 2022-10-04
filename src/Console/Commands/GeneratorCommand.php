<?php


namespace PhpTelegramBot\Laravel\Console\Commands;


use Illuminate\Console\Command;

abstract class GeneratorCommand extends Command
{

    protected function publish(string $source, string $destination, array $replacements = [], bool $overwrite = false) : bool
    {
        if (file_exists($destination) && ! $overwrite) {
            $basename = basename($destination);
            $this->error("{$basename} already exists!");
            return false;
        }

        $content = file_get_contents($source);
        $content = $this->replacePlaceholder($content, $replacements);
        file_put_contents($destination, $content);

        return true;
    }

    protected function replacePlaceholder(string $content, array $replacements): string
    {
        foreach ($replacements as $from => $to) {
            $content = str_replace($from, $to, $content);
        }

        return $content;
    }

    protected function getRootNamespace(): string
    {
        return rtrim($this->laravel->getNamespace(), '\\');
    }

}
