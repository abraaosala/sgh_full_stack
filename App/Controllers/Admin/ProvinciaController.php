<?php

namespace App\Controllers\Admin;

use App\classes\Json;
use core\ApiController;

class ProvinciaController extends ApiController 
{
   public function index()
   {
      $provincias = \App\Models\Provincia::orderBy('nome')->get();
      
      Json::encode([
         'title'  => 'API de Províncias', 
         'data'   => $provincias,
         'status' => true
      ]);
   }
}