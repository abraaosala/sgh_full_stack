<?php

namespace App\Services;

use App\Repository\PacienteRepository;
use App\Models\User;
use App\Models\Paciente;
use App\classes\Password;
use App\Services\MailService;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PacienteService extends AbstractService
{
    protected PacienteRepository $repository;

    public function __construct(PacienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedList(?string $search = null, int $perPage = 5): LengthAwarePaginator
    {
        return $this->repository->paginateWithFilters($search, $perPage);
    }

    public function getPacienteById(int $id): ?Paciente
    {
        return $this->repository->findWithDetails($id);
    }

    public function getPacienteDetails(int $id): array
    {
        $paciente = $this->getPacienteById($id);

        if (!$paciente) {
            return ['error' => 'Paciente não encontrado'];
        }

        return [
            'id' => $paciente->id,
            'code' => $paciente->code,
            'nome' => $paciente->usuario->nome,
            'email' => $paciente->usuario->email,
            'telefone' => $paciente->telefone,
            'genero' => genero($paciente->usuario->genero),
            'data_nascimento' => date('d/m/Y', strtotime($paciente->usuario->data_nascimento)),
            'provincia' => $paciente->provincia->nome ?? 'N/A',
            'endereco' => $paciente->endereco
        ];
    }

    public function storePaciente(array $data): array
    {
        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'data_nascimento' => 'required|date',
            'telefone' => 'required',
            'endereco' => 'required',
            'provincia_id' => 'required|integer',
            'genero' => 'required'
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
                'email' => lower($data['email']),
                'perfil' => 'paciente',
                'genero' => $data['genero'],
                'data_nascimento' => $data['data_nascimento'],
                'senha' => Password::hash($senha),
                'senha_gerada' => 1
            ]);

            $paciente = $user->paciente()->create([
                'code' => gerarCodigo(),
                'telefone' => $data['telefone'],
                'endereco' => $data['endereco'],
                'provincia_id' => $data['provincia_id']
            ]);

            DB::commit();

            // Send Email (Coordinator role of Service)
            try {
                (new MailService())->sendCredentials($data['email'], $data['nome'], $senha);
            } catch (\Exception $e) {
                // Log email error but don't fail registration
            }

            return [
                'success' => true,
                'paciente' => $paciente,
                'senha' => $senha
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updatePaciente(int $id, array $data): bool
    {
        $paciente = $this->repository->find($id);
        if (!$paciente) {
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

        if (User::where('email', $data['email'])->where('id', '!=', $paciente->usuario_id)->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        DB::beginTransaction();
        try {
            $paciente->usuario()->update([
                'nome' => $data['nome'],
                'email' => lower($data['email']),
                'genero' => $data['genero'],
                'data_nascimento' => $data['data_nascimento'] ?? $paciente->usuario->data_nascimento
            ]);

            $paciente->update([
                'telefone' => $data['telefone'] ?? $paciente->telefone,
                'endereco' => $data['endereco'] ?? $paciente->endereco,
                'provincia_id' => $data['provincia_id'] ?? $paciente->provincia_id
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletePaciente(int $id): bool
    {
        $paciente = $this->repository->find($id);
        if (!$paciente) {
            return false;
        }

        DB::beginTransaction();
        try {
            $usuarioId = $paciente->usuario_id;
            $paciente->delete();
            User::destroy($usuarioId);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
