<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM\Relations;

use Doctrine\Inflector\InflectorFactory;

class HasMany extends Relation
{
    public function __construct(string $model, string $current)
    {
        $this->relatedModel = new $model;
        $this->current = new $current;
    }

    public function get($key)
    {
        return $this->relatedModel::where($this->getForeignKey(), $key);
    }

    public function getForeignKey(): string
    {
        $inflector = InflectorFactory::create()->build();

        return $inflector->singularize($this->current::getTable()) . "_" . mb_strtolower($this->relatedModel::getPrimaryKey());
    }
}