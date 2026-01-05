<?php

namespace App\Http;

use App\Contratos\RequestContrato;

class PostRequest implements RequestContrato
{
    private array $data;

    public function __construct()
    {
        $this->data = $_POST;
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
