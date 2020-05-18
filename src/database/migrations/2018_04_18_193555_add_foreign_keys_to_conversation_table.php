<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConversationTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'conversation', static function (Blueprint $table) {
            $table->foreign('user_id', config('phptelegrambot.database.prefix', '') . 'conversation_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', config('phptelegrambot.database.prefix', '') . 'conversation_ibfk_2')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'conversation', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'conversation_ibfk_1');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'conversation_ibfk_2');
        });
    }
}
