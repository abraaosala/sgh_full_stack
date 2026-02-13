<?php

namespace App\Controllers\Reception;

use App\Models\Medico;
use App\Http\BaseController as Controller;

class AgendaController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {
      // Listar recursos
      $medicos = Medico::with('usuario')->get();

      $this->view(globals([
         'medicos' => $medicos,
         'title' => "Escala de Médicos"
      ]), 'admin.agenda');
   }

   public function show($params) {}


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
