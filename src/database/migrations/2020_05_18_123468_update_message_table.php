<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMessageTable extends Migration
{
    public function up ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'message', static function (Blueprint $table) {
            $table->text ('forward_signature')->after ('forward_from_message_id')->nullable()->comment ('For messages forwarded from channels, signature of the post author if present');
            $table->text ('forward_sender_name')->after ('forward_signature')->nullable()->comment ('Sender\'s name for messages forwarded from users who disallow adding a link to their account in forwarded messages');
            $table->bigInteger('edit_date')->after('reply_to_message')->unsigned()->nullable()->comment('Date the message was last edited in Unix time');
            $table->text ('author_signature')->after ('media_group_id')->nullable()->comment ('Signature of the post author for messages in channels');
            $table->text ('caption_entities')->after ('entities')->nullable()->comment('For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption');
            $table->text('animation')->after('document')->nullable()->comment('Message is an animation, information about the animation');
            $table->text('game')->after('animation')->nullable()->comment('Game object. Message is a game, information about the game');
            $table->text('poll')->after('venue')->nullable()->comment ('Poll object. Message is a native poll, information about the poll');
            $table->text('dice')->after('poll')->nullable()->comment ('Message is a dice with random value from 1 to 6');
            $table->text('invoice')->after('pinned_message')->nullable()->comment ('Message is an invoice for a payment, information about the invoice');
            $table->text('successful_payment')->after('invoice')->nullable()->comment ('Message is a service message about a successful payment, information about the payment');
            $table->text('passport_data')->after('connected_website')->nullable()->comment ('Telegram Passport data');
            $table->text('reply_markup')->after('passport_data')->nullable()->comment ('Inline keyboard attached to the message');

            // Foreign indexes
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'message_ibfk_5');
            $table->foreign (
                ['reply_to_chat', 'reply_to_message'],
                config('phptelegrambot.database.prefix', '') . 'message_ibfk_5'
            )
                ->references (['chat_id', 'id'])->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign (
                'forward_from',
                config('phptelegrambot.database.prefix', '') . 'message_ibfk_6'
            )
                ->references ('id')->on (config('phptelegrambot.database.prefix', '') . 'user')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down ()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'message', static function (Blueprint $table) {
            $table->dropColumn ('forward_signature');
            $table->dropColumn ('forward_sender_name');
            $table->dropColumn ('edit_date');
            $table->dropColumn ('author_signature');
            $table->dropColumn ('caption_entities');
            $table->dropColumn ('animation');
            $table->dropColumn ('game');
            $table->dropColumn ('poll');
            $table->dropColumn ('dice');
            $table->dropColumn ('invoice');
            $table->dropColumn ('successful_payment');
            $table->dropColumn ('passport_data');
            $table->dropColumn ('reply_markup');

            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'message_ibfk_5');
            $table->dropForeign (config('phptelegrambot.database.prefix', '') . 'message_ibfk_6');

            $table->foreign ('reply_to_chat', config('phptelegrambot.database.prefix', '') . 'message_ibfk_5')
                ->references ('chat_id')->on (config('phptelegrambot.database.prefix', '') . 'message')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
