<?php

namespace App\Services;

use App\Models\User;
use App\classes\Password;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends AbstractService
{
    public function getPaginatedList(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = User::where('perfil', '!=', 'superadmin');

        if (!empty($search)) {
            $query->where(function ($sub) use ($search) {
                $sub->where('nome', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function storeUser(array $data): array
    {
        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'perfil' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        if (User::where('email', $data['email'])->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        $password = Password::generate(3);

        $user = User::create([
            'nome' => $data['nome'],
            'email' => strtolower((string) $data['email']),
            'perfil' => $data['perfil'],
            'senha' => Password::hash($password),
            'senha_gerada' => 1
        ]);

        try {
            (new MailService())->sendCredentials($data['email'], $data['nome'], $password);
        } catch (\Exception $e) {
            // Log email error
        }

        return [
            'user' => $user,
            'senha' => $password
        ];
    }

    public function updateUser(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }

        $validator = ValidatorHelper::make($data, [
            'nome' => 'required|min:3',
            'email' => 'required|email',
            'perfil' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        if (User::where('email', $data['email'])->where('id', '!=', $id)->exists()) {
            throw new ValidationException(['O E-mail já está em uso por outro usuário.']);
        }

        return $user->update($data);
    }
}
