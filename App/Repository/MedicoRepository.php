<?php

namespace App\Repository;

use App\Models\Medico;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicoRepository extends AbstractRepository
{
    public function __construct(Medico $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model->with(['usuario', 'especialidade']);

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('usuario', function ($uq) use ($search) {
                    $uq->where('nome', 'LIKE', "%{$search}%");
                })->orWhere('numero_ordem', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function findWithDetails(int $id): ?Medico
    {
        return $this->model->with(['usuario', 'especialidade', 'provincia'])->find($id) ?: null;
    }
}
