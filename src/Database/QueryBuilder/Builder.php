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
    protected array $params = [];

    public function select($columns = "*"): BuilderInterface
    {
        $this->query[] = "SELECT `" . implode("`, `", (array)$columns) . "`";

        return $this;
    }

    public function from(string $table): BuilderInterface
    {
        $this->query[] = "FROM `$table`";

        return $this;
    }

    public function and(): BuilderInterface
    {
        $this->query[] = "AND";

        return $this;
    }

    public function or(): BuilderInterface
    {
        $this->query[] = "OR";

        return $this;
    }

    public function not(): BuilderInterface
    {
        $this->query[] = "NOT";

        return $this;
    }

    public function where(string $column, string $value, string $operator = "="): BuilderInterface
    {
        $this->params[] = $value;
        $this->query[] = "WHERE `$column` $operator ?";

        return $this;
    }

    public function whereIn(string $column, array $values): BuilderInterface
    {
        $this->params = [...$this->params, ...$values];
        $this->query[] = "WHERE $column IN ( " . implode(', ', array_fill(0, count($values), '?')) . " )";

        return $this;
    }

    public function whereNotIn(string $column, array $values): BuilderInterface
    {
        $this->params = [...$this->params, ...$values];
        $this->query[] = "WHERE $column NOT IN ( " . implode(', ', array_fill(0, count($values), '?')) . " )";

        return $this;
    }

    public function andWhere(string $column, string $value, string $operator = "="): BuilderInterface
    {
        $this->params[] = $value;
        $this->query[] = "AND $column $operator ?";

        return $this;
    }

    public function orWhere(string $column, string $value, string $operator = "="): BuilderInterface
    {
        $this->params[] = $value;
        $this->query[] = "OR $column $operator ?";

        return $this;
    }

    public function limit(int $start, int $offset): BuilderInterface
    {
        $this->params[] = $start;
        $this->params[] = $offset;
        $this->query[] = "LIMIT ?, ?";

        return $this;
    }

    public function isNull(): BuilderInterface
    {
        $this->query[] = "IS NULL";

        return $this;
    }

    public function selectDistrinct($columns = "*"): BuilderInterface
    {
        $this->query[] = "SELECT DISTINCT `" . implode("`, `", (array)$columns) . "`";

        return $this;
    }

    public function isNotNull(): BuilderInterface
    {
        $this->query[] = "IS NOT NULL";

        return $this;
    }

    public function raw(string $sql): BuilderInterface
    {
        $this->query[] = $sql;

        return $this;
    }

    public function insertInto(string $table, array $data): BuilderInterface
    {
        $keys = [];
        foreach ($data as $key => $value) {
            $keys[] = "`{$key}`";
            $this->params[] = $value;
        }

        $this->query[] = "INSERT INTO $table (" . implode(", ", $keys) . ") VALUES (" . implode(', ', array_fill(0, count($keys), '?')) . ")";

        return $this;
    }

    public function update(string $table, array $data): BuilderInterface
    {
        $keys = [];
        foreach ($data as $key => $value) {
            $keys[] = "`{$key}` = ?";
            $this->params[] = $value;
        }

        $this->query[] = "UPDATE $table SET " . implode(", ", $keys);

        return $this;
    }

    public function group(BuilderInterface $builder): BuilderInterface
    {
        $this->params[] = $builder->toSql();

        return $this;
    }

    public function orderBy(string $column, string $order = "asc"): BuilderInterface
    {
        if (mb_strtolower($order) === "asc") {
            $this->query[] = "ORDER BY $column ASC";
        } else {
            $this->query[] = "ORDER BY $column DESC";
        }

        return $this;
    }

    public function delete(string $table): BuilderInterface
    {
        $this->query[] = "DELETE FROM $table";

        return $this;
    }

    public function getAsJSON(): string
    {
        return json_encode(array_values($this->get()), JSON_FORCE_OBJECT);
    }

    public function get()
    {
        return static::getConnection()->query($this->toRawSql(), $this->params);
    }

    public function toRawSql(): string
    {
        return implode(" ", $this->query);
    }

    public function toSql(): string
    {
        return $this->interpolateQuery($this->toRawSql(), $this->params);
    }

    private function interpolateQuery(string $query, array $params): string
    {
        // Fake Query
        $keys = [];

        foreach ($params as $key => &$value) {
            $value = "'" . $value . "'";
            if (is_string($key)) {
                $keys[] = '/:' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }
        }

        $query = preg_replace($keys, $params, $query, 1, $count);

        return $query;
    }

    public function whereExists(BuilderInterface $builder): BuilderInterface
    {
        // TODO: Implement whereExists() method.
    }

    public function groupBy(string $column): BuilderInterface
    {
        // TODO: Implement groupBy() method.
    }

    public function having(string $column, string $value, string $operator = "="): BuilderInterface
    {
        // TODO: Implement having() method.
    }

    public function getParams(): array
    {
        return $this->params;
    }
}