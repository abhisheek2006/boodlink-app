<?php

namespace App\Support;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

/**
 * Builds driver-portable SQL date expressions.
 *
 * MySQL exposes DATE_FORMAT(), SQLite exposes strftime(). This keeps the
 * analytics/report queries working regardless of DB_CONNECTION.
 */
class DateExpr
{
    public static function month(string $column, ?Connection $connection = null): string
    {
        return static::driver($connection) === 'sqlite'
            ? "strftime('%Y-%m', {$column})"
            : "DATE_FORMAT({$column}, '%Y-%m')";
    }

    public static function year(string $column, ?Connection $connection = null): string
    {
        return static::driver($connection) === 'sqlite'
            ? "CAST(strftime('%Y', {$column}) AS INTEGER)"
            : "CAST(DATE_FORMAT({$column}, '%Y') AS UNSIGNED)";
    }

    protected static function driver(?Connection $connection = null): string
    {
        return ($connection ?? DB::connection())->getDriverName();
    }
}
