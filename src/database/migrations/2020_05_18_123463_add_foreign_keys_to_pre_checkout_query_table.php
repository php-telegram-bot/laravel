<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPreCheckoutQueryTable extends Migration
{
    public function up()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'pre_checkout_query', static function (Blueprint $table) {
            $table->foreign('user_id', config('phptelegrambot.database.prefix', '') . 'pre_checkout_query_ibfk_1')->references('id')->on(config('phptelegrambot.database.prefix', '') . 'user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table(config('phptelegrambot.database.prefix', '') . 'pre_checkout_query', static function (Blueprint $table) {
            $table->dropForeign(config('phptelegrambot.database.prefix', '') . 'pre_checkout_query_ibfk_1');
        });
    }
}
