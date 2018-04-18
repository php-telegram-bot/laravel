<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChosenInlineResultTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chosen_inline_result', function (Blueprint $table) {
            $table->foreign('user_id', 'chosen_inline_result_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chosen_inline_result', function (Blueprint $table) {
            $table->dropForeign('chosen_inline_result_ibfk_1');
        });
    }

}
