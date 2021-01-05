<?php

declare(strict_types=1);

use PhpTelegramBot\Laravel\Migration;

class ConvertDatetimeToTimetamp extends Migration
{
    /** @var array[] Fields that require DATETIME to TIMESTAMP conversion. */
    private $table_columns = [
        'callback_query'       => ['created_at'],
        'chosen_inline_result' => ['created_at'],
        'edited_message'       => ['edit_date'],
        'inline_query'         => ['created_at'],
        'message'              => ['date', 'forward_date'],
        'request_limiter'      => ['created_at'],
    ];

    public function up(): void
    {
        $this->changeColumnTypes($this->table_columns, 'TIMESTAMP NULL DEFAULT NULL');
    }

    public function down(): void
    {
        $this->changeColumnTypes($this->table_columns, 'DATETIME NULL DEFAULT NULL');
    }
}
