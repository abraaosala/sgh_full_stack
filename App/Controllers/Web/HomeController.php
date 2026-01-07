<?php

namespace App\Controllers\Web;

use App\Http\BaseController as Controller;
use App\trait\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class HomeController 
{
     use View;
    public function index()
    {
        // TODO: implement index method
        $this->render([
            'partials.header-html(medicio)',
            'partials.header(medicio)',
            'home',
            'partials.footer',
            'partials.footer-html(medicio)'
        ], globals([
            'title' => 'Home Page',
            'content' => 'Welcome to the Home Page!'
        ]));
    }
    
    public function profile()
    {
      // Listar recursos
      $logado = (int) htmlspecialchars(session()->get('id'));

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . $logado,
         'keywords' => 'perfil, usuario, ' . $logado,
         'description' => 'Perfil de Usuario ' . $logado,
      ]), 'pages.profile');
   }


   public function profileEdit()
    {

  
      $logado = (int) htmlspecialchars(session()->get('id'));

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . $logado,
         'keywords' => 'perfil, usuario, ' . $logado,
         'description' => 'Perfil de Usuario ' . $logado,
      ]), 'pages.edit_profile');
   }

   
   public function profileSave()
   {}

  
    
}