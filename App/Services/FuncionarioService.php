<?php

namespace App\Services;

use App\Repository\FuncionarioRepository;
use App\Models\User;
use App\Models\Funcionario;
use App\classes\Password;
use App\Services\MailService;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Pagination\LengthAwarePaginator;

class FuncionarioService extends AbstractService
{
    protected FuncionarioRepository $repository;

    public function __construct(FuncionarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedList(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        return $this->repository->paginateWithFilters($search, $perPage);
    }

    public function getFuncionarioById(int $id): ?Funcionario
    {
        return $this->repository->findWithDetails($id);
    }

    public function getFuncionarioDetails(int $id): array
    {
        $funcionario = $this->getFuncionarioById($id);

        if (!$funcionario) {
            return ['error' => 'Funcionário não encontrado'];
        }

        return [
            'id' => $funcionario->id,
            'nome' => $funcionario->usuario->nome,
            'email' => $funcionario->usuario->email,
            'perfil' => ucfirst((string) $funcionario->usuario->perfil),
            'genero' => genero($funcionario->usuario->genero),
            'data_nascimento' => date('d/m/Y', strtotime((string) $funcionario->usuario->data_nascimento)),
            'telefone' => $funcionario->telefone,
            'numero_ordem' => $funcionario->numero_ordem,
            'nivel' => $funcionario->nivel,
            'provincia' => $funcionario->provincia->nome ?? 'N/A'
        ];
    }

    public function storeFuncionario(array $data): array
    {
        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'data_nascimento' => 'required|date',
            'telefone' => 'required',
            'genero' => 'required',
            'perfil' => 'required',
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
                'perfil' => strtolower((string) $data['perfil']),
                'genero' => $data['genero'],
                'data_nascimento' => $data['data_nascimento'],
                'senha' => Password::hash($senha),
                'senha_gerada' => 1
            ]);

            $funcionario = $user->funcionario()->create([
                'telefone' => $data['telefone'],
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
                'funcionario' => $funcionario,
                'senha' => $senha
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateFuncionario(int $id, array $data): bool
    {
        $funcionario = $this->repository->find($id);
        if (!$funcionario) {
            return false;
        }

        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'genero' => 'required',
            'perfil' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        if (User::where('email', $data['email'])->where('id', '!=', $funcionario->usuario_id)->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        DB::beginTransaction();
        try {
            $funcionario->usuario()->update([
                'nome' => $data['nome'],
                'email' => strtolower((string) $data['email']),
                'genero' => $data['genero'],
                'perfil' => strtolower((string) ($data['perfil'] ?? $funcionario->usuario->perfil)),
                'data_nascimento' => $data['data_nascimento'] ?? $funcionario->usuario->data_nascimento
            ]);

            $funcionario->update([
                'telefone' => $data['telefone'] ?? $funcionario->telefone,
                'provincia_id' => $data['provincia_id'] ?? $funcionario->provincia_id,
                'numero_ordem' => $data['numero_ordem'] ?? $funcionario->numero_ordem,
                'nivel' => $data['nivel'] ?? $funcionario->nivel,
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteFuncionario(int $id): bool
    {
        $funcionario = $this->repository->find($id);
        if (!$funcionario) {
            return false;
        }

        DB::beginTransaction();
        try {
            $usuarioId = $funcionario->usuario_id;
            $funcionario->delete();
            User::destroy($usuarioId);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
