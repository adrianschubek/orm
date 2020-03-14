<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM;

use adrianschubek\Database\QueryBuilder\BuilderInterface;

interface ModelInterface
{
    public static function useQueryBuilder(string $builder);

    public static function getQueryBuilder(): BuilderInterface;

    public static function all();

    public static function create(array $values);

    public function __get($name);

    public function __set($name, $value);

    public function save(): bool;
}