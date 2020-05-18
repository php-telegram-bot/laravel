<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTelegramUpdateTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'telegram_update', static function (Blueprint $table) {
            $table->foreign('chat_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1')->references('chat_id')->on(config('phptelegrambot.database.prefix', '') . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('inline_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'inline_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign(
                'chosen_inline_result_id',
                config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3'
            )->references('id')->on(config('phptelegrambot.database.prefix', '') . 'chosen_inline_result')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('callback_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'callback_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('edited_message_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'edited_message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'telegram_update', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4');
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5');
        });
    }
}
