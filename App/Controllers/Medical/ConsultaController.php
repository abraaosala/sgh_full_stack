<?php

namespace App\Controllers\Medical;

use App\Dao\Models\Agenda;
use App\Dao\Models\Consulta;
use App\Dao\Models\Medico;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;

class ConsultaController extends Controller
{


   // Métodos padrão de controllers RESTful
   public function index()
   {
      $idUser = session()->get('id');
      $medico = userPerfil($idUser, 'medico');

      if (!$medico) {
         redirect('/logout'); // Ou tratar erro adequadamente
      }

      $consultas = \App\Models\Consulta::with(['paciente.usuario', 'agenda'])
         ->doMedico($medico->id)
         ->orderBy('id', 'desc')
         ->get();

      \App\library\View::render('medico.consultas.index', globals([
         'title' => "Minhas Consultas",
         'consultas' => $consultas
      ]));
   }

   public function api($params)
   {

      // Exibir recurso específico
      // $idUser = session()->get('id');
      // $id = userPerfil($idUser, 'medico')->id;

      //
      $model = (new Consulta())
         ->select(
            'consultas.*, pacientes.id as pid, pu.nome as pnome, usuarios.nome medico_nome, agendas.start'
         )
         ->join(Paciente::class, 'consultas.paciente_id', '=', 'pacientes.id')
         ->join(Medico::class, 'consultas.medico_id', '=', 'medicos.id', null, 'Left')
         ->join(User::class, 'pacientes.usuario_id', '=', 'pu.id', 'pu')
         ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
         ->join(Agenda::class, 'consultas.agenda_id', '=', 'agendas.id')
         // ->join(P::class, 'medicos.usuario_id', '=', 'usuarios.id')
         // ->where('consultas.medico_id', '=', $id)
      ;



      // ->toSql();


      if (isset($_GET['id'])) {
         $id = (int) $_GET['id'];
         $model->where('consultas.id', '=', $id);
         $consulta = $model->first();
         $data = [];
         if ($consulta) {

            # code...
            $date =  date_format(new \DateTimeImmutable($consulta->start), 'Y-m-d');
            // $hour =  date_format(new DateTimeImmutable($consulta->marcacao), 'H:i');
            // $date =  date_format(new DateTime($consulta->data_consulta), 'Y-m-d');
            //
            $data['id'] = $consulta->id;
            $data['pid'] = $consulta->pid;
            $data['data'] = $date;
            $data['hora'] = $consulta->marcacao;
            $data['paciente'] = $consulta->pnome;
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
            $date =  date_format(new \DateTimeImmutable($consulta->marcacao), 'Y-m-d');
            $hour =  date_format(new \DateTimeImmutable($consulta->marcacao), 'H:i');
            // $date =  date_format(new DateTime($consulta->data_consulta), 'Y-m-d');
            //
            $data[$key]['id'] = $consulta->id;
            $data[$key]['data'] = $date;
            $data[$key]['hora'] = $hour;
            $data[$key]['paciente'] = $consulta->pnome;
            $data[$key]['status'] = agendaStatus($consulta->status);
            $data[$key]['especialidade'] = $consulta->especialidade ?? '';
         }


         header(API);


         echo json_encode($data);

         // dd($data);
      }
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
