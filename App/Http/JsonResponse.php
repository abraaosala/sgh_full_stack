<?php

namespace App\Http;

class JsonResponse extends Response
{
    public function send(array $data, int $statusCode = 200): never
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
