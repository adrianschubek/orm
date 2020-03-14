<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Connection;

interface ConnectionInterface
{
    function connection();

    function query(string $statement, array $params = []);
}