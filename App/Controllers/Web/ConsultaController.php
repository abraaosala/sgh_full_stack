<?php

namespace App\controllers;

use App\classes\Json;
use App\Dao\Entity\ConsultaEntity;
use App\Dao\Models\Agenda;
use App\Dao\Models\Consulta;
use App\Dao\Models\Especialidade;
use App\Dao\Models\Medico;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Dao\Models\Usuario;
use App\Http\BaseController as Controller;
use App\Http\Response;
use DateTime;
use DateTimeImmutable;

class ConsultaController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos
      $this->view(globals([
         'title' => "Consultas agendados"
      ]), 'admin.consulta');
   }

   public function show($params) {}

   public function api($params)
   {

      // Exibir recurso da api


      //
      $model = new Consulta()
         ->select(
            'consultas.*, pacientes.id as pid, pu.nome as pnome, usuarios.nome medico_nome, agendas.start, especialidades.nome especialidade'
         )
         ->join(Paciente::class, 'consultas.paciente_id', '=', 'pacientes.id')
         ->join(Medico::class, 'consultas.medico_id', '=', 'medicos.id', null, 'Left')
         ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
         ->join(User::class, 'pacientes.usuario_id', '=', 'pu.id', 'pu')
         ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
         ->join(Agenda::class, 'consultas.agenda_id', '=', 'agendas.id')
         // ->join(P::class, 'medicos.usuario_id', '=', 'usuarios.id')
         // ->where('consultas.medico_id', '=', $id)
      ;
      if (session()->get('perfil') == 'medico') {
         # code...
         $idUser = session()->get('id');
         $med = userPerfil($idUser, 'medico');
         $id= $med->id;
         $model->where('consultas.medico_id', '=', $id);
      }

      // dd($model);
      if (isset($_GET['id'])) {
         $id = (int) $_GET['id'];
         $model->where('consultas.id', '=', $id);
         $consulta = $model->first();
         $data = [];
         if ($consulta) {

            # code...
            $date =  date_format(new DateTimeImmutable($consulta->start), 'Y-m-d');
            // $hour =  date_format(new DateTimeImmutable($consulta->marcacao), 'H:i');
            // $date =  date_format(new DateTime($consulta->data_consulta), 'Y-m-d');
            //
            $data['id'] = $consulta->id;
            $data['pid'] = $consulta->pid;
            $data['data'] = $date;
            $data['hora'] = $consulta->marcacao;
            $data['paciente'] = $consulta->pnome;
            $data['medico'] = $consulta->medico_nome;
            $data['status'] = agendaStatus($consulta->status) ?? '';

            $data['especialidade'] = $consulta->especialidade ?? '';
         }

         // dd($consulta);
         header(API);
         echo json_encode($data);
      } else {

         $consultas = $model->get();



         // dd($consultas);
         //montar os dados para json
         $data = [];
         foreach ($consultas as $key => $consulta) {
            # code...
            // $data = [];
            $date =  date_format(new DateTimeImmutable($consulta->marcacao), 'Y-m-d');
            $hour =  date_format(new DateTimeImmutable($consulta->marcacao), 'H:i');
            // $date =  date_format(new DateTime($consulta->data_consulta), 'Y-m-d');
            //
            $data[$key]['id'] = $consulta->id;
            $data[$key]['data'] = $date;
            $data[$key]['hora'] = $hour;
            $data[$key]['paciente'] = $consulta->pnome;
            $data[$key]['medico'] = $consulta->medico_nome;
            $data[$key]['status'] = agendaStatus($consulta->status);
            $data[$key]['especialidade'] = $consulta->especialidade ?? '';
         }


         header(API);


         echo json_encode($data);

         // dd($data);
      }
   }

   public function create()
   {
      // criar novo recurso
   }

   public function store()
   {

      $model = new Consulta(ConsultaEntity::class);
      $entity= $model->setEntity();
      // Salvar novo recurso
      $data = sanitizeInput(json_decode(file_get_contents("php://input"), true));;

      // $model->setEntity()->paciente_id = $data['paciente_id'];
      // $model->setEntity()->medico_id = $data['medico_id'];
      // $model->setEntity()->agenda_id = $data['agenda_id'];
      // $model->setEntity()->marcacao = $data['marcacao'];

      $entity->fill($data);

      if ($model->store()) {
         echo json_encode([
            'status' => true
         ]);
      } else {
         # code...
         echo json_encode([
            'status' => false
         ]);
      }

      // echo json_encode($data);
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

   public function truncate()
   {
      $consulta = new Consulta();
      $truncate = $consulta->truncate();

      if ($truncate) {
         Response::successResponse('Apagado e Zerado com Sucesso', ['status' => true]);
      }

      Response::errorResponse('Falha ao apagar', 500);
   }

   public function apiAll()
   {



      $pacientes = (new Paciente())
         ->select('pacientes.id, u.nome as nome')
         ->join(User::class, 'pacientes.usuario_id', '=', 'u.id', 'u')
         ->orderBy('nome')
         ->get();

      $medicos = (new Medico())
         ->select('medicos.id, u.nome as nome')
         ->join(User::class, 'medicos.usuario_id', '=', 'u.id', 'u')
         ->get();

      $medicosConvertidos = Json::convertData($medicos);

      foreach ($medicosConvertidos as &$medico) {
         $idsAgendas = [];
         $titulosAgendas = [];

         $agendas = (new Agenda())
            ->select('id, title, start, end')
            ->where('medico_id', '=', $medico['id'])
            ->get();

         if (!empty($agendas)) {
            $dias = [];
            $inicio = null;
            $fim = null;
            $intervalo = null;


            // dd($agendas);
            foreach ($agendas as $agenda) {
               $idsAgendas[] = $agenda->id;
               $titulosAgendas[] = $agenda->title;

               // var_dump($$agenda->title);

               // --- INÍCIO DA CORREÇÃO ---
               // Só processa datas e horas se a agenda tiver um 'start' válido.

               // if (!empty($agenda->start)) {
               // Extrair apenas a data (Y-m-d)
               $dataDia = date('Y-m-d', strtotime((string) $agenda->start));
               $dias[] = $dataDia;
               // Se ainda não pegamos início e fim, pegar do primeiro válido
               if (!$inicio) {
                  $inicio = date('H:i', strtotime((string) $agenda->start));
               }

               // }

               // Verifica o 'end' separadamente para também evitar o erro com ele.
               // if (!$fim && !empty($agenda->end)) {
               $fim = date('H:i', strtotime((string) $agenda->end));
               // }


               // --- FIM DA CORREÇÃO ---

               if (!$intervalo && !empty($agenda->intervalo)) {
                  $intervalo = (int) $agenda->intervalo;
               }
            }

            $medico['agenda'] = [
               'ids' => array_values(array_unique($idsAgendas)),
               'titulos' => array_values(array_unique($titulosAgendas)),
               'dias' => array_values(array_unique($dias)),
               'inicio' => $inicio ?? '',
               'fim' => $fim ?? '',
               'intervalo' => $intervalo ?? 30
            ];
         } else {
            $medico['agenda'] = [];
         }
      }

      $data = [
         'pacientes' => Json::convertData($pacientes),
         'medicos' => $medicosConvertidos
      ];

      header('Content-Type: application/json');
      echo json_encode($data);
   }
}