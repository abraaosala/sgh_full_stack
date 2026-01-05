<?php
namespace App\Middleware;

use core\Middleware;

class PacienteMiddleware extends Middleware
{
  public function handle(): bool
    {
        // Lógica para verificar se o usuário está autenticado.
        // Por exemplo, se não estiver autenticado, redirecionar ou lançar um erro.
        if (session()->get('perfil') != 'paciente' ) {
          redirect();
        }
        
        return true;
    }    
}