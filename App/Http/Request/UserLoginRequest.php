<?php

namespace App\Http\Request;

use App\classes\Request;

class UserLoginRequest extends Request
{
    public string $redirect = 'login';

    public function rules(): array
    {
        return [
            'user' => 'required',
            'password' => 'required'
        ];
    }
}
