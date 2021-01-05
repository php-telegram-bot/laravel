<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0560To0570 extends Migration
{
    public function up(): void
    {
        try {
            Schema::create($this->prefix . 'shipping_query', function (Blueprint $table) {
                $table->bigInteger('id')->unsigned()->primary()->comment('Unique query identifier');
                $table->bigInteger('user_id')->index('user_id')->comment('User who sent the query');
                $table->char('invoice_payload', 255)->default('')->comment('Bot specified invoice payload');
                $table->char('shipping_address', 255)->default('')->comment('User specified shipping address');
                $table->timestamp('created_at')->nullable()->comment('Entry date creation');
                $table->foreign('user_id', 'shipping_query_ibfk_1')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::create($this->prefix . 'pre_checkout_query', function (Blueprint $table) {
                $table->bigInteger('id')->unsigned()->primary()->comment('Unique query identifier');
                $table->bigInteger('user_id')->index('user_id')->comment('User who sent the query');
                $table->char('currency', 3)->comment('Three-letter ISO 4217 currency code');
                $table->bigInteger('total_amount')->comment('Total price in the smallest units of the currency');
                $table->char('invoice_payload', 255)->default('')->comment('Bot specified invoice payload');
                $table->char('shipping_option_id', 255)->nullable()->comment('Identifier of the shipping option chosen by the user');
                $table->text('order_info')->nullable()->comment('Order info provided by the user');
                $table->timestamp('created_at')->nullable()->comment('Entry date creation');
                $table->foreign('user_id', 'pre_checkout_query_ibfk_1')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::create($this->prefix . 'poll', static function (Blueprint $table) {
                $table->bigInteger('id')->unsigned()->primary()->comment('Unique poll identifier');
                $table->char('question', 255)->comment('Poll question');
                $table->text('options')->comment('List of poll options');
                $table->boolean('is_closed')->default(0)->comment('True, if the poll is closed');
                $table->timestamp('created_at')->nullable()->comment('Entry date creation');
            });

            Schema::table($this->prefix . 'callback_query', static function (Blueprint $table) {
                $table->char('chat_instance', 255)->default('')->comment('Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent')->after('inline_message_id');
                $table->char('game_short_name', 255)->default('')->comment('Short name of a Game to be returned, serves as the unique identifier for the game')->after('data');
            });

            Schema::table($this->prefix . 'chat', static function (Blueprint $table) {
                $table->char('first_name', 255)->nullable()->comment('First name of the other party in a private chat')->after('username');
                $table->char('last_name', 255)->nullable()->comment('Last name of the other party in a private chat')->after('first_name');
            });

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->text('forward_signature')->nullable()->default(null)->comment('For messages forwarded from channels, signature of the post author if present')->after('forward_from_message_id');
                $table->text('forward_sender_name')->nullable()->default(null)->comment('Sender\'s name for messages forwarded from users who disallow adding a link to their account in forwarded messages')->after('forward_signature');
                $table->unsignedBigInteger('edit_date')->nullable()->comment('Date the message was last edited in Unix time')->after('reply_to_message');
                $table->text('author_signature')->nullable()->comment('Signature of the post author for messages in channels')->after('media_group_id');
                $table->text('caption_entities')->nullable()->comment('For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption')->after('entities');
                $table->text('poll')->nullable()->comment('Poll object. Message is a native poll, information about the poll')->after('venue');
                $table->text('invoice')->nullable()->comment('Message is an invoice for a payment, information about the invoice')->after('pinned_message');
                $table->text('successful_payment')->nullable()->comment('Message is a service message about a successful payment, information about the payment')->after('invoice');
            });

            Schema::table($this->prefix . 'telegram_update', function (Blueprint $table) {
                $table->bigInteger('channel_post_id')->unsigned()->nullable()->comment('New incoming channel post of any kind - text, photo, sticker, etc.');
                $table->bigInteger('edited_channel_post_id')->unsigned()->nullable()->comment('New version of a channel post that is known to the bot and was edited');
                $table->bigInteger('shipping_query_id')->unsigned()->nullable()->comment('New incoming shipping query. Only for invoices with flexible price');
                $table->bigInteger('pre_checkout_query_id')->unsigned()->nullable()->comment('New incoming pre-checkout query. Contains full information about checkout');
                $table->bigInteger('poll_id')->unsigned()->nullable()->comment('New poll state. Bots receive only updates about polls, which are sent or stopped by the bot');

                $table->index('channel_post_id', 'channel_post_id');
                $table->index('edited_channel_post_id', 'edited_channel_post_id');
                $table->index('shipping_query_id', 'shipping_query_id');
                $table->index('pre_checkout_query_id', 'pre_checkout_query_id');
                $table->index('poll_id', 'poll_id');

                $table->foreign(['chat_id', 'channel_post_id'], 'telegram_update_ibfk_6')->references(['chat_id', 'id'])->on($this->prefix . 'message');
                $table->foreign('edited_channel_post_id', 'telegram_update_ibfk_7')->references('id')->on($this->prefix . 'edited_message');
                $table->foreign('shipping_query_id', 'telegram_update_ibfk_8')->references('id')->on($this->prefix . 'shipping_query');
                $table->foreign('pre_checkout_query_id', 'telegram_update_ibfk_9')->references('id')->on($this->prefix . 'pre_checkout_query');
                $table->foreign('poll_id', 'telegram_update_ibfk_10')->references('id')->on($this->prefix . 'poll');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'telegram_update', static function (Blueprint $table) {
                $table->dropForeign('telegram_update_ibfk_10');
                $table->dropForeign('telegram_update_ibfk_9');
                $table->dropForeign('telegram_update_ibfk_8');
                $table->dropForeign('telegram_update_ibfk_7');
                $table->dropForeign('telegram_update_ibfk_6');

                $table->dropIndex('poll_id');
                $table->dropIndex('pre_checkout_query_id');
                $table->dropIndex('shipping_query_id');
                $table->dropIndex('edited_channel_post_id');
                $table->dropIndex('channel_post_id');

                $table->dropColumn('poll_id');
                $table->dropColumn('pre_checkout_query_id');
                $table->dropColumn('shipping_query_id');
                $table->dropColumn('edited_channel_post_id');
                $table->dropColumn('channel_post_id');
            });

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->dropColumn('successful_payment');
                $table->dropColumn('invoice');
                $table->dropColumn('poll');
                $table->dropColumn('caption_entities');
                $table->dropColumn('author_signature');
                $table->dropColumn('edit_date');
                $table->dropColumn('forward_sender_name');
                $table->dropColumn('forward_signature');
            });

            Schema::table($this->prefix . 'chat', static function (Blueprint $table) {
                $table->dropColumn('last_name');
                $table->dropColumn('first_name');
            });

            Schema::table($this->prefix . 'callback_query', static function (Blueprint $table) {
                $table->dropColumn('game_short_name');
                $table->dropColumn('chat_instance');
            });

            Schema::dropIfExists($this->prefix . 'poll');
            Schema::dropIfExists($this->prefix . 'pre_checkout_query');
            Schema::dropIfExists($this->prefix . 'shipping_query');
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
