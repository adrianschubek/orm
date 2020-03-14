<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\QueryBuilder;


interface BuilderInterface
{
    public function select($fields = "*"): self;

    public function from(string $table): self;

    public function where(string $field, string $value, string $operator = "="): self;

    public function whereIn(string $field, array $values): self;

    public function whereNotIn(string $field, array $values): self;

    public function andWhere(string $field, string $value, string $operator = "="): self;

    public function orWhere(string $field, string $value, string $operator = "="): self;

    public function limit(int $start, int $offset): self;

    public function insert(string $table, array $data): self;

    public function update(string $table, array $data): self;

    public function raw(string $sql): self;

    public function toSql(): string;

    public function get();

    public function getAsJSON();
}