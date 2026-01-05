<?php

namespace App\Contratos;

interface RequestContrato
{
    public function get(string $key, $default = null);

    public function all(): array;
}
