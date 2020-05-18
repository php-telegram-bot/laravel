<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInlineQueryTable extends Migration
{
    public function up()
    {
        $tablePrefix = config('phptelegrambot.database.prefix', '');

        Schema::table($tablePrefix . 'inline_query', static function (Blueprint $table) {
            $table->foreign('user_id', 'inline_query_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        $tablePrefix = config('phptelegrambot.database.prefix', '');

        Schema::table($tablePrefix . 'inline_query', static function (Blueprint $table) {
            $table->dropForeign('inline_query_ibfk_1');
        });
    }
}
