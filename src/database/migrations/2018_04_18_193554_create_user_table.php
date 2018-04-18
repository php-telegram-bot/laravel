<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->comment('Unique user identifier');
            $table->boolean('is_bot')->nullable()->default(0)->comment('True if this user is a bot');
            $table->char('first_name')->default('')->comment('User\'s first name');
            $table->char('last_name')->nullable()->comment('User\'s last name');
            $table->char('username', 191)->nullable()->index('username')->comment('User\'s username');
            $table->char('language_code', 10)->nullable()->comment('User\'s system language');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }

}
