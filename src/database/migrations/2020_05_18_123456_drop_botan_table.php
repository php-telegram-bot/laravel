<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropBotanTable extends Migration
{
    public function up()
    {
        $tablePrefix = config('phptelegrambot.database.prefix', '');

        Schema::dropIfExists($tablePrefix . 'botan_shortener');
    }

    public function down()
    {
        /*
         * Not used
         */
    }
}
