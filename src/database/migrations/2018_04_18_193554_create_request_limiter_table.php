<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestLimiterTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_limiter', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->comment('Unique identifier for this entry');
            $table->char('chat_id')->nullable()->comment('Unique chat identifier');
            $table->char('inline_message_id')->nullable()->comment('Identifier of the sent inline message');
            $table->char('method')->nullable()->comment('Request method');
            $table->dateTime('created_at')->nullable()->comment('Entry date creation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_limiter');
    }

}
