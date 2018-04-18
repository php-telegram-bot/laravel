<?php
/*
 * This file is part of the PhpTelegramBot/Laravel package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpTelegramBot\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class PhpTelegramBotServiceProvider extends ServiceProvider
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
        ]);

        // Append the default settings
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'phptelegrambot'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PhpTelegramBotContract::class, function (Application $app) {
            $config = $app['config']->get('phptelegrambot');

            $bot = new PhpTelegramBot($config['api_key'], ! empty($config['name']) ? $config['name'] : []);

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
