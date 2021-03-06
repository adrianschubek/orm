<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\ORM\Relations;

use adrianschubek\ORM\ModelInterface as Model;

abstract class Relation
{
    protected Model $current;
    protected Model $relatedModel;

    abstract public function get($key);

//    abstract public function getForeignKey(): string;
}