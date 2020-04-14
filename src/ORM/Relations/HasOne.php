<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM\Relations;

class HasOne extends Relation
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
        return $this->relatedModel::getPrimaryKey();
    }
}