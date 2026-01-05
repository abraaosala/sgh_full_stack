<?php

namespace App\controllers;

use App\classes\Json;
use App\Dao\Entity\DiagnosticoEntity;
use App\Dao\Models\Diagnostico;
use App\Dao\Models\Doenca;
use App\Dao\Models\Paciente;
use App\Dao\Models\User as Usuario;
use App\Http\BaseController as Controller;
use App\Http\Cors;

class DiagnosticoController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos
      $this->view(globals([
         'title' => "Diagostico Medico"
      ]), 'medico.diagnosticos');
   }

   public function show($params)
   {


      // Exibir recurso específico
      // Listar recursos
      $this->view(globals([
         'title' => "Diagostico Medico"
      ]), 'medico.diagnostico-paciente');
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

   public function api()
   {

      // $cors = new Cors()->enable();

      new Cors;

      $dominiosPermitidos = [
         'http://localhost:5173'
      ];
      header(API);

      // Verifica a origem da requisição e a permite se estiver na lista
      cors($dominiosPermitidos);

      $doenças = new Doenca()->all();

      $doenças = Json::convertData($doenças); // converter o object em array associativo

      $data = [];
      foreach ($doenças as $key => $doença) {
         $data[$key]['id'] = $doença['id'];
         $data[$key]['nome'] = $doença['nome'];
         $data[$key]['descricao'] = $doença['descricao'];
         $data[$key]['icon'] =  $doença['icon'];
         $paciente = new Diagnostico()->select(' COUNT(*) total')
            ->where('doenca_id', '=', $doença['id'])
            ->first();
         $pacientes = ($paciente) ?
            Json::convertData($paciente) :
            ['total' => 0];
         $data[$key]['pacientesAtivos'] = $pacientes['total'];
      }

      Json::encode($data);
   }

   public function apipassdia($params)
   {
      /* 
      {
                 pacienteId: 'I9J1-3652',
                 pacienteNome: "Eduarda Lima",
                 dataDiagnostico: "2025-09-01",
                 statusDiagnostico: "Controlado"
             }
      */
      $model = Json::convertData(new Doenca()->findById($params['doenca']));
      $data = [];
      $paciente = new Diagnostico()
         ->select('usuarios.nome as nome, pacientes.code as code , diagnosticos.*')
         ->where('doenca_id', "=", $model['id'])
         ->join(Paciente::class, 'diagnosticos.paciente_id', '=', 'pacientes.id')
         ->join(Usuario::class, 'pacientes.usuario_id', '=', 'usuarios.id')
         ->get();
      $pacientes = Json::convertData($paciente);
      $data['doenca'] = $model['nome'];
      if ($paciente) {
         foreach ($pacientes as $key => $item) {
            $data['pacientes'][$key]['pacienteId'] = $item['code'];
            $data['pacientes'][$key]['pacienteNome'] = $item['nome'];
            $data['pacientes'][$key]['dataDiagnostico'] = $item['data_diagnostico'];
            $data['pacientes'][$key]['statusDiagnostico'] = "Controlado";
         }
      } else {
         $data['pacientes'] = [];
      }



      Json::encode($data);
   }
}