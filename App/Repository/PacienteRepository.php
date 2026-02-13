<?php

namespace App\Repository;

use App\Models\Paciente;
use Illuminate\Pagination\LengthAwarePaginator;

class PacienteRepository extends AbstractRepository
{
    public function __construct(Paciente $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model->with('usuario');

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('usuario', function ($uq) use ($search) {
                    $uq->where('nome', 'LIKE', "%{$search}%");
                })->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function findWithDetails(int $id): ?Paciente
    {
        return $this->model->with(['usuario', 'provincia'])->find($id) ?: null;
    }
}
