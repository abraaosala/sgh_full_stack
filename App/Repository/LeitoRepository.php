<?php

namespace App\Repository;

use App\Models\Leito;
use Illuminate\Database\Eloquent\Collection;

class LeitoRepository extends AbstractRepository
{
    public function __construct(Leito $model)
    {
        parent::__construct($model);
    }

    public function getAllOrdered(string $column = 'id', string $direction = 'desc'): Collection
    {
        return $this->model->orderBy($column, $direction)->get();
    }
}
