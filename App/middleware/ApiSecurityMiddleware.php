<?php
namespace App\Middleware;

use core\Middleware;

class ApiSecurityMiddleware extends Middleware
{
  public function handle(): bool
    {
        // Lógica para verificar se o usuário está autenticado.
        // Por exemplo, se não estiver autenticado, redirecionar ou lançar um erro.
        /**
         * Exexplo
         * if (loggedd()->check()) {
         * redirect();
        *  }
         * **/
        return true;
    }    
}
