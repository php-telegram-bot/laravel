<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConversationTable extends Migration
{
    public function up()
    {
        Schema::table('conversation', static function (Blueprint $table) {
            $table->foreign('user_id', 'conversation_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', 'conversation_ibfk_2')->references('id')->on('chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('conversation', static function (Blueprint $table) {
            $table->dropForeign('conversation_ibfk_1');
            $table->dropForeign('conversation_ibfk_2');
        });
    }
}
