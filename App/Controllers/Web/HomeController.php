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
      // Renderiza usando BladeOne (View Wrapper)
      \App\library\View::render('home', globals([
         'title' => 'Home Page',
         'content' => 'Welcome to the Home Page!'
      ]));
   }

   public function profile()
   {
      // Listar recursos
      $logado = (int) htmlspecialchars((string) session()->get('id'));

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . $logado,
         'keywords' => 'perfil, usuario, ' . $logado,
         'description' => 'Perfil de Usuario ' . $logado,
      ]), 'pages.profile');
   }


   public function profileEdit()
   {


      $logado = (int) htmlspecialchars((string) session()->get('id'));

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . $logado,
         'keywords' => 'perfil, usuario, ' . $logado,
         'description' => 'Perfil de Usuario ' . $logado,
      ]), 'pages.edit_profile');
   }


   public function profileSave() {}
}
