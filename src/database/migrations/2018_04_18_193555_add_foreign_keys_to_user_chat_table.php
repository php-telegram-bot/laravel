<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserChatTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'user_chat', static function (Blueprint $table) {
            $table->foreign('user_id', config('phptelegrambot.database.prefix', '') . 'user_chat_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('chat_id', config('phptelegrambot.database.prefix', '') . 'user_chat_ibfk_2')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'chat')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'user_chat', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'user_chat_ibfk_1');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'user_chat_ibfk_2');
        });
    }
}
