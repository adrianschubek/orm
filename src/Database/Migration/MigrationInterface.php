<?php
/**
 * Copyright (c) 2020. Adrian Schubek
 * https://adriansoftware.de
 */

namespace adrianschubek\Database\Migration;


interface MigrationInterface
{
    public function create(string $table, Schema $schema): self;

    public function drop(string $table): self;
}