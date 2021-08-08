<?php

namespace Tii\LaravelTelegramBot\Facades;

use Illuminate\Support\Facades\Facade;
use Tii\LaravelTelegramBot\LaravelTelegramBot;

class Bot extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelTelegramBot::class;
    }
}