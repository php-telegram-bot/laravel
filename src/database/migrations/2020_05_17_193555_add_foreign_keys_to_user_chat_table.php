<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserChatTable extends Migration
{
    public function up(): void
    {
        Schema::table('user_chat', static function (Blueprint $table) {
            $table->foreign('user_id', 'user_chat_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('chat_id', 'user_chat_ibfk_2')->references('id')->on('chat')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('user_chat', static function (Blueprint $table) {
            $table->dropForeign('user_chat_ibfk_1');
            $table->dropForeign('user_chat_ibfk_2');
        });
    }
}
