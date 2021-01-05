<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpTelegramBot\Laravel\Migration;

class UpdateSchema0611To0620 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table($this->prefix . 'poll', static function (Blueprint $table) {
                $table->integer('total_voter_count')->unsigned()->nullable()->comment('Total number of users that voted in the poll')->after('options');
                $table->boolean('is_anonymous')->default(1)->comment('True, if the poll is anonymous')->after('is_closed');
                $table->char('type', 255)->comment('Poll type, currently can be "regular" or "quiz"')->after('is_anonymous');
                $table->boolean('allows_multiple_answers')->default(0)->comment('True, if the poll allows multiple answers')->after('type');
                $table->integer('correct_option_id')->unsigned()->nullable()->comment('0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.')->after('allows_multiple_answers');
            });

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->text('dice')->nullable()->comment('Message is a dice with random value from 1 to 6')->after('poll');
            });

            Schema::create($this->prefix . 'poll_answer', function (Blueprint $table) {
                $table->bigInteger('poll_id')->unsigned()->comment('Unique poll identifier');
                $table->bigInteger('user_id')->comment('The user, who changed the answer to the poll');
                $table->text('option_ids')->comment('0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.');
                $table->timestamp('created_at')->nullable()->comment('Entry date creation');
                $table->primary(['poll_id', 'user_id']);
                $table->foreign('poll_id', 'poll_answer_ibfk_1')->references('id')->on($this->prefix . 'poll')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            });

            Schema::table($this->prefix . 'telegram_update', function (Blueprint $table) {
                $table->bigInteger('poll_answer_poll_id')->unsigned()->nullable()->comment('A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.')->after('poll_id');
                $table->index('poll_answer_poll_id', 'poll_answer_poll_id');
                $table->foreign('poll_answer_poll_id', 'telegram_update_ibfk_11')->references('poll_id')->on($this->prefix . 'poll_answer')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
                $table->dropForeign('telegram_update_ibfk_11');
                $table->dropIndex('poll_answer_poll_id');
                $table->dropColumn('poll_answer_poll_id');
            });

            Schema::dropIfExists($this->prefix . 'poll_answer');

            Schema::table($this->prefix . 'message', static function (Blueprint $table) {
                $table->dropColumn('dice');
            });

            Schema::table($this->prefix . 'poll', static function (Blueprint $table) {
                $table->dropColumn('correct_option_id');
                $table->dropColumn('allows_multiple_answers');
                $table->dropColumn('type');
                $table->dropColumn('is_anonymous');
                $table->dropColumn('total_voter_count');
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return; // Migration may be partly done already...
        }
    }
}
