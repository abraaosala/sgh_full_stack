<?php

namespace App\Repository;

use App\Models\Funcionario;
use Illuminate\Pagination\LengthAwarePaginator;

class FuncionarioRepository extends AbstractRepository
{
    private array $staffProfiles = ['enfermeiro', 'recepcionista'];

    public function __construct(Funcionario $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model->with('usuario')
            ->whereHas('usuario', function ($q) {
                $q->whereIn('perfil', $this->staffProfiles);
            });

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('usuario', function ($uq) use ($search) {
                    $uq->where('nome', 'LIKE', "%{$search}%");
                })->orWhere('numero_ordem', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function findWithDetails(int $id): ?Funcionario
    {
        return $this->model->with(['usuario', 'provincia'])->find($id) ?: null;
    }
}
