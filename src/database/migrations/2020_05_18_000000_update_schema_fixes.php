<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchemaFixes extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'callback_query', function (Blueprint $table) {
                $table->dropForeign('callback_query_ibfk_2');
                $table->foreign(['chat_id', 'message_id'], 'callback_query_ibfk_2')->references(['chat_id', 'id'])->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'edited_message', function (Blueprint $table) {
                $table->dropForeign('edited_message_ibfk_2');
                $table->foreign(['chat_id', 'message_id'], 'edited_message_ibfk_2')->references(['chat_id', 'id'])->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'message', function (Blueprint $table) {
                $table->dropForeign('message_ibfk_5');
                $table->dropForeign('message_ibfk_6');
                $table->foreign(['reply_to_chat', 'reply_to_message'], 'message_ibfk_5')->references(['chat_id', 'id'])->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'callback_query', function (Blueprint $table) {
                $table->dropForeign('callback_query_ibfk_2');
                $table->foreign('chat_id', 'callback_query_ibfk_2')->references('chat_id')->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'edited_message', function (Blueprint $table) {
                $table->dropForeign('edited_message_ibfk_2');
                $table->foreign('chat_id', 'edited_message_ibfk_2')->references('chat_id')->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'message', function (Blueprint $table) {
                $table->dropForeign('message_ibfk_5');
                $table->foreign('reply_to_chat', 'message_ibfk_5')->references('chat_id')->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('forward_from', 'message_ibfk_6')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
