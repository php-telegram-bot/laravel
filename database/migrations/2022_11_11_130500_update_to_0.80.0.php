<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::unprepared(file_get_contents(__DIR__ . '/sql/0.79.0-0.80.0.sql'));
    }

    public function down()
    {
        //
    }
};
