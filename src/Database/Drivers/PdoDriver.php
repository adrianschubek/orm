<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Drivers;

use PDO;
use PDOStatement;

class PdoDriver implements DriverInterface
{
    private PDO $pdo;

    public function __construct(string $database, string $host, string $user, string $password, array $options = null)
    {
        $this->pdo = new PDO("mysql:dbname={$database};host={$host}", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, !!($options["emulate"] ?? false));
//        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, !!($options["fetch"] ?? PDO::FETCH_ASSOC));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, !!($options["error"] ?? PDO::ERRMODE_EXCEPTION));
    }

    public function connection()
    {
        return $this->pdo;
    }

    public function query(string $statement, array $params = [])
    {
        $stmnt = $this->prepare($statement);
        $this->execute($stmnt, $params);

        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prepare(string $statement): PDOStatement
    {
        return $this->pdo->prepare($statement);
    }

    public function execute(PDOStatement $statement, array $params)
    {
        return $statement->execute($params);
    }
}