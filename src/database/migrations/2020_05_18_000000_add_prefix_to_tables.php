<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class AddPrefixToTables extends Migration
{
    /** @var string[] All PHP Telegram Bot database tables. */
    private $tables = [
        'botan_shortener',
        'callback_query',
        'chat',
        'chosen_inline_result',
        'conversation',
        'edited_message',
        'inline_query',
        'message',
        'user',
        'request_limiter',
        'telegram_update',
        'user_chat',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            try {
                if (Schema::hasTable($this->prefix . $table)) {
                    Log::warning("Prefixed table '{$this->prefix}{$table}' already exists. Verify your migration status.");
                    continue; // Migration may be partly done already...
                }

                Schema::rename($table, $this->prefix . $table);
            } catch (Throwable $e) {
                Log::error($e->getMessage());
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            try {
                if (Schema::hasTable($table)) {
                    Log::warning("Un-prefixed table '{$table}' already exists. Verify your migration status.");
                    continue; // Migration may be partly done already...
                }

                Schema::rename($this->prefix . $table, $table);
            } catch (Throwable $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
