<?php

namespace App\Http\Request;

use App\classes\Request;

class PassRequest extends Request
{
    public string $redirect = "alterar_senha?token={ord('token')}";

    public function rules(): array
    {
        return [
            'password' => 'required'
        ];
    }
}
