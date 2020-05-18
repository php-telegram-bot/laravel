<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchema0611To0620 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('poll', static function (Blueprint $table) {
                $table->integer('total_voter_count')->unsigned()->comment('Total number of users that voted in the poll')->after('options');
                $table->tinyInteger('is_anonymous')->default(1)->comment('True, if the poll is anonymous')->after('is_closed');
                $table->char('type', 255)->comment('Poll type, currently can be “regular” or “quiz”')->after('is_anonymous');
                $table->tinyInteger('allows_multiple_answers')->default(0)->comment('True, if the poll allows multiple answers')->after('type');
                $table->integer('correct_option_id')->unsigned()->comment('0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.')->after('allows_multiple_answers');
            });

            Schema::table('message', static function (Blueprint $table) {
                $table->text('dice')->nullable()->comment('Message is a dice with random value from 1 to 6')->after('poll');
            });

            Schema::create('poll_answer', static function (Blueprint $table) {
                $table->bigInteger('poll_id', true, true)->comment('Unique poll identifier');
                $table->bigInteger('user_id')->nullable(false)->comment('The user, who changed the answer to the poll');
                $table->text('option_ids')->nullable(false)->comment('0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.');
                $table->dateTime('created_at')->nullable()->comment('Entry date creation');
                $table->foreign('poll_id', 'poll_answer_ibfk_1')->references('id')->on('poll')->onUpdate('CASCADE')->onDelete('CASCADE');
            });

            Schema::table('telegram_update', static function (Blueprint $table) {
                $table->bigInteger('poll_answer_poll_id')->unsigned()->nullable()->comment('A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by the bot itself.')->after('poll_id');
                $table->index('poll_answer_poll_id', 'poll_answer_poll_id');
                $table->foreign('poll_answer_poll_id', 'telegram_update_ibfk_11')->references('poll_id')->on('poll_answer')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table('telegram_update', static function (Blueprint $table) {
                $table->dropForeign('telegram_update_ibfk_11');
                $table->dropIndex('poll_answer_poll_id');
                $table->dropColumn('poll_answer_poll_id');
            });

            Schema::dropIfExists('poll_answer');

            Schema::table('message', static function (Blueprint $table) {
                $table->dropColumn('dice');
            });

            Schema::table('poll', static function (Blueprint $table) {
                $table->dropColumn('correct_option_id');
                $table->dropColumn('allows_multiple_answers');
                $table->dropColumn('type');
                $table->dropColumn('is_anonymous');
                $table->dropColumn('total_voter_count');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }
}
