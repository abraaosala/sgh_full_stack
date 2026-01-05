<?php

namespace App\Http;

use App\Contratos\RequestContrato;

class ApiRequest implements RequestContrato
{
    private array $data;

    public function __construct()
    {
        $input = file_get_contents('php://input');
        $this->data = json_decode($input, true) ?? [];
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->data;
    }
}
