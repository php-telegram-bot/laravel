<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/0.74.0-0.75.0.sql'));
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('bot_chat_join_request');
        Schema::enableForeignKeyConstraints();
    }
};
