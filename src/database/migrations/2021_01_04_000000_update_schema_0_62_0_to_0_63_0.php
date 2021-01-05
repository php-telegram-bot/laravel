<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0620To0630 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'poll', static function (Blueprint $table) {
                $table->char('explanation', 255)->nullable()->comment('Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters')->after('correct_option_id');
                $table->text('explanation_entities')->nullable()->comment('Special entities like usernames, URLs, bot commands, etc. that appear in the explanation')->after('explanation');
                $table->integer('open_period')->unsigned()->nullable()->comment('Amount of time in seconds the poll will be active after creation')->after('explanation_entities');
                $table->timestamp('close_date')->nullable()->comment('Point in time (Unix timestamp) when the poll will be automatically closed')->after('open_period');
            });

            Schema::table($this->prefix . 'poll_answer', static function (Blueprint $table) {
                $table->dropPrimary();
                $table->primary(['poll_id', 'user_id']);
            });

            Schema::table($this->prefix . 'message', function (Blueprint $table) {
                $table->dropForeign('message_ibfk_6');
                $table->dropIndex('message_ibfk_6');

                $table->bigInteger('via_bot')->nullable()->comment('Optional. Bot through which the message was sent')->after('reply_to_message');
                $table->index('via_bot');
                $table->foreign('via_bot', 'message_ibfk_9')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table($this->prefix . 'poll', static function (Blueprint $table) {
                $table->dropColumn('explanation');
                $table->dropColumn('explanation_entities');
                $table->dropColumn('open_period');
                $table->dropColumn('close_date');
            });

            Schema::table($this->prefix . 'poll_answer', static function (Blueprint $table) {
                $table->dropPrimary();
                $table->primary('poll_id');
            });

            Schema::table($this->prefix . 'message', function (Blueprint $table) {
                $table->dropForeign('message_ibfk_9');
                $table->dropIndex('via_bot');
                $table->dropColumn('via_bot');

                $table->foreign('forward_from', 'message_ibfk_6')->references('id')->on($this->prefix . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
