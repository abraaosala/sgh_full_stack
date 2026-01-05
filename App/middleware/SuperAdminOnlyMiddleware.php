<?php

namespace App\Middleware;

use App\classes\Session;
use App\Controllers\Web\ErrorPage;
use core\Middleware;

class SuperAdminOnlyMiddleware extends Middleware
{
  public function handle(): bool
  {
    if (Session::get('perfil') != 'superadmim') {
      new ErrorPage()->in(403);
      exit;
    }
    
    return true;
  }
}
