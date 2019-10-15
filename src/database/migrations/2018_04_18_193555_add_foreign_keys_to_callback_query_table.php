<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCallbackQueryTable extends Migration
{
    public function up()
    {
        Schema::table('callback_query', static function (Blueprint $table) {
            $table->foreign('user_id', 'callback_query_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', 'callback_query_ibfk_2')->references('chat_id')->on('message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('callback_query', static function (Blueprint $table) {
            $table->dropForeign('callback_query_ibfk_1');
            $table->dropForeign('callback_query_ibfk_2');
        });
    }
}
