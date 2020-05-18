<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChosenInlineResultTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'chosen_inline_result', static function (Blueprint $table) {
            $table->foreign('user_id', config('phptelegrambot.database.prefix', '') . 'chosen_inline_result_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'chosen_inline_result', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'chosen_inline_result_ibfk_1');
        });
    }
}
