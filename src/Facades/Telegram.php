<?php

namespace PhpTelegramBot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use PhpTelegramBot\Laravel\LaravelTelegramBot;

class Telegram extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelTelegramBot::class;
    }
}