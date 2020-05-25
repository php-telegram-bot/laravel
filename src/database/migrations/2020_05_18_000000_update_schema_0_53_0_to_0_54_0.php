<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0530To0540 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->text('game')->nullable()->comment('Message is a game, information about the game.')->after('document');
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
                $table->dropColumn('game');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
