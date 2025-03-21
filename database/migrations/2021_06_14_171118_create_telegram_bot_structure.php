<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/structure-0.73.0.sql'));
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('bot_user');
        Schema::dropIfExists('bot_chat');
        Schema::dropIfExists('bot_user_chat');
        Schema::dropIfExists('bot_inline_query');
        Schema::dropIfExists('bot_chosen_inline_result');
        Schema::dropIfExists('bot_message');
        Schema::dropIfExists('bot_edited_message');
        Schema::dropIfExists('bot_callback_query');
        Schema::dropIfExists('bot_shipping_query');
        Schema::dropIfExists('bot_pre_checkout_query');
        Schema::dropIfExists('bot_poll');
        Schema::dropIfExists('bot_poll_answer');
        Schema::dropIfExists('bot_chat_member_updated');
        Schema::dropIfExists('bot_telegram_update');
        Schema::dropIfExists('bot_conversation');
        Schema::dropIfExists('bot_request_limiter');

        Schema::enableForeignKeyConstraints();
    }
};
