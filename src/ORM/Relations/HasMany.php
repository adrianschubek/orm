<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM\Relations;

use Doctrine\Common\Inflector\Inflector;

class HasMany extends Relation
{
    public function __construct(string $model, string $current)
    {
        $this->relatedModel = new $model;
        $this->current = new $current;
    }

    public function getRelatedKey(): string
    {
        return Inflector::singularize($this->current::getTable()) . "_" . mb_strtolower($this->relatedModel::getPrimaryKey());
    }
}