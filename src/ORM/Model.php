<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM;

use adrianschubek\Database\QueryBuilder\BuilderInterface;
use adrianschubek\Database\QueryBuilder\HasQueryBuilder;
use adrianschubek\ORM\Relations\BelongsTo;
use adrianschubek\ORM\Relations\HasMany;
use adrianschubek\ORM\Relations\Relation;
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

    public static function all()
    {
        return static::query(
            static::getQueryBuilder()
                ->select()
                ->from(static::getTable())
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
        if (count($erg) === 1) return $erg[0];
        return $erg;
    }

    public static function getTable(): string
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
        (new static($values))->save();
    }

    public function save()
    {
        static::getQueryBuilder()->insertOrUpdate(static::getTable(), $this->fields)->get();
    }

    public static function find($id)
    {
        return static::query(
            static::getQueryBuilder()
                ->select()
                ->from(static::getTable())
                ->whereIn(static::$primaryKey, (array)$id)
        );
    }

    public static function where(string $column, string $value, string $operator = "=")
    {
        return static::query(
            static::getQueryBuilder()
                ->select()
                ->from(static::getTable())
                ->where($column, $value, $operator)
        );
    }

    public function hasMany(string $related): Relation
    {
        return new HasMany($related, static::class);
    }

    public function belongsTo(string $related): Relation
    {
        return new BelongsTo($related, static::class);
    }

    public function __get($name)
    {
        if (method_exists(static::class, $name)) {
            $var = $this->$name(static::$primaryKey);
            return $var->get($this->{static::getPrimaryKey()});
        }
        return $this->fields[$name];
    }

    public function __set($name, $value)
    {
        $this->fields[$name] = $value;
    }

    public static function getPrimaryKey(): string
    {
        return static::$primaryKey;
    }
}