<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;

use App\trait\View;




class AdminController
{

  use View;

  // Métodos padrão de controllers RESTful
  public function index()
  {
    $this->view(globals(), 'pages.dashboard');
  }

   
}