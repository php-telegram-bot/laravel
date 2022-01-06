<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use PhpTelegramBot\Laravel\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserChatTable extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'user_chat', function (Blueprint $table) {
                $table->foreign('user_id', 'user_chat_ibfk_1')->references('id')->on($this->prefix . 'user')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('chat_id', 'user_chat_ibfk_2')->references('id')->on($this->prefix . 'chat')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'user_chat', function (Blueprint $table) {
                $table->dropForeign('user_chat_ibfk_1');
                $table->dropForeign('user_chat_ibfk_2');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
