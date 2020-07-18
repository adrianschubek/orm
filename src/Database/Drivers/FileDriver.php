<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Drivers;


use adrianschubek\FileDb\FileDb;

class FileDriver implements DriverInterface
{
    private FileDb $db;

    public function __construct(string $db)
    {
        $this->db = new FileDb($db);
    }

    public function connection()
    {
        return $this->db;
    }

    public function prepare(string $statement)
    {

    }

    public function query(string $statement, array $params = [])
    {

    }
}