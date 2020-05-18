<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollAnswerTable extends Migration
{
    public function up()
    {
        Schema::create(config('phptelegrambot.database.prefix', '') . 'poll_answer', static function (Blueprint $table) {
            $table->bigInteger('poll_id')->unsigned()->comment('Unique poll identifier');
            $table->bigInteger('user_id')->comment('The user, who changed the answer to the poll');
            $table->text ('option_ids')->comment ('0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.');
            $table->timestamp('created_at')->nullable()->comment ('Entry date creation');
            $table->primary (['poll_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('phptelegrambot.database.prefix', '') . 'poll_answer');
    }
}
