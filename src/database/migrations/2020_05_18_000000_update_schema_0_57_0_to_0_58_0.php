<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchema0570To0580 extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('message', static function (Blueprint $table) {
                $table->text('reply_markup')->nullable()->comment('Inline keyboard attached to the message')->after('passport_data');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }

    public function down(): void
    {
        try {
            Schema::table('message', static function (Blueprint $table) {
                $table->dropColumn('reply_markup');
            });
        } catch (Exception $e) {
            // Migration may be partly done already...
        }
    }
}
