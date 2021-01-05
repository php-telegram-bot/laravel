<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTelegramUpdateTable extends Migration
{
    public function up(): void
    {
        Schema::table('telegram_update', static function (Blueprint $table) {
            $table->foreign('chat_id', 'telegram_update_ibfk_1')->references('chat_id')->on('message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('inline_query_id', 'telegram_update_ibfk_2')->references('id')->on('inline_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('chosen_inline_result_id', 'telegram_update_ibfk_3')->references('id')->on('chosen_inline_result')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('callback_query_id', 'telegram_update_ibfk_4')->references('id')->on('callback_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('edited_message_id', 'telegram_update_ibfk_5')->references('id')->on('edited_message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::table('telegram_update', static function (Blueprint $table) {
            $table->dropForeign('telegram_update_ibfk_1');
            $table->dropForeign('telegram_update_ibfk_2');
            $table->dropForeign('telegram_update_ibfk_3');
            $table->dropForeign('telegram_update_ibfk_4');
            $table->dropForeign('telegram_update_ibfk_5');
        });
    }
}
