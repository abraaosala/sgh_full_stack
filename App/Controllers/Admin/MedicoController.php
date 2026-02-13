<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\Provincia;
use App\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\trait\DocumentExport;
use App\Services\MedicoService;
use App\Exceptions\ValidationException;

class MedicoController extends Controller
{
   protected MedicoService $medicoService;

   public function __construct()
   {
      $this->medicoService = container(MedicoService::class);
   }

   use DocumentExport;

   // Métodos padrão de controllers RESTful
   public function index()
   {
      $search = $_GET['search'] ?? null;

      $medicos = $this->medicoService->getPaginatedList($search);

      $medicos->setPath(root() . 'admin/medicos');
      if ($search !== null && $search !== '') {
         $medicos->appends(['search' => $search]);
      }

      $data = [
         'medicos' => $medicos->items(),
         'title' => 'Todos Medicos',
         'tools' => $medicos,
         'description' => 'Gerir Medicos',
         'keywords' => 'Gerir, Medicos, Listar'
      ];

      $this->view($data, 'admin.medicos.index');
   }

   public function create()
   {
      // Clear previous errors
      clear_errors();

      $provincias = Provincia::orderBy('nome')->get();
      $especialidades = Especialidade::orderBy('nome')->get();

      $data = [
         'title' => 'Criar Novo Medico',
         'description' => 'Gerir Medicos',
         'keywords' => 'Gerir, Medicos, Listar',
         'provincias' => $provincias,
         'especialidades' => $especialidades
      ];
      $this->view(globals($data), 'admin.medicos.create');
   }

   public function show($params)
   {
      $id = (int) $params['medico'];
      $data = $this->medicoService->getMedicoDetails($id);

      echo json_encode($data);
      return;
   }

   public function store()
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));

      try {
         $result = $this->medicoService->storeMedico($data);

         PostOld::clean();

         session()->set('temp_credentials', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $result['senha']
         ]);

         $msg = sprintf(
            'Médico Registrado com sucesso! <br> <strong>Senha de Acesso: %s</strong> <br> ' .
               '<a href="%s" class="btn btn-sm btn-info mt-2" target="_blank"><i class="feather icon-printer"></i> Imprimir Protocolo de Acesso (PDF)</a>',
            $result['senha'],
            lnk('admin/imprimir-credenciais')
         );
         redirect('admin/medicos', ['success', $msg, 'success']);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect("admin/medico-criar", ['error', implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/medicos', ['error', 'Erro ao cadastrar: ' . $exception->getMessage()]);
      }
   }

   public function stored() {}

   public function edit($params)
   {
      $id = (int) $params['medico-editar'];

      $medico = $this->medicoService->getMedicoById($id);

      if (!$medico) {
         redirect('admin/medicos', ['error', 'Medico não encontrado']);
      }

      // Inject user data into medico object for view compatibility
      $medico->nome = $medico->usuario->nome;
      $medico->email = $medico->usuario->email;
      $medico->genero = $medico->usuario->genero;
      $medico->data_nascimento = $medico->usuario->data_nascimento;

      $provincias = Provincia::orderBy('nome')->get();
      $especialidades = Especialidade::orderBy('nome')->get();

      $data = [
         'title' => 'Editar Medico',
         'description' => 'Gerir Medicos',
         'keywords' => 'Gerir, Medicos, Listar',
         'medico' => $medico,
         'provincias' => $provincias,
         'especialidades' => $especialidades
      ];
      $this->view(globals($data), 'admin.medicos.create');
   }

   public function update($params)
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      $id = (int) ($params['medico-update'] ?? $data['id'] ?? 0);

      if ($id === 0) {
         redirect('admin/medicos', ['error', 'Medico não encontrado']);
      }

      try {
         $updated = $this->medicoService->updateMedico($id, $data);
         if (!$updated) {
            redirect('admin/medicos', ['error', 'Medico não encontrado']);
         }

         PostOld::clean();
         redirect('admin/medicos', ['success', 'Medico atualizado com sucesso']);
      } catch (ValidationException $e) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $e->getErrors();
         redirect("admin/medico-editar/" . $id, ['error', 'Verifique os erros no formulário.<br>' . implode('<br>', $e->getErrors()), 'danger']);
      } catch (\Exception $exception) {
         redirect('admin/medicos', ['error', 'Falha ao atualizar: ' . $exception->getMessage()]);
      }
   }

   public function destroy($params)
   {
      $id = (int) ($params['medico-excluir'] ?? 0);

      if ($id === 0) {
         redirect('admin/medicos', ['error', 'Médico não encontrado', 'danger']);
      }

      try {
         $deleted = $this->medicoService->deleteMedico($id);
         if (!$deleted) {
            redirect('admin/medicos', ['error', 'Médico não encontrado', 'danger']);
         }
         redirect('admin/medicos', ['success', 'Médico excluído com sucesso']);
      } catch (\Exception $exception) {
         redirect('admin/medicos', ['error', 'Falha ao excluir: ' . $exception->getMessage()]);
      }
   }

   public function delete($params)
   {
      $this->destroy($params);
   }

   public function exporte()
   {
      $types = ['pdf', 'csv', 'excel'];
      $type = sanitizeInput($_GET['type'] ?? '');

      if (!in_array($type, $types)) {
         throw new \Exception("Tipo de exportação inválido");
      }

      // Fetch Data with Eloquent
      $medicos = Medico::with(['usuario', 'provincia', 'especialidade'])->get();

      // Transform for export if needed (flattening structure often helps views/export logic)
      $flatMedicos = $medicos->map(function ($m) {
         $m->nome = $m->usuario->nome;
         $m->email = $m->usuario->email;
         $m->genero = $m->usuario->genero;
         $m->provincia_nome = $m->provincia->nome;
         return $m;
      });

      $data = [
         'view' => 'document.medicos',
         'data' => [
            'title' => 'Relatório de medicos',
            'description' => 'Lista de medicos',
            'keywords' => 'Relatório, medicos, Lista',
            'medicos' => $flatMedicos,
            'total' => $medicos->count(),
            'date' => date('d/m/Y'),
            'hour' => date('H:i:s'),
            'hospital' => HOSPITAL
         ],
         'nome_arquivo' => "medicos" . date('YmdHis'),
         'download' => false,
         'model' => $medicos->map(function ($m) {
            return [
               'Nº Ordem' => $m->numero_ordem,
               'Nome' => $m->usuario->nome,
               'Especialidade' => $m->especialidade->nome ?? 'N/A',
               'Gênero' => genero($m->usuario->genero),
               'Telefone' => $m->telefone,
               'E-mail' => $m->usuario->email,
               'Província' => $m->provincia->nome ?? 'N/A'
            ];
         })->toArray()
      ];

      $this->export($data, $type);
   }
}
