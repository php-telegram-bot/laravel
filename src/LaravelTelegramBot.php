<?php

namespace PhpTelegramBot\Laravel;

use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class LaravelTelegramBot
{

    protected array $callbacks = [];

    public function register(callable $callback)
    {
        $this->callbacks[] = $callback;
    }

    public function call(Update $update): ?ServerResponse
    {
        foreach ($this->callbacks as $callback) {
            $return = $callback($update);

            if ($return instanceof ServerResponse) {
                return $return;
            } elseif ($return === true) {
                return Request::emptyResponse();
            }
        }

        return null;
    }

}
