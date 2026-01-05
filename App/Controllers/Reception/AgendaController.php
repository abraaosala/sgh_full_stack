<?php

namespace App\controllers\Reception;

use App\Dao\Models\Medico;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;
use core\ApiController;

class AgendaController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos
      $medicos = (new Medico())->select('medicos.*, usuarios.nome as nome')->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')->get(); // Supondo que você tenha um modelo Medico
      // $pacientes =(new Paciente())->select('pacientes.*, usuarios.nome')->join(User::class, 'usuario_id', '=', 'id')->get(); // Supondo que você tenha um modelo Paciente

      // dd($medicos, $pacientes);
      // dd($medicos);
      $this->view(globals([
         'medicos' => $medicos,
         'title' => "Escala de Medicos"
      ]), 'admin.agenda-med');
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