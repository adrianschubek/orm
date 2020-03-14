<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\QueryBuilder;


use adrianschubek\Database\Connection\HasDatabaseConnection;

class Builder implements BuilderInterface
{
    use HasDatabaseConnection;

    protected array $query = [];

    public function select($fields = "*"): BuilderInterface
    {
        $this->query[] = "SELECT " . implode(", ", (array)$fields);

        return $this;
    }

    public function from(string $table): BuilderInterface
    {
        $this->query[] = "FROM $table";

        return $this;
    }

    public function where(string $field, string $value, string $operator = "="): BuilderInterface
    {
        $this->query[] = "WHERE $field $operator $value";

        return $this;
    }

    public function whereIn(string $field, array $values): BuilderInterface
    {
        $this->query[] = "WHERE $field IN ( " . implode(", ", $values) . " )";

        return $this;
    }

    public function whereNotIn(string $field, array $values): BuilderInterface
    {
        $this->query[] = "WHERE $field NOT IN ( " . implode(", ", $values) . " )";

        return $this;
    }

    public function andWhere(string $field, string $value, string $operator = "="): BuilderInterface
    {
        $this->query[] = "AND $field $operator $value";

        return $this;
    }

    public function orWhere(string $field, string $value, string $operator = "="): BuilderInterface
    {
        $this->query[] = "OR $field $operator $value";

        return $this;
    }

    public function limit(int $start, int $offset): BuilderInterface
    {
        $this->query[] = "LIMIT $start, $offset";

        return $this;
    }

    public function raw(string $sql): BuilderInterface
    {
        $this->query[] = $sql;

        return $this;
    }

    public function insert(string $table, array $values): BuilderInterface
    {
        $this->query[] = "INSERT INTO $table";

        return $this;
    }

    public function getAsJSON()
    {
        return json_encode(array_values($this->get()), JSON_FORCE_OBJECT);
    }

    public function get()
    {
        return static::getConnection()->query($this->toSql());
    }

    public function toSql(): string
    {
        return implode(" ", $this->query);
    }
}