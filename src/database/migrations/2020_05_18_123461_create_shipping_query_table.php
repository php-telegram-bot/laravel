<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingQueryTable extends Migration
{
    public function up()
    {
        Schema::create(config('phptelegrambot.database.prefix', '') . 'shipping_query', static function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unsigned()->comment('Unique query identifier');
            $table->bigInteger('user_id')->index('user_id')->nullable()->comment('User who sent the query');
            $table->char ('invoice_payload', 255)->default('')->comment ('Bot specified invoice payload');
            $table->char ('shipping_address', 255)->default('')->comment ('User specified shipping address');
            $table->timestamp('created_at')->nullable()->comment ('Entry date creation');
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('phptelegrambot.database.prefix', '') . 'shipping_query');
    }
}
