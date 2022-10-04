<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/0.77.1-0.78.0.sql'));
    }

    public function down()
    {
        //
    }
};
