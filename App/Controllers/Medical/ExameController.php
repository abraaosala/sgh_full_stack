<?php

namespace App\controllers;

use App\Http\BaseController as Controller;



class ExameController extends Controller
{


   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos
      $this->view(globals([
         'title' => 'Resultados dos Exames'
      ]), 'medico.exames');
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
}
