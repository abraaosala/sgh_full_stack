<?php

namespace App\Http\Request;

use App\classes\Request;

class UserRequest extends Request
{
    public string $redirect = 'user-create';

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'bi' => 'required|bI',
            'dataNascimento' => 'required|date'

        ];
    }
}
