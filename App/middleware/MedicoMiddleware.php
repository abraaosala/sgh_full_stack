<?php

namespace App\Middleware;

use App\classes\Session;
use App\Controllers\Web\ErrorPage;
use core\Middleware;

class MedicoMiddleware extends Middleware
{
  public function handle(): bool
  {
    // Lógica para verificar se o usuário está autenticado.
    // Por exemplo, se não estiver autenticado, redirecionar ou lançar um erro.
    $id = session()->get('perfil');

    if (!in_array($id, ['medico', 'superadmin'])) {
      // redirect();
      new ErrorPage()->in(403);
      exit;
    }
    
    return true; // Permite que a requisição continue se o usuário for um administrador
  }
}
