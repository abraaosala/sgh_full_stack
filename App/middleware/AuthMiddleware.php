<?php
namespace App\Middleware;

use App\Dao\Models\Acesso;
use core\Middleware;

class AuthMiddleware extends Middleware
{
  public function handle(): bool
    {
        // Lógica para verificar se o usuário está autenticado.
        // Por exemplo, se não estiver autenticado, redirecionar ou lançar um erro.
        if (!logged()) {
          redirect();
        }
        
        return true; // Permite que a requisição continue se o usuário não estiver autenticado
    }    
}
