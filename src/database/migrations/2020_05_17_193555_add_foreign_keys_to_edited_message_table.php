<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use PhpTelegramBot\Laravel\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEditedMessageTable extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'edited_message', function (Blueprint $table) {
                $table->foreign('chat_id', 'edited_message_ibfk_1')->references('id')->on($this->prefix . 'chat')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('chat_id', 'edited_message_ibfk_2')->references('chat_id')->on($this->prefix . 'message')->onUpdate('RESTRICT')->onDelete('RESTRICT');
                $table->foreign('user_id', 'edited_message_ibfk_3')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'edited_message', function (Blueprint $table) {
                $table->dropForeign('edited_message_ibfk_1');
                $table->dropForeign('edited_message_ibfk_2');
                $table->dropForeign('edited_message_ibfk_3');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
