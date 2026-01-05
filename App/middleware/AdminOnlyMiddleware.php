<?php
namespace App\Middleware;

use core\Middleware;

class AdminOnlyMiddleware extends Middleware
{
  public function handle(): bool
    {
   if (!in_array(session()->get('perfil'),['admin', 'superadmin'])) {
    # code...sup
    redirect();
   }
   
      return true;
    }    
}
