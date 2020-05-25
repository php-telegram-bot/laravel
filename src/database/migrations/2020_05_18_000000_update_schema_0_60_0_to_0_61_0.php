<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0600To0610 extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::table($this->prefix . 'telegram_update', static function (Blueprint $table) {
                $table->dropIndex('message_id');
                $table->index('message_id', 'message_id');
                $table->index(['chat_id', 'message_id'], 'chat_message_id');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::table($this->prefix . 'telegram_update', static function (Blueprint $table) {
                $table->dropIndex('chat_message_id');
                $table->dropIndex('message_id');
                $table->index('message_id', 'message_id');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }

        Schema::enableForeignKeyConstraints();
    }
}
