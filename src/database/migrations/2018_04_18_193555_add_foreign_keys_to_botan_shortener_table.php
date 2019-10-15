<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBotanShortenerTable extends Migration
{
    public function up()
    {
        Schema::table('botan_shortener', static function (Blueprint $table) {
            $table->foreign('user_id', 'botan_shortener_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down()
    {
        Schema::table('botan_shortener', static function (Blueprint $table) {
            $table->dropForeign('botan_shortener_ibfk_1');
        });
    }
}
