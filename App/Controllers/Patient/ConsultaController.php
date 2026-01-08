<?php

namespace App\Controllers\Patient;

use App\classes\Export;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\classes\Json;
use App\Dao\Entity\ConsultaEntity;
use App\Dao\Models\Agenda;
use App\Dao\Models\Consulta;
use App\Dao\Models\Especialidade;
use App\Dao\Models\Medico;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Dao\Models\Usuario;
use App\export\Pdf;
use App\Http\BaseController as Controller;
use DateTime;

class ConsultaController extends Controller
{



   // Métodos padrão de controllers RESTful
   public function index()
   {
      $idUser = session()->get('id');
      $paciente = userPerfil($idUser, 'paciente');

      if (!$paciente) {
         redirect('/logout');
      }

      $consultas = \App\Models\Consulta::with(['medico.usuario', 'medico.especialidade'])
         ->doPaciente($paciente->id)
         ->orderBy('id', 'desc')
         ->get();

      \App\library\View::render('paciente.consultas.index', globals([
         'title' => 'Minhas Consultas',
         'consultas' => $consultas
      ]));
   }

   public function show($params)
   {
      $idUser = session()->get('id');
      $paciente = userPerfil($idUser, 'paciente');

      if (!$paciente) {
         redirect('/logout');
      }

      $id = $params['consulta'] ?? null; // Adjusting based on how Router passes params

      $consulta = \App\Models\Consulta::with(['medico.usuario', 'medico.especialidade', 'paciente.usuario'])
         ->where('id', $id)
         ->where('paciente_id', $paciente->id)
         ->first();

      if (!$consulta) {
         redirect('/paciente/consultas');
      }

      \App\library\View::render('paciente.consultas.show', globals([
         'title' => 'Detalhes da Consulta',
         'consulta' => $consulta
      ]));
   }

   public function create()
   {
      $especialidades = \App\Models\Especialidade::all();

      \App\library\View::render('paciente.consultas.create', globals([
         'title' => 'Nova Consulta',
         'especialidades' => $especialidades
      ]));
   }

   public function store()
   {

      $model = new Consulta(ConsultaEntity::class);
      $idUser = session()->get('id');
      $paciente = userPerfil($idUser, 'paciente');

      $idUser = session()->get('id');
      $paciente = userPerfil($idUser, 'paciente');

      if (!$paciente) {
         echo json_encode(['status' => false, 'message' => 'Paciente não autenticado.']);
         return;
      }

      $data = json_decode(file_get_contents('php://input'), true);
      // Validação básica
      if (empty($data['medico_id']) || empty($data['marcacao'])) {
         echo json_encode(['status' => false, 'message' => 'Preencha todos os campos obrigatórios.']);
         return;
      }

      // TODO: Verificar disponibilidade na Agenda do médico (opcional por enquanto)
      // Como o sistema antigo usava 'agenda_id', teríamos que logicamente encontrar ou criar um slot.
      // Simplificando para criar um registro de consulta direto.

      try {
         $consulta = \App\Models\Consulta::create([
            'paciente_id' => $paciente->id,
            'medico_id' => $data['medico_id'],
            // 'agenda_id' => 1, // Placeholder: Deveria ser vinculado a um slot real de agenda
            'marcacao' => $data['marcacao'],
            'observacao' => $data['observacao'] ?? null,
            // 'status' => 'Agendada' // Status inicial
         ]);

         if ($consulta) {
            echo json_encode(['status' => true, 'message' => 'Agendamento solicitado com sucesso!']);
         } else {
            echo json_encode(['status' => false, 'message' => 'Erro ao salvar no banco.']);
         }
      } catch (\Exception $e) {
         echo json_encode(['status' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
      }
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

   public function apiAll()
   {
      $medicos = (new Medico())
         ->select('medicos.*, u.nome as nome')
         ->join(User::class, 'medicos.usuario_id', '=', 'u.id', 'u')
         ->get();

      $especial = (new Especialidade())->all();
      $medicosConvertidos = Json::convertData($medicos);
      Json::convertData($especial);

      foreach ($medicosConvertidos as &$medico) {
         $medico['agenda'] = [];  // Inicializa a agenda como um array vazio, caso não tenha agendas

         $agendas = (new Agenda())
            ->select('id, title, start, end')
            ->where('medico_id', '=', $medico['id'])
            ->get();

         if (!empty($agendas)) {
            foreach ($agendas as $agenda) {
               $agendaData = [
                  'id' => $agenda->id,
                  'titulo' => $agenda->title ?? '',
                  'dia' => date('Y-m-d', strtotime((string) $agenda->start)),
                  'inicio' => date('H:i', strtotime((string) $agenda->start)),
                  'fim' => date('H:i', strtotime((string) $agenda->end)),
                  'intervalo' => $agenda->intervalo ?? 30
               ];

               $medico['agenda'][] = $agendaData;
            }
         }
      }

      $data = [
         // 'especialidade' => $especialConvertidos,
         'medicos' => $medicosConvertidos
      ];

      header('Content-Type: application/json');
      echo json_encode($data);
   }

   public function list()
   {
      $idUser = session()->get('id');
      $paciente = userPerfil($idUser, 'paciente');
      $id = $paciente->id;

      header(API);
      $model = (new Consulta())
         ->select("consultas.*, medicos.id mid,  usuarios.nome medico, especialidades.nome especialidade")
         ->where('paciente_id', '=', $id)
         ->join(Medico::class, 'consultas.medico_id', '=', 'medicos.id')
         ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
         ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
         ->get();

      $consulta = Json::convertData($model);
      $consultas = [];
      foreach ($consulta as $key => $value) {
         $consultas[$key]['idk'] = $key + 1;
         $consultas[$key]['id'] = $value['id'];
         $consultas[$key]['mid'] = $value['mid'];
         $consultas[$key]['medico'] = $value['medico'];
         $consultas[$key]['data'] = date_format(new DateTime($value['marcacao']), 'Y-m-d');
         $consultas[$key]['hora'] = date_format(new DateTime($value['marcacao']), 'H:i');
         $consultas[$key]['especialidade'] = $value['especialidade'];
         $consultas[$key]['estado'] = agendaStatus($value['status']);
         // $consultas[$key]['estado']= 'agendada';
         $consultas[$key]['notas'] = $value['observacao'] ?? 'Sem Informação Disponiveil';
      }

      //  $consultas= array_unique($consultas); 
      echo  json_encode($consultas, true);
   }

   public function emitir($params)
   {

      $idUser = session()->get('id');
      $p = userPerfil($idUser, 'paciente');

      $pdfStoragePath = ROOT . '/public/pdfs/';
      if (!is_dir($pdfStoragePath)) {
         mkdir($pdfStoragePath, 0777, true);
      }

      $id = $params['emitir'];
      $consultas = \App\Models\Consulta::with(['paciente.usuario', 'medico.usuario', 'medico.especialidade'])
         ->doPaciente($p->id)
         ->where('id', $id)
         ->orderBy('id', 'desc')
         ->first();


      $consultation = $consultas;

      $consultation->estado_formatado = $consultation->status;

      $consultationDate = (new DateTime($consultation->marcacao))->format('d/m/Y');
      $consultation->hora = (new DateTime($consultation->marcacao))->format('H:i:s');
      $patientBirthDate = (new DateTime($consultation->paciente->usuario->data_nascimento))->format('d/m/Y');

      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true);

      // $html = '...';  // seu HTML conforme antes
      $html = $this->content([
         'document.consult'
      ], [
         'consulta' => $consultation,
         'consultationDate' => $consultationDate,
         'patientBirthDate' => $patientBirthDate
      ]);  // seu HTML conforme antes

      $pdf = new Export(Pdf::class);
      $pdf->export([
         'html' => $html,
         'nome_arquivo' => sprintf('ficha_consulta_%s_paciente_%s_', $consultation->id, $p->id),
         'download' => false

      ]);
      exit;
      // $dompdf = new Dompdf($options);
      // $dompdf->loadHtml($html);
      // $dompdf->setPaper('A4', 'portrait');
      // $dompdf->render();

      // // Salva o PDF no servidor
      // $fileName = sprintf('ficha_consulta_%s_paciente_%s_', $consultation->id, $p->id) . ".pdf";
      // $relativePath = '/pdfs/' . $fileName;
      // $absolutePath = ROOT . '/public' . $relativePath;

      // file_put_contents($absolutePath, $dompdf->output());





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

      $patientId = session()->get('id');
      $input = file_get_contents('php://input');
      $data = json_decode($input, true);
      $consultationId = $data['consultationId'] ?? null;

      if (!$consultationId) {
         http_response_code(400);
         echo json_encode(['success' => false, 'error' => 'ID da consulta não fornecido.']);
         exit();
      }

      // Obtém dados da consulta (seu modelo existente)
      $model = (new Consulta())
         ->select("consultas.*, medicos.id mid, 
         usuarios.nome medico_nome, especialidades.nome medico_especialidade, 
         pacientes.data_nascimento, pu.nome paciente_nome")
         ->andWhere(function ($query) use ($consultationId) {
            $query->where('consultas.id', '=', $consultationId);
            // se quiser restringir ao paciente logado, adicione aqui
         })
         ->join(Medico::class, 'consultas.medico_id', '=', 'medicos.id')
         ->join(Paciente::class, 'consultas.paciente_id', '=', 'pacientes.id')
         ->join(User::class, 'pacientes.usuario_id', '=', 'pu.id', 'pu')

         ->join(Especialidade::class, 'medicos.especialidade_id', '=', 'especialidades.id')
         ->join(User::class, 'medicos.usuario_id', '=', 'usuarios.id')
         ->first();

      if (!$model) {
         http_response_code(404);
         echo json_encode(['success' => false, 'error' => 'Consulta não encontrada.']);
         exit();
      }

      $consultation = convertData($model);
      $consultation['estado_formatado'] = agendaStatus($consultation['status']);

      $consultationDate = (new DateTime($consultation['marcacao']))->format('d/m/Y');
      $consultation['hora'] = (new DateTime($consultation['marcacao']))->format('H:i:s');
      $patientBirthDate = (new DateTime($consultation['data_nascimento']))->format('d/m/Y');

      $options = new Options();
      $options->set('isHtml5ParserEnabled', true);
      $options->set('isRemoteEnabled', true);

      // $html = '...';  // seu HTML conforme antes
      $html = $this->content([
         'document.consult'
      ], [
         'consulta' => $consultation,
         'consultationDate' => $consultationDate,
         'patientBirthDate' => $patientBirthDate
      ]);  // seu HTML conforme antes


      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      // Salva o PDF no servidor
      $fileName = sprintf('ficha_consulta_%s_paciente_%s_', $consultation['id'], $patientId) . date('YmdHis') . ".pdf";
      $relativePath = '/pdfs/' . $fileName;
      $absolutePath = ROOT . '/public' . $relativePath;

      file_put_contents($absolutePath, $dompdf->output());

      // Aqui **não fazer** stream() ou qualquer outro envio de saída extra

      // Envia apenas JSONp
      http_response_code(200);
      echo json_encode([
         'success' => true,
         'message' => 'Ficha gerada com sucesso!',
         'consultationId' => $consultationId,
         'patientId' => $patientId,
         'fileUrl' => $relativePath
      ]);
      exit();
   }
}
