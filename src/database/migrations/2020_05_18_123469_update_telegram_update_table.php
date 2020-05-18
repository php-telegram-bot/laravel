<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTelegramUpdateTable extends Migration
{
    public function up ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'telegram_update', static function (Blueprint $table) {
            $table->bigInteger('channel_post_id')->after('edited_message_id')->unsigned()->nullable()->comment('New incoming channel post of any kind - text, photo, sticker, etc.');
            $table->bigInteger('edited_channel_post_id')->after('channel_post_id')->unsigned()->nullable()->comment('New version of a channel post that is known to the bot and was edited');
            $table->bigInteger('shipping_query_id')->after('callback_query_id')->unsigned()->nullable()->comment('New incoming shipping query. Only for invoices with flexible price');
            $table->bigInteger('pre_checkout_query_id')->after('shipping_query_id')->unsigned()->nullable()->comment('New incoming pre-checkout query. Contains full information about checkout');
            $table->bigInteger('poll_id')->after('pre_checkout_query_id')->unsigned()->nullable()->comment('New poll state. Bots receive only updates about polls, which are sent or stopped by the bot');
            $table->bigInteger('poll_answer_poll_id')->after('poll_id')->unsigned()->nullable()->comment('A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.');

            // Add new indexes
            $table->dropIndex ('message_id');
            $table->index (['message_id'], message_id);
            $table->index (['chat_id', 'message_id'], 'chat_message_id');
            $table->index (['channel_post_id'], 'channel_post_id');
            $table->index (['edited_channel_post_id'], 'edited_channel_post_id');
            $table->index (['shipping_query_id'], 'shipping_query_id');
            $table->index (['pre_checkout_query_id'], 'pre_checkout_query_id');
            $table->index (['poll_id'], 'poll_id');
            $table->index (['poll_answer_poll_id'], 'poll_answer_poll_id');
            $table->index (['chat_id', 'channel_post_id'], 'chat_id');

            // Foreign indexes
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1');







            $table->foreign (
                ['chat_id', 'message_id'],
                config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1'
            )
                ->references (['chat_id', 'id'])->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('edited_message_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'edited_message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign (['chat_id', 'channel_post_id'], config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3')
                ->references (['chat_id', 'id'])->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('edited_channel_post_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'edited_message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('inline_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'inline_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('chosen_inline_result_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_6')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'chosen_inline_result')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('callback_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_7')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'callback_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('shipping_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_8')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'shipping_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('pre_checkout_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_9')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'pre_checkout_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('poll_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_10')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'poll')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('poll_answer_poll_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_11')
                ->references ('poll_id')->on (config('phptelegrambot.database.prefix', '') . 'poll_answer')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

        });
    }

    public function down ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'telegram_update', static function (Blueprint $table) {
            $table->dropColumn ('channel_post_id');
            $table->dropColumn ('edited_channel_post_id');
            $table->dropColumn ('shipping_query_id');
            $table->dropColumn ('pre_checkout_query_id');
            $table->dropColumn ('poll_id');
            $table->dropColumn ('poll_answer_poll_id');

            // Rollback old index
            $table->dropIndex ('message_id');
            $table->index (['chat_id', 'message_id'], 'message_id');

            // Drop new simple keys
            $table->dropIndex ('chat_message_id');
            $table->dropIndex ('channel_post_id');
            $table->dropIndex ('edited_channel_post_id');
            $table->dropIndex ('shipping_query_id');
            $table->dropIndex ('pre_checkout_query_id');
            $table->dropIndex ('poll_id');
            $table->dropIndex ('poll_answer_poll_id');
            $table->dropIndex ('chat_id');

            // Drop new foreign keys
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_6');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_7');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_8');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_9');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_10');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_11');

            // Restore old foreign keys
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5');

            $table->foreign ('chat_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_1')
                ->references ('chat_id')->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('inline_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_2')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'inline_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('chosen_inline_result_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_3')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'chosen_inline_result')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('callback_query_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_4')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'callback_query')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign ('edited_message_id', config('phptelegrambot.database.prefix', '') . 'telegram_update_ibfk_5')
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'edited_message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
