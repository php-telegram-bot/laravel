<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestLimiterTable extends Migration
{
    public function up()
    {
        Schema::create(config('phptelegrambot.database.prefix', '') . 'request_limiter', static function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->char('chat_id')->nullable()->comment('Unique chat identifier');
            $table->char('inline_message_id')->nullable()->comment('Identifier of the sent inline message');
            $table->char('method')->nullable()->comment('Request method');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('phptelegrambot.database.prefix', '') . 'request_limiter');
    }
}
