<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBotanShortenerTable extends Migration
{
    public function up()
    {
        Schema::create('botan_shortener', static function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->text('url', 65535)->comment('Original URL');
            $table->char('short_url')->default('')->comment('Shortened URL');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
        });
    }

    public function down()
    {
        Schema::drop('botan_shortener');
    }
}
