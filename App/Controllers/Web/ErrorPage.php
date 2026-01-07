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
            # code...
            $code = (int) $code['error'];
        }

        http_response_code($code);

        $message = '';
        if (!empty($e)) {
            # code...
            $message = $e->getMessage();
        }

        $data = [
            'title' => sprintf('Erro de Pagina (%s)', $code),
            'message' => $message,
           'exception'=> $e
        ];
        if ($code === 404) {
            $this->render([
                'partials.header-html',
                'pages.e404',
                'partials.footer-html',
            ], data($data));
        }

        if ($code === 500) {
            $this->render([
                'partials.header-html',
                'pages.e500',
                'partials.footer-html',
            ], data($data));
        }

        if ($code === 403) {
            $this->render([
                'partials.header-html',
                'pages.e403',
                'partials.footer-html',
            ], data($data));
        }
    }
}