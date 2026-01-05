<?php

namespace App\controllers;

use App\Http\BaseController as Controller;
use App\trait\TemplateView;

class PacienteUserController
{
   use TemplateView;

   /**
    * Métodos específicos para o controladores pacienteuser podem ser adicionados aqui.
    *
    * Exemplo:
    *
    * public function acao($params)
    * {
    *      $this->render([componentes], data([variaveis disponiveis na view]));
    *  
    *  
    *  
    * }
    */

   // Métodos padrão de controllers RESTful
   public function index()
   {
    $this->view(globals(), 'pages.dashboard');
   }

   //Resultado do Exames
   public function exames(){
        $this->view(globals(), 'pacientes.exames');

   }

   public function prescricoes(){
        $this->view(globals(), 'pacientes.prescricoes');

   }
   
}