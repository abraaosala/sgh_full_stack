<?php

namespace App\controllers;

use App\classes\Session;
use App\Dao\Models\Consulta;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;


//Controlado do Usuario com Perfil Medico /medico
class UserMedicoController extends Controller
{
   // Métodos padrão de controllers RESTful
   public function index()
   {
      
      //Consultar O perfil
     
      // Painel Administrativo 
      $this->view(
         [
            'title' => 'Painel do Medico',
            'count' => 0,
            'count_consultas' => 0
         ], 'pages.dashboard');         
   }

   public function show($params)
   {

      // Exibir recurso específico

   }

   public function create()
   {
      // criar novo recurso
   }

   public function store()
   {

      // Salvar novo recurso

   }

   public function edit($params)
   {

      // Editar recurso existente

   }

   public function update($params)
   {

      // Atualizar recurso existente
   }

   public function delete($params)
   {

      // Deletar recurso
   }

   public function list (){


   }
}