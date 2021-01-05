<?php

/*
 * This file is part of the PhpTelegramBot/Laravel package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpTelegramBot\Laravel;

use Illuminate\Support\Facades\DB;

class Migration extends \Illuminate\Database\Migrations\Migration
{
    /** @var string */
    protected $prefix = '';

    public function __construct()
    {
        $this->prefix = (string) config('phptelegrambot.database.prefix', '');
    }

    /**
     * Change column type for passed table field(s).
     *
     * @param array  $table_columns
     * @param string $new_type
     */
    public function changeColumnTypes(array $table_columns, string $new_type): void
    {
        $database = DB::connection()->getDatabaseName();
        $prefix   = DB::connection()->getTablePrefix() . $this->prefix;

        foreach ($table_columns as $table => $columns) {
            foreach ($columns as $column) {
                // Preserve column comment and nullable state.
                $props = DB::selectOne('
                    SELECT `COLUMN_COMMENT`, `IS_NULLABLE`
                    FROM `information_schema`.`COLUMNS`
                    WHERE `TABLE_SCHEMA` = ?
                      AND `TABLE_NAME` = ?
                      AND `COLUMN_NAME` = ?
                    LIMIT 1
                ', [$database, $prefix . $table, $column]);

                $comment  = $props->COLUMN_COMMENT;
                $nullable = $props->IS_NULLABLE === 'YES' ? 'NULL' : 'NOT NULL';
                DB::statement("ALTER TABLE `{$prefix}{$table}` CHANGE `{$column}` `{$column}` {$new_type} {$nullable} COMMENT '{$comment}'");
            }
        }
    }
}
