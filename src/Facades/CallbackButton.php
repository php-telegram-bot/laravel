<?php


namespace PhpTelegramBot\Laravel\Facades;


use Illuminate\Support\Facades\Facade;

class CallbackButton extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \PhpTelegramBot\Laravel\Factories\CallbackButton::class;
    }
}
