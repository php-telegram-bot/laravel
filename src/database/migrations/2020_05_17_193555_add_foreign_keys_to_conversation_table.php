<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use PhpTelegramBot\Laravel\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToConversationTable extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'conversation', function (Blueprint $table) {
                $table->foreign('user_id', 'conversation_ibfk_1')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('chat_id', 'conversation_ibfk_2')->references('id')->on($this->prefix . 'chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'conversation', function (Blueprint $table) {
                $table->dropForeign('conversation_ibfk_1');
                $table->dropForeign('conversation_ibfk_2');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
