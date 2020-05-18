<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchema0530To0540 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('message', static function (Blueprint $table) {
                $table->text('game')->nullable()->comment('Message is a game, information about the game.')->after('document');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table('message', static function (Blueprint $table) {
                $table->dropColumn('game');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }
}
