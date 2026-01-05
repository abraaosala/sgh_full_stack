<?php

namespace App\controllers;

use App\classes\Password;
use App\classes\Session;
use App\Dao\Entity\PacienteEntity;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\Consulta;
use App\Dao\Models\Especialidade;
use App\Dao\Models\Medico;
use App\Dao\Models\MedicoPaciente;
use App\Dao\Models\Paciente;
use App\Dao\Models\Provincia;
use App\Dao\Models\User;
use App\Dao\Models\Usuario;
use App\Http\BaseController as Controller;
use App\Http\Response;
use DateTime;
use DateTimeImmutable;
use Dompdf\Dompdf;
use Dompdf\Options;

class MedPasController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {
      // Base 

      /*       $id = (int) session()->get('id');
      $perfil = userPerfil($id, 'medico');

      if (!$perfil) {
         throw new \Exception("Usuario não fez login");
      }

      //Id do Medico
      $medId = (int) $perfil->id;

      if(!$medId){
         throw new \Exception("Medico não existe");
      }

       $model = new MedicoPaciente()
               ->select("pacientes.*, usuarios.nome as usuario, usuarios.email as email, usuarios.genero as genero")
               ->join(Paciente::class, 'medico_paciente.id', '=', 'pacientes.id')
               ->join(User::class, 'pacientes.usuario_id', '=', 'usuarios.id')
               ->where('medico_id', '=', $medId)
               ->paginate();

                $results = $model->Items ?? [];
                unset($model->Items);

         $provincias = new Provincia()->all();
 */
      $this->view(globals([
         'title' => 'Meus Pacientes',
         /*  'pacientes' => $results ?? [],
         'tools' => $model ?? [],
         'provincias' => $provincias */
      ]),  'medico.pacientes');
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
      header('Content-Type: application/json');


      // $response = [];

      // Instanciar modelos
      $usermodel = new User(UserEntity::class);
      $pacientemodel = new Paciente(PacienteEntity::class);

      $data = json_decode(file_get_contents("php://input"), true);
      $data = sanitizeInput($data);


      // Validação
      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
         echo json_encode(['status' => false, 'msg' => 'E-mail inválido']);
         exit;
      }

      if ($usermodel->findByEmail($data['email'])) {
         echo json_encode(['status' => false, 'msg' => 'E-mail já está em uso']);
         exit;
      }

      if (empty($data['nome'])) {
         echo json_encode(['status' => false, 'msg' => 'Nome é obrigatório']);
         exit;
      }

      // Configurar entidade do usuário
      $user = $usermodel->setEntity();
      $user->nome = $data['nome'];
      $user->genero = $data['genero'];

      $user->email = $data['email'];
      $user->perfil = $data['perfil'] ?? 'paciente';
      $user->senha_gerada = 1;

      $senha = Password::generate(2);
      $user->senha = Password::hash($senha);

      // Apenas em ambiente de testes — nunca em produção
      if (!manager()->exists('email', $data['email'])) {
         manager()->add([
            'email' => $user->email,
            'senha' => $senha
         ]);
      }

      // $pacientemodel->setEntity()->genero= $data['sexo'];
      // Limpar dados já usados
      unset($data['nome'], $data['email'], $data['perfil'], $data['genero']);/*   */

      entity_data_itera($data, $pacientemodel);



      // Iniciar transação (se disponível)
      $usermodel->beginTransaction();

      $userStore = $usermodel->store();

      if ($userStore) {
         $pacienteEntity = $pacientemodel->setEntity();
         $pacienteEntity->usuario_id = (int) $userStore;

         $pacienteStore = $pacientemodel->store();

         if ($pacienteStore) {
            $usermodel->commit();
            echo json_encode(['status' => true, 'msg' => 'Paciente registrado com sucesso']);
            exit;
         } else {
            $usermodel->rollback();
         }
      }

      echo json_encode(['status' => false, 'msg' => 'Paciente não foi cadastrado']);
      exit;
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

   // public function list()
   // {
   //    $id = session()->get('id');
   //    $permed = userPerfil($id, 'medico');
   //    Response::json($id);
   //    $model = new Paciente();
   //    if ($permed) {
   //       # code...
   //    $idm = $permed->id;

   //       $pacientes = $model->select(
   //          'pacientes.id, pacientes.code as id,  u.nome as nome, u.email  email,MAX(c.marcacao) as ultima_consulta'
   //       )
   //          ->join(Consulta::class, 'c.paciente_id', '=', 'pacientes.id', 'c')
   //          ->join(User::class, 'pacientes.usuario_id', '=', 'u.id', 'u')
   //          // ->join(Diagnostico::class, 'd.paciente_id', '=', 'pacientes.id','d')
   //          ->where('c.medico_id', '=', $idm)

   //          ->groupBy('pacientes.id, u.nome')

   //          ->get();

   //       $data = [];
   //       $statusOptions = ['Alta', 'Acompanhamento', 'Estavel'];
   //       $diagnosticoOptions = ['st', 'gn', 'ag'];

   //       foreach ($pacientes as $key => $paciente) {
   //          $date =  date_format(new DateTimeImmutable($paciente->ultima_consulta), 'Y-m-d');
   //          $data[$key]['id'] = $paciente->id;
   //          $data[$key]['nome'] = $paciente->nome;
   //          $data[$key]['ultimaConsulta'] = $date;

   //          $data[$key]['email'] = $paciente->email;
   //          // 👇 Alterna os status com base na ordem
   //          $data[$key]['status'] = $statusOptions[$key % count($statusOptions)];
   //          $data[$key]['diagnostico'] = $diagnosticoOptions[$key % count($diagnosticoOptions)];
   //          // $data[$key]['status'] = $status;
   //          // $data[$key]['diagnostico'] = 'Apnea';
   //       }
   //    }
   //    header(API);

   //    // dd($data);
   //    echo json_encode($data);
   // }

   public function api()
   {
      $id = (int) $_GET['id'];
      $permed = userPerfil($id, 'medico');
      // $idm = $permed->id;
      if ($permed) {
         $model = new Paciente();
         # code...
         $idm = $permed->id;

         $pacientes = $model->select(
            'pacientes.id, pacientes.code as id,  u.nome as nome, u.email  email,MAX(c.marcacao) as ultima_consulta'
         )
            ->join(Consulta::class, 'c.paciente_id', '=', 'pacientes.id', 'c')
            ->join(User::class, 'pacientes.usuario_id', '=', 'u.id', 'u')
            // ->join(Diagnostico::class, 'd.paciente_id', '=', 'pacientes.id','d')
            ->where('c.medico_id', '=', $idm)

            ->groupBy('pacientes.id, u.nome')

            ->get();



         $data = [];
         $statusOptions = ['Alta', 'Acompanhamento', 'Estavel'];
         $diagnosticoOptions = ['st', 'gn', 'ag'];

         foreach ($pacientes as $key => $paciente) {
            $date =  date_format(new DateTimeImmutable($paciente->ultima_consulta), 'Y-m-d');
            $data[$key]['id'] = $paciente->id;
            $data[$key]['nome'] = $paciente->nome;
            $data[$key]['ultimaConsulta'] = $date;

            $data[$key]['email'] = $paciente->email;
            // 👇 Alterna os status com base na ordem
            $data[$key]['status'] = $statusOptions[$key % count($statusOptions)];
            $data[$key]['diagnostico'] = $diagnosticoOptions[$key % count($diagnosticoOptions)];
            // $data[$key]['status'] = $status;
            // $data[$key]['diagnostico'] = 'Apnea';
         }
      }

      header(API);

      // dd($data);
      echo json_encode($data);
   }

   public function print()
   {

      header('Content-Type: application/json'); // define resposta JSON

      $pdfStoragePath = ROOT . '/public/pdfs/';
      if (!is_dir($pdfStoragePath)) {
         mkdir($pdfStoragePath, 0777, true);
      }

      // Autenticação
      if (!session()->has()) {
         http_response_code(401);
         echo json_encode(['success' => false, 'error' => 'Paciente não autenticado.']);
         exit();
      }

      $id = session()->get('id');

      $med = userPerfilMed(
         $id,
         'medico',
         "medicos.*, usuarios.nome medico_nome, usuarios.email email,
    provincias.nome provincia,  especialidades.nome especialidade_medica"
      );
      $medId = $med->id;

      $model = new Consulta()
         ->select(
            "consultas.*, pu.nome 
            paciente_nome,pu.genero 
            paciente_genero, 
            pu.data_nascimento paciente_nascimento"
         )
         // ->select(
         // //   ['consultas.id ', 'usuarios.nome medico_nome'] 
         // )
         ->where('consultas.medico_id', '=', $medId)

         ->join(Medico::class, 'consultas.medico_id', '=', 'medicos.id')
         ->join(Paciente::class, 'consultas.paciente_id', '=', 'pacientes.id')
         ->join(User::class, 'pacientes.usuario_id', '=', 'pu.id', 'pu')

         ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
         ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
         ->toArray();

      // Response::json($model);

      if (!$model) {
         Response::notFoundResponse('Consulta');
         // echo json_encode(['success' => false, 'error' => 'Consulta não encontrada.']);
         // exit();
      }

      $consults = convertData($model);

      $consults = array_map(function ($array) {
         $array['hora'] = (new DateTime($array['marcacao']))->format('H:i:s');
         $array['data'] = (new DateTime($array['marcacao']))->format('d/m/Y');
         $array['estado_formatado'] = agendaStatus($array['status']);

         return $array;
      }, $consults);

      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true);

      // $html = '...';
      $html = $this->content([
         'partials.document.header-html',
         'partials.document.header',
         'document.med-consulta',
         'partials.document.header-html',
      ], globals(
         [
            'title' => "Lista de Consultas Agendadas",
            'date' => date('d-m-Y'),
            'hour' => date('H:i:s'),
            'doctor' => $med,
            'lists' => $consults
         ]
      ));

      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      $fileName = sprintf('ficha_consulta_medico_%s_', $medId) . date('YmdHis') . ".pdf";
      $relativePath = '/pdfs/' . $fileName;
      $absolutePath = ROOT . '/public' . $relativePath;

      file_put_contents($absolutePath, $dompdf->output());
      //Saida
      Response::successResponse(
         "Ficha gerada com sucesso!",
         [
            'success' => true,
            // 'message' => 'Ficha gerada com sucesso!',
            'medico_id' => $id,
            'fileUrl' => $relativePath
         ]
      );
      // http_response_code(200);
      // echo json_encode([
      //    'success' => true,
      //    'message' => 'Ficha gerada com sucesso!',
      //    'medico_id' => $id,
      //    'fileUrl' => $relativePath
      // ]);
      // exit();
   }
}