<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\QueryBuilder;


trait HasQueryBuilder
{
    protected static string $builder;

    public static function useQueryBuilder(string $builder)
    {
        static::$builder = $builder;
    }

    public static function getQueryBuilder(): BuilderInterface
    {
        return new static::$builder();
    }
}