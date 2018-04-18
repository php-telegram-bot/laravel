<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->bigInteger('chat_id')->comment('Unique chat identifier');
            $table->bigInteger('id')->unsigned()->comment('Unique message identifier');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->dateTime('date')->nullable()->comment('Date the message was sent in timestamp format');
            $table->bigInteger('forward_from')->nullable()->index('forward_from')->comment('Unique user identifier, sender of the original message');
            $table->bigInteger('forward_from_chat')->nullable()->index('forward_from_chat')->comment('Unique chat identifier, chat the original message belongs to');
            $table->bigInteger('forward_from_message_id')->nullable()->comment('Unique chat identifier of the original message in the channel');
            $table->dateTime('forward_date')->nullable()->comment('date the original message was sent in timestamp format');
            $table->bigInteger('reply_to_chat')->nullable()->index('reply_to_chat')->comment('Unique chat identifier');
            $table->bigInteger('reply_to_message')->unsigned()->nullable()->index('reply_to_message')->comment('Message that this message is reply to');
            $table->text('media_group_id', 65535)->nullable()->comment('The unique identifier of a media message group this message belongs to');
            $table->text('text', 65535)->nullable()->comment('For text messages, the actual UTF-8 text of the message max message length 4096 char utf8mb4');
            $table->text('entities',
                65535)->nullable()->comment('For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text');
            $table->text('audio', 65535)->nullable()->comment('Audio object. Message is an audio file, information about the file');
            $table->text('document', 65535)->nullable()->comment('Document object. Message is a general file, information about the file');
            $table->text('photo', 65535)->nullable()->comment('Array of PhotoSize objects. Message is a photo, available sizes of the photo');
            $table->text('sticker', 65535)->nullable()->comment('Sticker object. Message is a sticker, information about the sticker');
            $table->text('video', 65535)->nullable()->comment('Video object. Message is a video, information about the video');
            $table->text('voice', 65535)->nullable()->comment('Voice Object. Message is a Voice, information about the Voice');
            $table->text('video_note', 65535)->nullable()->comment('VoiceNote Object. Message is a Video Note, information about the Video Note');
            $table->text('contact', 65535)->nullable()->comment('Contact object. Message is a shared contact, information about the contact');
            $table->text('location', 65535)->nullable()->comment('Location object. Message is a shared location, information about the location');
            $table->text('venue', 65535)->nullable()->comment('Venue object. Message is a Venue, information about the Venue');
            $table->text('caption', 65535)->nullable()->comment('For message with caption, the actual UTF-8 text of the caption');
            $table->text('new_chat_members',
                65535)->nullable()->comment('List of unique user identifiers, new member(s) were added to the group, information about them (one of these members may be the bot itself)');
            $table->bigInteger('left_chat_member')->nullable()->index('left_chat_member')->comment('Unique user identifier, a member was removed from the group, information about them (this member may be the bot itself)');
            $table->char('new_chat_title')->nullable()->comment('A chat title was changed to this value');
            $table->text('new_chat_photo', 65535)->nullable()->comment('Array of PhotoSize objects. A chat photo was change to this value');
            $table->boolean('delete_chat_photo')->nullable()->default(0)->comment('Informs that the chat photo was deleted');
            $table->boolean('group_chat_created')->nullable()->default(0)->comment('Informs that the group has been created');
            $table->boolean('supergroup_chat_created')->nullable()->default(0)->comment('Informs that the supergroup has been created');
            $table->boolean('channel_chat_created')->nullable()->default(0)->comment('Informs that the channel chat has been created');
            $table->bigInteger('migrate_to_chat_id')->nullable()->index('migrate_to_chat_id')->comment('Migrate to chat identifier. The group has been migrated to a supergroup with the specified identifier');
            $table->bigInteger('migrate_from_chat_id')->nullable()->index('migrate_from_chat_id')->comment('Migrate from chat identifier. The supergroup has been migrated from a group with the specified identifier');
            $table->text('pinned_message', 65535)->nullable()->comment('Message object. Specified message was pinned');
            $table->text('connected_website', 65535)->nullable()->comment('The domain name of the website on which the user has logged in.');
            $table->primary(['chat_id', 'id']);
            $table->index(['reply_to_chat', 'reply_to_message'], 'reply_to_chat_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message');
    }

}
