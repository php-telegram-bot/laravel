<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0570To0580 extends Migration
{
    public function up(): void
    {
        try {
            Schema::dropIfExists($this->prefix . 'botan_shortener');
            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->text('reply_markup')->nullable()->comment('Inline keyboard attached to the message')->after('passport_data');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::create('botan_shortener', function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
                $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
                $table->text('url')->comment('Original URL');
                $table->char('short_url')->default('')->comment('Shortened URL');
                $table->timestamp('created_at')->nullable()->comment('Entry date creation');
                $table->foreign('user_id', 'botan_shortener_ibfk_1')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->dropColumn('reply_markup');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
