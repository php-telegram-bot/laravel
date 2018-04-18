<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEditedMessageTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edited_message', function (Blueprint $table) {
            $table->foreign('chat_id', 'edited_message_ibfk_1')->references('id')->on('chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', 'edited_message_ibfk_2')->references('chat_id')->on('message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'edited_message_ibfk_3')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edited_message', function (Blueprint $table) {
            $table->dropForeign('edited_message_ibfk_1');
            $table->dropForeign('edited_message_ibfk_2');
            $table->dropForeign('edited_message_ibfk_3');
        });
    }

}
