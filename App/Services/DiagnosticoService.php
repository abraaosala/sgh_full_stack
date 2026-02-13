<?php

namespace App\Services;

use App\Repository\DiagnosticoRepository;
use App\Models\Diagnostico;
use Illuminate\Database\Eloquent\Collection;

class DiagnosticoService extends AbstractService
{
    protected DiagnosticoRepository $repository;

    public function __construct(DiagnosticoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllDiagnosticos(): Collection
    {
        return $this->repository->getAllWithDetails();
    }

    public function getDiagnosticoById(int $id): ?Diagnostico
    {
        return $this->repository->findWithDetails($id);
    }

    public function deleteDiagnostico(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
