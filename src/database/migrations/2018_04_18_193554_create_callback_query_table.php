<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbackQueryTable extends Migration
{
    public function up(): void
    {
        Schema::create('callback_query', static function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary()->comment('Unique identifier for this query');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->bigInteger('chat_id')->nullable()->index('chat_id')->comment('Unique chat identifier');
            $table->bigInteger('message_id')->unsigned()->nullable()->index('message_id')->comment('Unique message identifier');
            $table->char('inline_message_id')->nullable()->comment('Identifier of the message sent via the bot in inline mode, that originated the query');
            $table->char('data')->default('')->comment('Data associated with the callback button');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
            $table->index(['chat_id', 'message_id'], 'chat_id_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('callback_query');
    }
}
