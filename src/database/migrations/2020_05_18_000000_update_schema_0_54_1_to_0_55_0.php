<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0541To0550 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->text('animation')->nullable()->comment('Message is an animation, information about the animation')->after('document');
                $table->text('passport_data')->nullable()->comment('Telegram Passport data')->after('connected_website');
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
                $table->dropColumn('passport_data');
                $table->dropColumn('animation');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
