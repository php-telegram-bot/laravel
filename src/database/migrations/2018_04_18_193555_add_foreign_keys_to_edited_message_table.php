<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEditedMessageTable extends Migration
{
    public function up(): void
    {
        Schema::table('edited_message', static function (Blueprint $table) {
            $table->foreign('chat_id', 'edited_message_ibfk_1')->references('id')->on('chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chat_id', 'edited_message_ibfk_2')->references('chat_id')->on('message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'edited_message_ibfk_3')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::table('edited_message', static function (Blueprint $table) {
            $table->dropForeign('edited_message_ibfk_1');
            $table->dropForeign('edited_message_ibfk_2');
            $table->dropForeign('edited_message_ibfk_3');
        });
    }
}
