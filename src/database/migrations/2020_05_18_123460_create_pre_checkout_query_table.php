<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreCheckoutQueryTable extends Migration
{
    public function up()
    {
        Schema::create(config('phptelegrambot.database.prefix', '') . 'pre_checkout_query', static function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unsigned()->comment('Unique query identifier');
            $table->bigInteger('user_id')->index('user_id')->nullable()->comment('User who sent the query');
            $table->char ('currency', 3)->nullable()->comment ('Three-letter ISO 4217 currency code');
            $table->bigInteger('total_amount')->nullable()->comment ('Total price in the smallest units of the currency');
            $table->char ('invoice_payload', 255)->comment ('Bot specified invoice payload');
            $table->char ('shipping_option_id', 255)->nullable()->comment ('Identifier of the shipping option chosen by the user');
            $table->text ('order_info')->nullable()->comment ('Order info provided by the user');
            $table->timestamp('created_at')->nullable()->comment ('Entry date creation');
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('phptelegrambot.database.prefix', '') . 'pre_checkout_query');
    }
}
