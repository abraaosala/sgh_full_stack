<?php


namespace App\Http\Request;

use App\classes\Request;

class UserPassRequest extends Request
{

    public string $redirect = 'user-recuparar-senha';

    public function rules(): array
    {
        return [
            'user' => 'required'
        ];
    }
}
