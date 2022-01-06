<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use PhpTelegramBot\Laravel\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTelegramUpdateTable extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'telegram_update', function (Blueprint $table) {
                $table->foreign('chat_id', 'telegram_update_ibfk_1')->references('chat_id')->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('inline_query_id', 'telegram_update_ibfk_2')->references('id')->on($this->prefix . 'inline_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('chosen_inline_result_id', 'telegram_update_ibfk_3')->references('id')->on($this->prefix . 'chosen_inline_result')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('callback_query_id', 'telegram_update_ibfk_4')->references('id')->on($this->prefix . 'callback_query')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('edited_message_id', 'telegram_update_ibfk_5')->references('id')->on($this->prefix . 'edited_message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'telegram_update', function (Blueprint $table) {
                $table->dropForeign('telegram_update_ibfk_1');
                $table->dropForeign('telegram_update_ibfk_2');
                $table->dropForeign('telegram_update_ibfk_3');
                $table->dropForeign('telegram_update_ibfk_4');
                $table->dropForeign('telegram_update_ibfk_5');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
