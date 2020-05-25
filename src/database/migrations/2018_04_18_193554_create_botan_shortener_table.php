<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotanShortenerTable extends Migration
{
    public function up(): void
    {
        Schema::create('botan_shortener', static function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->text('url')->comment('Original URL');
            $table->char('short_url')->default('')->comment('Shortened URL');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('botan_shortener');
    }
}
