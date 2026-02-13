<?php

namespace App\Middleware;

use App\classes\Session;
use core\Middleware;

class VerifyPasswordGenerateMiddleware extends Middleware
{
  public function handle(): bool
  {
    /*  $id= Session::get('id');
      $perfil= Session::get('perfil'); */
    $id = session()->get('id');
    $perfil = session()->get('perfil');

    // Se estiver na rota de renovação, não redirecionar (evitar loop)
    if (strpos($_SERVER['REQUEST_URI'], '/renovar_senha_gerado') !== false || strpos($_SERVER['REQUEST_URI'], '/salvar-senha') !== false) {
      return true;
    }

    if (verifyPasswordGenerate($id, $perfil)) {
      redirect(
        "/renovar_senha_gerado",
        ['informar', 'Esta senha foi gerada pelo sistema. Por favor, atualize sua senha para continuar.', 'info']
      );
      exit;
    }

    return true;
  }
}
