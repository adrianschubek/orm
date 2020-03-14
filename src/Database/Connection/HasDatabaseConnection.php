<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Connection;

use adrianschubek\Database\Connection\ConnectionInterface as Connection;

trait HasDatabaseConnection
{
    protected static Connection $db;

    public static function useConnection(Connection $connection)
    {
        static::$db = $connection;
    }

    public static function getConnection(): Connection
    {
        return static::$db;
    }
}