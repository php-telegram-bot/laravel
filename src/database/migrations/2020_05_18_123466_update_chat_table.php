<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateChatTable extends Migration
{
    public function up ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'chat', static function (Blueprint $table) {
            $table->char ('first_name', 255)->after('username')->nullable()->comment ('First name of the other party in a private chat');
            $table->char ('last_name', 255)->after('first_name')->nullable ()->comment ('Last name of the other party in a private chat');
        });
    }

    public function down ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'chat', static function (Blueprint $table) {
            $table->dropColumn ('first_name');
            $table->dropColumn ('last_name');
        });
    }
}
