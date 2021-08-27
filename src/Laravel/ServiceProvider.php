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

namespace PhpTelegramBot\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use PhpTelegramBot\Laravel\Commands\WebhookCommand;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('phptelegrambot.php'),
        ], 'config');

        // Append the default settings
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'phptelegrambot',
        );

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PhpTelegramBotContract::class, static function ($app) {
            $config = $app['config']->get('phptelegrambot');

            $bot = new PhpTelegramBot($config['bot']['api_key'], ! empty($config['bot']['name']) ? $config['bot']['name'] : '');

            // Add commands if paths are given
            if (! empty($config['commands']['paths'])) {
                $bot->addCommandsPaths($config['commands']['paths']);
            }

            // Set command related configs
            if (! empty($config['commands']['configs'])) {
                foreach ($config['commands']['configs'] as $commandName => $commandConfig) {
                    $bot->setCommandConfig($commandName, $commandConfig);
                }
            }

            // Set database connection
            if ($config['database']['enabled'] === true) {
                /** @var \Illuminate\Database\Connection $connection */
                $connection = $app['db']->connection($config['database']['connection']);
                // Ability to use custom table prefix
                $tablePrefix = $config['database']['prefix'] ?? '';
                $bot->enableExternalMySql($connection->getPdo(), $tablePrefix);
            }

            // Enable admins if provided
            if (! empty($config['admins'])) {
                $bot->enableAdmins($config['admins']);
            }

            // Set paths
            if (! empty($config['download_path'])) {
                $bot->setDownloadPath($config['download_path']);
            }
            if (! empty($config['upload_path'])) {
                $bot->setUploadPath($config['upload_path']);
            }

            return $bot;
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                WebhookCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [PhpTelegramBotContract::class];
    }
}
