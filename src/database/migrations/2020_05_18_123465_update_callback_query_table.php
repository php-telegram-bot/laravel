<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateCallbackQueryTable extends Migration
{
    public function up ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'callback_query', static function (Blueprint $table) {
            $table->char ('chat_instance', 255)->after('inline_message_id')->default('')->comment ('Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent');
            $table->char ('game_short_name', 255)->after('data')->default('')->comment ('Short name of a Game to be returned, serves as the unique identifier for the game');

            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'callback_query_ibfk_2');

            $table->foreign (
                ['chat_id', 'message_id'],
                config('phptelegrambot.database.prefix', '') . 'callback_query_ibfk_2'
            )
                ->references (['chat_id', 'id'])->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'callback_query', static function (Blueprint $table) {
            $table->dropColumn ('chat_instance');
            $table->dropColumn ('game_short_name');

            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'callback_query_ibfk_2');

            $table->foreign ('chat_id', config('phptelegrambot.database.prefix', '') . 'callback_query_ibfk_2')
                ->references ('chat_id')->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
