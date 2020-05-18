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

class Migration extends \Illuminate\Database\Migrations\Migration
{
    /** @var string */
    protected $prefix = '';

    public function __construct()
    {
        $this->prefix = (string) config('phptelegrambot.database.prefix', '');
    }
}
