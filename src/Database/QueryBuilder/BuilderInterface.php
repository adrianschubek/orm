<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\QueryBuilder;


interface BuilderInterface
{
    public function select($columns = "*"): self;

    public function selectDistrinct($columns = "*"): self;

    public function from(string $table): self;

    public function where(string $column, string $value, string $operator = "="): self;

    public function whereExists(BuilderInterface $builder): self;

    public function whereIn(string $column, array $values): self;

    public function whereNotIn(string $column, array $values): self;

    public function andWhere(string $column, string $value, string $operator = "="): self;

    public function orWhere(string $column, string $value, string $operator = "="): self;

    public function and(): self;

    public function or(): self;

    public function not(): self;

    public function orderBy(string $column, string $order = "asc"): self;

    public function limit(int $start, int $offset): self;

    public function insertInto(string $table, array $data): self;

    public function insertOrUpdate(string $table, array $data): self;

    public function update(string $table, array $data): self;

    public function delete(string $table): self;

    public function isNull(): self;

    public function isNotNull(): self;

    public function group(BuilderInterface $builder): self;

    public function groupBy(string $column): self;

    public function having(string $column, string $value, string $operator = "="): self;

    public function raw(string $sql): self;

    public function toSql(): string;

    public function toRawSql(): string;

    public function get();

    public function getAsJSON(): string;

    public function getParams(): array;
}