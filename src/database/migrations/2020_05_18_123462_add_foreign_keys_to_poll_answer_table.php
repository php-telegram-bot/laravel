<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPollAnswerTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'poll_answer', static function (Blueprint $table) {
            $table->foreign('poll_id', config('phptelegrambot.database.prefix', '') . 'poll_answer_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'poll')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'poll_answer', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'poll_answer_ibfk_1');
        });
    }
}
