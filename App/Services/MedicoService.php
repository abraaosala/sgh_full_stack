<?php

namespace App\Services;

use App\Repository\MedicoRepository;
use App\Models\User;
use App\Models\Medico;
use App\classes\Password;
use App\Services\MailService;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicoService extends AbstractService
{
    protected MedicoRepository $repository;

    public function __construct(MedicoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedList(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        return $this->repository->paginateWithFilters($search, $perPage);
    }

    public function getMedicoById(int $id): ?Medico
    {
        return $this->repository->findWithDetails($id);
    }

    public function getMedicoDetails(int $id): array
    {
        $medico = $this->getMedicoById($id);

        if (!$medico) {
            return [];
        }

        $data = $medico->toArray();
        $data['nome'] = $medico->usuario->nome ?? '';
        $data['email'] = $medico->usuario->email ?? '';
        $data['especialidade'] = $medico->especialidade->nome ?? '';
        $data['provincia'] = $medico->provincia->nome ?? '';

        return $data;
    }

    public function storeMedico(array $data): array
    {
        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'data_nascimento' => 'required|date',
            'telefone' => 'required',
            'genero' => 'required',
            'especialidade_id' => 'required|integer',
            'provincia_id' => 'required|integer',
            'numero_ordem' => 'required',
            'nivel' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        if (User::where('email', $data['email'])->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        DB::beginTransaction();
        try {
            $senha = Password::generate(2);
            $user = User::create([
                'nome' => $data['nome'],
                'email' => strtolower((string) $data['email']),
                'perfil' => $data['perfil'] ?? 'medico',
                'genero' => $data['genero'],
                'data_nascimento' => $data['data_nascimento'],
                'senha' => Password::hash($senha),
                'senha_gerada' => 1
            ]);

            $medico = $user->medico()->create([
                'telefone' => $data['telefone'],
                'especialidade_id' => $data['especialidade_id'],
                'provincia_id' => $data['provincia_id'],
                'numero_ordem' => $data['numero_ordem'],
                'nivel' => $data['nivel'],
                'hospital' => $data['hospital'] ?? HOSPITAL
            ]);

            DB::commit();

            try {
                (new MailService())->sendCredentials($data['email'], $data['nome'], $senha);
            } catch (\Exception $e) {
                // Log email error
            }

            return [
                'success' => true,
                'medico' => $medico,
                'senha' => $senha
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateMedico(int $id, array $data): bool
    {
        $medico = $this->repository->find($id);
        if (!$medico) {
            return false;
        }

        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'genero' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        if (User::where('email', $data['email'])->where('id', '!=', $medico->usuario_id)->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        DB::beginTransaction();
        try {
            $medico->usuario()->update([
                'nome' => $data['nome'],
                'email' => strtolower((string) $data['email']),
                'genero' => $data['genero'],
                'data_nascimento' => $data['data_nascimento'] ?? $medico->usuario->data_nascimento
            ]);

            $medico->update([
                'telefone' => $data['telefone'] ?? $medico->telefone,
                'especialidade_id' => $data['especialidade_id'] ?? $medico->especialidade_id,
                'provincia_id' => $data['provincia_id'] ?? $medico->provincia_id,
                'numero_ordem' => $data['numero_ordem'] ?? $medico->numero_ordem,
                'nivel' => $data['nivel'] ?? $medico->nivel,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteMedico(int $id): bool
    {
        $medico = $this->repository->find($id);
        if (!$medico) {
            return false;
        }

        DB::beginTransaction();
        try {
            $usuarioId = $medico->usuario_id;
            $medico->delete();
            User::destroy($usuarioId);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
