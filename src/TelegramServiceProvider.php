<?php

namespace PhpTelegramBot\Laravel;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Finder\Finder;
use PhpTelegramBot\Laravel\Console\Commands\TelegramCloseCommand;
use PhpTelegramBot\Laravel\Console\Commands\TelegramDeleteWebhookCommand;
use PhpTelegramBot\Laravel\Console\Commands\TelegramFetchCommand;
use PhpTelegramBot\Laravel\Console\Commands\TelegramLogoutCommand;
use PhpTelegramBot\Laravel\Console\Commands\TelegramPublishCommand;
use PhpTelegramBot\Laravel\Console\Commands\TelegramSetWebhookCommand;
use PhpTelegramBot\Laravel\Console\Commands\MakeTelegramCommand;
use PhpTelegramBot\Laravel\Factories\CallbackButton;
use PhpTelegramBot\Laravel\Http\Middleware\TrustTelegramNetwork;
use PhpTelegramBot\Laravel\Telegram\Commands\CallbackqueryCommand;
use PhpTelegramBot\Laravel\Telegram\Commands\GenericmessageCommand;

class TelegramServiceProvider extends ServiceProvider
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

        $this->configureTelegramBot();
    }

    protected function configureTelegramBot()
    {
        $token = config('telegram.bot.api_token');

        if (! $token) {
            return;
        }

        $username = config('telegram.bot.username');

        $apiUrl = config('telegram.bot.api_url', '');
        if (! empty($apiUrl)) {
            Request::setCustomBotApiUri($apiUrl);
        }

        $bot = new Telegram($token, $username);

        // Commands Discovery
        $this->discoverTelegramCommands($bot);
        $bot->addCommandClass(CallbackqueryCommand::class);
        $bot->addCommandClass(GenericmessageCommand::class);

        // Set MySQL Connection
        $connection = app('db')->connection('mysql');
        $bot->enableExternalMySql($connection->getPdo(), 'bot_');

        // Register admins
        $this->registerTelegramAdmins($bot);

        $this->app->instance(Telegram::class, $bot);
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/telegram.php' => config_path('telegram.php'),
        ], 'telegram-config');

        $this->publishes([
            __DIR__ . '/../routes/telegram.php' => base_path('routes/telegram.php')
        ], 'telegram-routes');

        // Registering package commands.
        $this->commands([
            MakeTelegramCommand::class,
            TelegramCloseCommand::class,
            TelegramDeleteWebhookCommand::class,
            TelegramFetchCommand::class,
            TelegramLogoutCommand::class,
            TelegramPublishCommand::class,
            TelegramSetWebhookCommand::class,
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
        File::ensureDirectoryExists($commandsPath);

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
            $admins = explode(',', $admins);
            $bot->enableAdmins($admins);
        }
    }
}
