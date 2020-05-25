<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditedMessageTable extends Migration
{
    public function up(): void
    {
        Schema::create('edited_message', static function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->bigInteger('chat_id')->nullable()->index('chat_id')->comment('Unique chat identifier');
            $table->bigInteger('message_id')->unsigned()->nullable()->index('message_id')->comment('Unique message identifier');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->dateTime('edit_date')->nullable()->comment('Date the message was edited in timestamp format');
            $table->text('text')->nullable()->comment('For text messages, the actual UTF-8 text of the message max message length 4096 char utf8');
            $table->text('entities')->nullable()->comment('For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text');
            $table->text('caption')->nullable()->comment('For message with caption, the actual UTF-8 text of the caption');
            $table->index(['chat_id', 'message_id'], 'chat_id_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edited_message');
    }
}
