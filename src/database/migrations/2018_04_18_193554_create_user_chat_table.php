<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserChatTable extends Migration
{
    public function up()
    {
        Schema::create('user_chat', static function (Blueprint $table) {
            $table->bigInteger('user_id')->comment('Unique user identifier');
            $table->bigInteger('chat_id')->index('chat_id')->comment('Unique user or chat identifier');
            $table->primary(['user_id', 'chat_id']);
        });
    }

    public function down()
    {
        Schema::drop('user_chat');
    }
}
