<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/structure-0.73.0.sql'));
    }

    public function down()
    {
        //
    }
};
