<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM;

use adrianschubek\Database\QueryBuilder\BuilderInterface;
use adrianschubek\Database\QueryBuilder\HasQueryBuilder;
use Doctrine\Common\Inflector\Inflector;
use ReflectionClass;

abstract class Model implements ModelInterface
{
    use HasQueryBuilder;

    protected static string $tablename;
    protected static string $primaryKey = 'id';

    protected array $fields = [];

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function find($id)
    {
        return static::query(
            static::getQueryBuilder()
                ->select()
                ->from(static::getTable())
                ->whereIn(static::$primaryKey, $id)
        );
    }

    protected static function query(BuilderInterface $builder)
    {
        return static::toModel($builder->get());
    }

    protected static function toModel($objects)
    {
        $erg = [];
        foreach ((array)$objects as $obj) {
            $erg[] = new static($obj);
        }
        return $erg;
    }

    protected static function getTable()
    {
        if (isset(static::$tablename)) {
            return Inflector::tableize(static::$tablename);
        } else {
            return Inflector::tableize(
                Inflector::pluralize((new ReflectionClass(static::class))->getShortName())
            );
        }
    }

    public static function create(array $values)
    {
        return (new static($values))->save();
    }

    public function save(): bool
    {

    }

    public function __get($name)
    {
        return $this->fields[$name];
    }

    public function __set($name, $value)
    {
        $this->fields[$name] = $value;
    }
}