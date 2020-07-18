<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Drivers;

interface DriverInterface
{
    public function connection();

    public function prepare(string $statement);

    public function query(string $statement, array $params = []);
}