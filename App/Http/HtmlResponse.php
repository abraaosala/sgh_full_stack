<?php

use App\Contratos\ResponseContrato;

class HtmlResponse implements ResponseContrato
{
    /*  */
    public function send(array $data, int $statusCode = 302)
    {
        [$redirect, $flass]= $data;
        if (isset($flass)) {
            # code...
            $flass=[];
        }

        // Em um caso real, você poderia redirecionar com uma mensagem de sucesso
        /* header('Location: /success.html');
        exit; */
        redirect($redirect, $flass);
    }
}