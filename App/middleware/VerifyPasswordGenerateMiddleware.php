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
    if (verifyPasswordGenerate($id, $perfil)) {
      redirect(
        "config/renovar_senha_gerado",
        ['informar', 'Esta senha foi gerada actualize aqui', 'info']
      );
      exit;
    }

    return true;
  }
}
