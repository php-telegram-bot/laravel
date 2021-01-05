<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0640To0700 extends Migration
{
    public function up(): void
    {
        try {
            $this->changeColumnTypes(['poll' => ['question']], 'text');

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->bigInteger('sender_chat_id')->comment('Sender of the message, sent on behalf of a chat')->after('chat_id');
                $table->text('proximity_alert_triggered')->nullable()->comment('Service message. A user in the chat triggered another user\'s proximity alert while sharing Live Location.')->after('passport_data');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->dropColumn('proximity_alert_triggered');
                $table->dropColumn('sender_chat_id');
            });

            $this->changeColumnTypes(['poll' => ['question']], 'char(255)');
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
