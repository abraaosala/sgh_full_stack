<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\Models\Paciente;
use App\Models\Provincia;
use App\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\trait\DocumentExport;
use App\Services\PacienteService;
use App\Exceptions\ValidationException;

class PacienteController extends Controller
{
   protected PacienteService $pacienteService;

   public function __construct()
   {
      $this->pacienteService = container(PacienteService::class);
   }

   use DocumentExport;

   // Métodos padrão de controllers RESTful
   public function index()
   {
      $search = $_GET['search'] ?? null;

      $pacientes = $this->pacienteService->getPaginatedList($search);
      
      $pacientes->setPath(root() . 'admin/pacientes'); 
      
      if ($search !== null && $search !== '') {
         $pacientes->appends(['search' => $search]);
      }

      $data = [
         'pacientes' => $pacientes->items(),
         'title' => 'Todos Pacientes',
         'tools' => $pacientes,
         'description' => 'Gerir Pacientes',
         'keywords' => 'Gerir, Pacientes, Listar'
      ];

      $this->view($data, 'admin.pacientes.index');
   }

   public function show($params)
   {
      $id = (int) $params['paciente'];

      if (isAjax() || isset($_GET['json'])) {
         $res = $this->pacienteService->getPacienteDetails($id);
         echo json_encode($res);
         return;
      }

      $paciente = Paciente::with([
         'usuario',
         'provincia',
         'consultas.medico.usuario',
         'consultas.agenda',
         'historicos',
         'diagnosticos.medico.usuario',
         'diagnosticos.doenca'
      ])->findOrFail($id);

      $data = [
         'paciente' => $paciente,
         'title' => 'Perfil do Paciente',
         'description' => 'Detalhes do Paciente',
      ];

      $this->view($data, 'admin.pacientes.show');
   }

   public function create()
   {
      // Limpar erros anteriores ao carregar a página (opcional, mas bom UX)
      clear_errors();

      // Exibir formulário para criar novo recurso
      $provincias = Provincia::orderBy('nome')->get();
      $data = [
         'title' => 'Criar Novo Paciente',
         'description' => 'Gerir Pacientes',
         'keywords' => 'Gerir, Pacientes, Listar',
         'provincias' => $provincias
      ];
      $this->view(globals($data), 'admin.pacientes.create');
   }

   public function store()
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

      try {
         $result = $this->pacienteService->storePaciente($data);

         PostOld::clean();

         session()->set('temp_credentials', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $result['senha']
         ]);

         $msg = sprintf(
            'Paciente registrado com sucesso! <br> <strong>Senha de Acesso: %s</strong> <br> ' .
               '<a href="%s" class="btn btn-sm btn-info mt-2" target="_blank"><i class="feather icon-printer"></i> Imprimir Protocolo de Acesso (PDF)</a>',
            $result['senha'],
            lnk('admin/imprimir-credenciais')
         );
         redirect('admin/pacientes', ['success', $msg, 'success']);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect("admin/paciente-criar", ['error', implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/pacientes', ['error', 'Erro ao cadastrar: ' . $exception->getMessage()]);
      }
   }

   public function edit($params)
   {
      $id = (int) $params['paciente-editar'];
      $paciente = $this->pacienteService->getPacienteById($id);

      if (!$paciente) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado']);
      }

      // Inject user data into paciente object for view compatibility
      $paciente->nome = $paciente->usuario->nome;
      $paciente->email = $paciente->usuario->email;
      $paciente->genero = $paciente->usuario->genero;
      $paciente->data_nascimento = $paciente->usuario->data_nascimento;

      $data = [
         'paciente' => $paciente,
         'provincias' => Provincia::all(),
         'title' => 'Editar Usuario ',
         'description' => 'Editar O Usuario',
         'keywords' => 'Editar, Usuario, Alterar',
      ];
      $this->view(globals($data), 'admin.pacientes.create');
   }

   public function update($params)
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      $id = (int) ($params['paciente-update'] ?? $params['paciente-save'] ?? $data['id'] ?? 0);

      if ($id === 0) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
      }

      try {
         $updated = $this->pacienteService->updatePaciente($id, $data);
         if (!$updated) {
            redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
         }

         PostOld::clean();
         redirect('admin/pacientes', ['success', 'Paciente atualizado com sucesso']);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect('admin/paciente-editar/' . $id, ['error', 'Verifique os erros no formulário.<br>' . implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/paciente-editar/' . $id, ['error', 'Falha ao atualizar: ' . $exception->getMessage()]);
      }
   }

   public function destroy($params)
   {
      $id = (int) ($params['paciente-excluir'] ?? 0);

      if ($id === 0) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
      }

      try {
         $deleted = $this->pacienteService->deletePaciente($id);
         if (!$deleted) {
            redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
         }
         redirect('admin/pacientes', ['success', 'Paciente excluído com sucesso']);
      } catch (\Exception $exception) {
         redirect('admin/pacientes', ['error', 'Falha ao excluir: ' . $exception->getMessage()]);
      }
   }

   public function delete($params)
   {
      $this->destroy($params);
   }

   public function exporte()
   {
      $types = ['pdf', 'csv', 'excel'];
      $type = sanitizeInput($_GET['type']);

      if (!isset($type) || !in_array($type, $types)) {
         throw new \Exception("Tipo de exportação inválido");
      }

      // Eloquent Export Data
      $pacientes = Paciente::with(['usuario', 'provincia'])->get();

      // dd($pacientes);

      $data = [];
      $data['view'] = 'document.pacientes';
      $data['data'] = [
         'title' => 'Relatório de Pacientes',
         'description' => 'Lista de Pacientes',
         'keywords' => 'Relatório, Pacientes, Lista',
         'pacientes' => $pacientes,
         'total' => count($pacientes),
         'date' => date('d/m/Y'),
         'hour' => date('H:i:s'),
         'hospital' => HOSPITAL
      ];

      $data['nome_arquivo'] = "pacientes" . date('YmdHis');
      $data['download'] = false;
      $data['model'] = $pacientes->map(function ($p) {
         return [
            'Código' => $p->code,
            'Nome' => $p->usuario->nome,
            'Gênero' => genero($p->usuario->genero),
            'Data de Nascimento' => date('d/m/Y', strtotime((string) $p->usuario->data_nascimento)),
            'Telefone' => $p->telefone,
            'E-mail' => $p->usuario->email,
            'Província' => $p->provincia->nome ?? 'N/A',
            'Endereço' => $p->endereco
         ];
      })->toArray();

      $this->export($data, $type);
   }
}