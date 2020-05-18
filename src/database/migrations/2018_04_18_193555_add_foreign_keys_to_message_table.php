<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMessageTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'message', static function (Blueprint $table) {
            $table->foreign('user_id', config('phptelegrambot.database.prefix', '') . 'message_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', config('phptelegrambot.database.prefix', '') . 'message_ibfk_2')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('forward_from', config('phptelegrambot.database.prefix', '') . 'message_ibfk_3')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('forward_from_chat', config('phptelegrambot.database.prefix', '') . 'message_ibfk_4')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('reply_to_chat', config('phptelegrambot.database.prefix', '') . 'message_ibfk_5')->references('chat_id')->on(config('phptelegrambot.database.prefix', '') . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('forward_from', config('phptelegrambot.database.prefix', '') . 'message_ibfk_6')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('left_chat_member', config('phptelegrambot.database.prefix', '') . 'message_ibfk_7')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'message', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_1');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_2');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_3');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_4');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_5');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_6');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'message_ibfk_7');
        });
    }
}
