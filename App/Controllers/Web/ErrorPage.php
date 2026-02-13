<?php

namespace App\Controllers\Web;

use App\trait\View;
use Exception;
use Throwable;

class ErrorPage extends Exception
{
    use View;

    public function in($code, null|array|Throwable $e = [])
    {
        if (is_array($code)) {
            $code = (int) ($code['error'] ?? 500);
        }

        $code = (int) $code;
        http_response_code($code);

        $message = ($e instanceof Throwable) ? $e->getMessage() : '';

        $data = [
            'title' => sprintf('Erro %s', $code),
            'message' => $message,
            'code' => $code,
            'exception' => $e
        ];

        // Mapeamento de views por código
        $view = match ($code) {
            403 => 'pages.e403',
            404 => 'pages.e404',
            405 => 'pages.e405', // Se não existir, o trait View lidará com o erro
            500 => 'pages.e500',
            default => 'pages.e500' // Fallback para erros desconhecidos
        };

        $this->render([
            'partials.header-html',
            $view,
            'partials.footer-html',
        ], data($data));
    }
}