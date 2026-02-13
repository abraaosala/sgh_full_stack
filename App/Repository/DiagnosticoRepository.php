<?php

namespace App\Repository;

use App\Models\Diagnostico;
use Illuminate\Database\Eloquent\Collection;

class DiagnosticoRepository extends AbstractRepository
{
    public function __construct(Diagnostico $model)
    {
        parent::__construct($model);
    }

    public function getAllWithDetails(): Collection
    {
        return $this->model->with(['paciente.usuario', 'medico.usuario', 'doenca'])->get();
    }

    public function findWithDetails(int $id): ?Diagnostico
    {
        return $this->model->with(['paciente.usuario', 'medico.usuario', 'doenca'])->find($id);
    }
}
