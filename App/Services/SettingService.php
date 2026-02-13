<?php

namespace App\Services;

use App\Models\User;
use App\classes\Password;
use App\helpers\ValidatorHelper;
use App\Exceptions\ValidationException;

class SettingService extends AbstractService
{
    public function renewPassword(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception('Usuário não encontrado.');
        }

        $validator = ValidatorHelper::make($data, [
            'senha' => 'required',
            'confirm_password' => 'required|same:senha'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        $user->senha = Password::hash((string) $data['senha']);
        $user->senha_gerada = 0;

        return $user->save();
    }

    public function findUserForRecovery(string $email): User
    {
        if (empty($email)) {
            throw new ValidationException(['O E-mail é obrigatório.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new ValidationException(['Usuário não foi encontrado.']);
        }

        return $user;
    }

    public function recoverPassword(int $id, array $data): bool
    {
        $user = User::find($id);
        if (!$user) {
            throw new \Exception('Usuário inválido.');
        }

        $validator = ValidatorHelper::make($data, [
            'senha' => 'required',
            'confirm_password' => 'required|same:senha'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->all());
        }

        $user->senha = Password::hash((string) $data['senha']);
        return $user->save();
    }
}
