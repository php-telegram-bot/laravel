<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToChosenInlineResultTable extends Migration
{
    public function up(): void
    {
        Schema::table('chosen_inline_result', static function (Blueprint $table) {
            $table->foreign('user_id', 'chosen_inline_result_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::table('chosen_inline_result', static function (Blueprint $table) {
            $table->dropForeign('chosen_inline_result_ibfk_1');
        });
    }
}
