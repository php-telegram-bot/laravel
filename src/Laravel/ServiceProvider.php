<?php

declare(strict_types=1);

/*
 * This file is part of the PhpTelegramBot/Laravel package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpTelegramBot\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

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
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('phptelegrambot.php'),
        ], 'config');

        // Append the default settings
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'phptelegrambot'
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
    public function register()
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
                foreach ($config['commands']['configs'] as $command_name => $command_config) {
                    $bot->setCommandConfig($command_name, $command_config);
                }
            }

            // Set database connection
            if ($config['database']['enabled'] === true) {
                /** @var \Illuminate\Database\Connection $connection */
                $connection = $app['db']->connection($config['database']['connection']);
                $bot->enableExternalMySql($connection->getPdo());
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
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PhpTelegramBotContract::class];
    }
}
