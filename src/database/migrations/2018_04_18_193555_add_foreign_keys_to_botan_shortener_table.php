<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBotanShortenerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('botan_shortener', function (Blueprint $table) {
            $table->foreign('user_id', 'botan_shortener_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('botan_shortener', function (Blueprint $table) {
            $table->dropForeign('botan_shortener_ibfk_1');
        });
    }

}
