<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChosenInlineResultTable extends Migration
{
    public function up()
    {
        $tablePrefix = config('phptelegrambot.database.prefix', '');

        Schema::create($tablePrefix . 'chosen_inline_result', static function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->char('result_id')->default('')->comment('Identifier for this result');
            $table->bigInteger('user_id')->nullable()->index('user_id')->comment('Unique user identifier');
            $table->char('location')->nullable()->comment('Location object, user\'s location');
            $table->char('inline_message_id')->nullable()->comment('Identifier of the sent inline message');
            $table->text('query', 65535)->comment('The query that was used to obtain the result');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
        });
    }

    public function down()
    {
        $tablePrefix = config('phptelegrambot.database.prefix', '');

        Schema::dropIfExists($tablePrefix . 'chosen_inline_result');
    }
}
