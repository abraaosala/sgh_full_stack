<?php

namespace App\Contratos;

interface ResponseContrato
{
    public function send(array $data, int $statusCode = 302);
}
