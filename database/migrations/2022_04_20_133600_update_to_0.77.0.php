<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/0.76.1-0.77.0.sql'));
    }

    public function down()
    {
        //
    }
};
