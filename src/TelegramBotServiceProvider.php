<?php

namespace Tii\LaravelTelegramBot;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Finder\Finder;
use Tii\LaravelTelegramBot\Console\Commands\BotPublishCommand;
use Tii\LaravelTelegramBot\Console\Commands\BotTunnelCommand;
use Tii\LaravelTelegramBot\Console\Commands\TelegramCommandMakeCommand;
use Tii\LaravelTelegramBot\Http\Middleware\TrustTelegramNetwork;

class TelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if (file_exists(base_path('routes/telegram.php'))) {
            $this->loadRoutesFrom(base_path('routes/telegram.php'));
        } else {
            $this->loadRoutesFrom(__DIR__ . '/../routes/telegram.php');
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('telegram.network', TrustTelegramNetwork::class);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/telegram.php', 'telegram');
        $this->mergeConfigFrom(__DIR__ . '/../config/expose.php', 'expose');

        $this->app->singleton(Telegram::class, function () {
            $token = config('telegram.bot.api_token');
            $username = config('telegram.bot.username');

            $bot = new Telegram($token, $username);

            // Commands Discovery
            $this->discoverTelegramCommands($bot);

            // Set MySQL Connection
            $connection = app('db')->connection('mysql');
            $bot->enableExternalMySql($connection->getPdo(), 'bot_');

            // Register admins
            $this->registerTelegramAdmins($bot);

            return $bot;
        });
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/Telegram/Commands' => app_path('Telegram/Commands')
        ], 'telegram');

        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/telegram.php' => config_path('telegram.php'),
        ], 'telegram-config');

        $this->publishes([
            __DIR__ . '/../routes/telegram.php' => base_path('routes/telegram.php')
        ], 'telegram-routes');

        // Registering package commands.
        $this->commands([
            BotTunnelCommand::class,
            BotPublishCommand::class,
            TelegramCommandMakeCommand::class
        ]);
    }

    /**
     * @param  Telegram  $bot
     * @throws \ReflectionException
     */
    protected function discoverTelegramCommands(Telegram $bot): void
    {
        $namespace = $this->app->getNamespace();
        $commandsPath = app_path('Telegram/Commands');
        foreach ((new Finder)->in($commandsPath)->files() as $command) {
            $command = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    \Str::after($command->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($command, Command::class) &&
                ! (new \ReflectionClass($command))->isAbstract()) {
                $bot->addCommandClass($command);
            }
        }
    }

    /**
     * @param  Telegram  $bot
     */
    protected function registerTelegramAdmins(Telegram $bot): void
    {
        $admins = config('telegram.admins', '');
        if (! empty($admins)) {
            $admins = explode(';', $admins);
            $bot->enableAdmins($admins);
        }
    }
}