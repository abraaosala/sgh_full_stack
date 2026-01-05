<?php

namespace App\Dao\interfaces;

interface RelationShipInterface
{
    public function createWith($modelClass, $relationClass, $foreignKey, $results);
}
