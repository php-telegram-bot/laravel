<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchema0600To0610 extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::table('telegram_update', static function (Blueprint $table) {
                $table->dropIndex('message_id');
                $table->index('message_id', 'message_id');
                $table->index(['chat_id', 'message_id'], 'chat_message_id');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::table('telegram_update', static function (Blueprint $table) {
                $table->dropIndex('chat_message_id');
                $table->dropIndex('message_id');
                $table->index('message_id', 'message_id');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }

        Schema::enableForeignKeyConstraints();
    }
}
