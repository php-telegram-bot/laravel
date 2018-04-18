<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserChatTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_chat', function (Blueprint $table) {
            $table->foreign('user_id', 'user_chat_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('chat_id', 'user_chat_ibfk_2')->references('id')->on('chat')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_chat', function (Blueprint $table) {
            $table->dropForeign('user_chat_ibfk_1');
            $table->dropForeign('user_chat_ibfk_2');
        });
    }

}
