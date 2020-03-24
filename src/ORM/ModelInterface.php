<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM;

use adrianschubek\Database\QueryBuilder\BuilderInterface;
use adrianschubek\ORM\Relations\Relation;

interface ModelInterface
{
    public static function useQueryBuilder(string $builder);

    public static function getQueryBuilder(): BuilderInterface;

    public static function getPrimaryKey(): string;

    public static function getTable(): string;

    public static function all();

    public static function where(string $column, string $value, string $operator = "=");

    public static function create(array $values);

    public function hasMany(string $related): Relation;

    public function __get($name);

    public function __set($name, $value);

    public function save(): bool;
}