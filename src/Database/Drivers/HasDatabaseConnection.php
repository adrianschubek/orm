<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Drivers;

use adrianschubek\Database\Drivers\DriverInterface as Driver;

trait HasDatabaseConnection
{
    protected static Driver $db;

    public static function useDriver(Driver $connection)
    {
        static::$db = $connection;
    }

    public static function getDriver(): Driver
    {
        return static::$db;
    }
}