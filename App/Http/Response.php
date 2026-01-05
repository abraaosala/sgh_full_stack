<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    public static function json(mixed $data, int $code = 200, ?array $headers = [])
    {
        header('Content-Type: application/json');
        foreach ($headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        http_response_code($code);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public function noContent(): never
    {
        http_response_code(204);
        header('Content-Length: 0');
        exit;
    }

    /**
     * Resposta de sucesso padronizada.
     */
    public static function successResponse(string $message, $data = [], int $code = 200)
    {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data // Opcional, para retornar o item criado/atualizado
        ], $code);
    }

    /**
     * Resposta de erro padronizada.
     */
    public static function errorResponse(string $message, int $code = 400, $errors = [])
    {
        $payload = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }

        self::json($payload, $code);
    }

      /**
     * Resposta "Não Encontrado" (404) padronizada.
     */
    public static function notFoundResponse(string $resource = 'Recurso')
    {
        static::errorResponse($resource . ' não encontrado.', 404);
    }
}