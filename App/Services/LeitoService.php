<?php

namespace App\Services;

use App\Repository\LeitoRepository;
use App\Models\Leito;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Collection;

class LeitoService extends AbstractService
{
    protected LeitoRepository $repository;

    public function __construct(LeitoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllLeitos(): Collection
    {
        return $this->repository->getAllOrdered();
    }

    public function getLeitoById(int $id): ?Leito
    {
        return $this->repository->find($id);
    }

    public function storeLeito(array $data): Leito
    {
        $validator = ValidatorHelper::make($data, [
            'numero' => 'required',
            'tipo' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        return $this->repository->create([
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'] ?? 'Disponível',
            'descricao' => $data['descricao'] ?? null
        ]);
    }

    public function updateLeito(int $id, array $data): bool
    {
        $leito = $this->repository->find($id);
        if (!$leito) {
            return false;
        }

        $validator = ValidatorHelper::make($data, [
            'numero' => 'required',
            'tipo' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        return $this->repository->update($id, [
            'numero' => $data['numero'],
            'tipo' => $data['tipo'],
            'status' => $data['status'],
            'descricao' => $data['descricao'] ?? $leito->descricao
        ]);
    }

    public function deleteLeito(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
