<?php

namespace App\Controllers\Medical;

use App\classes\Password;
use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\Provincia;
use App\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\trait\DocumentExport;
use App\helpers\ValidatorHelper;
use Illuminate\Database\Capsule\Manager as DB;

class MedicoController extends Controller
{
   use DocumentExport;

   // Métodos padrão de controllers RESTful
   public function index()
   {
      $medicos = Medico::with(['usuario', 'especialidade'])->paginate(5);
      // Fix for pagination path if needed, similar to PacienteController
      $medicos->setPath(lnk('admin/medicos'));

      $data = [
         'medicos' => $medicos->items(),
         'title' => 'Todos Medicos',
         'tools' => $medicos,
         'description' => 'Gerir Medicos',
         'keywords' => 'Gerir, Medicos, Listar'
      ];

      $this->view(globals($data), 'admin.medicos.index');
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
      $id = $params['medico'];
      $medico = Medico::with(['usuario', 'especialidade', 'provincia'])->find($id);

      $data = [];
      if ($medico) {
         $data = $medico->toArray();
         // Backward compatibility mappings if frontend expects flat structure
         $data['nome'] = $medico->usuario->nome ?? '';
         $data['email'] = $medico->usuario->email ?? '';
         $data['especialidade'] = $medico->especialidade->nome ?? '';
         $data['provincia'] = $medico->provincia->nome ?? '';
      }

      echo json_encode($data, true);
   }

   public function store()
   {
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      $data['perfil'] = 'medico';

      // Validation
      $validator = ValidatorHelper::make($data, [
         'nome' => 'required|min:3',
         'email' => 'required|email',
         'data_nascimento' => 'required|date',
         'telefone' => 'required',
         'genero' => 'required',
         'especialidade_id' => 'required|integer',
         'provincia_id' => 'required|integer',
         'numero_ordem' => 'required',
         'nivel' => 'required'
      ]);

      if ($validator->fails()) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $validator->errors()->toArray(); // Store for view
         $errorMsg = implode('<br>', $validator->errors()->all());
         redirect("admin/medico-criar", ['error', $errorMsg, 'danger']);
      }

      if (User::where('email', $data['email'])->exists()) {
         PostOld::set($data);
         redirect('admin/medico-criar', ['error', 'Usuario já está Cadastrado', 'danger']);
      }

      DB::beginTransaction();

      try {
         // Create User
         $senha = Password::generate(2);
         $user = User::create([
            'nome' => $data['nome'],
            'email' => strtolower((string) $data['email']),
            'perfil' => $data['perfil'],
            'genero' => $data['genero'],
            'data_nascimento' => $data['data_nascimento'], // Assuming user table has this
            'senha' => Password::hash($senha),
            'senha_gerada' => 1
         ]);

         // Create Medico
         $medico = $user->medico()->create([
            'telefone' => $data['telefone'],
            'especialidade_id' => $data['especialidade_id'],
            'provincia_id' => $data['provincia_id'],
            'numero_ordem' => $data['numero_ordem'],
            'nivel' => $data['nivel'],
            'hospital' => $data['hospital'] ?? HOSPITAL // Fallback if not in form
         ]);

         // Only for development/testing environment
         $file = manager();
         if (!$file->exists('email', $data['email'])) {
            $file->add([
               'email' => $data['email'],
               'senha' => $senha
            ]);
         }

         DB::commit();
         PostOld::clean();
         redirect('admin/medicos', ['success', 'Medico Registrado com sucesso']);
      } catch (\Exception $exception) {
         DB::rollBack();
         redirect('admin/medicos', ['error', 'Erro ao cadastrar: ' . $exception->getMessage()]);
      }
   }

   public function stored() {}

   public function edit($params)
   {
      $id = (int) $params['medico-editar'];

      $medico = Medico::with(['usuario', 'especialidade', 'provincia'])->find($id);

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
      $id = (int) $params['medico-update']; // Assuming param name is preserved or passed correctly

      if ($id === 0) {
         // Fallback if param name differs in route
         $id = (int) ($data['id'] ?? 0);
      }

      $medico = Medico::with('usuario')->find($id);
      if (!$medico) {
         redirect('admin/medicos', ['error', 'Medico não encontrado']);
      }

      ValidatorHelper::make($data, [
         'nome' => 'required|min:3',
         'email' => 'required|email',
         // 'data_nascimento' => 'required|date', // If present in edit form
         'genero' => 'required',
         // Add other validations as needed matching the edit form
      ]);

      // Note: If some fields are disabled or not sent in edit, adjust validation accordingly.
      // Assuming typical edit fields are presents:

      if (User::where('email', $data['email'])->where('id', '!=', $medico->usuario_id)->exists()) {
         redirect('admin/medico-editar/' . $id, ['error', 'Email já em uso por outro usuário', 'danger']);
      }

      DB::beginTransaction();
      try {
         $medico->usuario()->update([
            'nome' => $data['nome'],
            'email' => strtolower((string) $data['email']),
            'genero' => $data['genero'],
            // 'data_nascimento' => $data['data_nascimento'] ?? $medico->usuario->data_nascimento
         ]);

         $medico->update([
            'telefone' => $data['telefone'] ?? $medico->telefone,
            'especialidade_id' => $data['especialidade_id'] ?? $medico->especialidade_id,
            'provincia_id' => $data['provincia_id'] ?? $medico->provincia_id,
            'numero_ordem' => $data['numero_ordem'] ?? $medico->numero_ordem,
            'nivel' => $data['nivel'] ?? $medico->nivel,
         ]);

         DB::commit();
         PostOld::clean();
         redirect('admin/medicos', ['success', 'Medico atualizado com sucesso']);
      } catch (\Exception $exception) {
         DB::rollBack();
         redirect('admin/medicos', ['error', 'Falha ao atualizar: ' . $exception->getMessage()]);
      }
   }

   public function delete($params)
   {
      // Implement delete if logical delete (soft delete) or hard delete is required.
      // Typically: Medico::destroy($params['id']);
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
            'lists' => $flatMedicos, // The view likely expects 'lists'
            'total' => $medicos->count(),
            'date' => date('d/m/Y'),
            'hour' => date('H:i:s'),
            'hospital' => HOSPITAL
         ],
         'nome_arquivo' => "medicos" . date('YmdHis'),
         'download' => false,
         'model' => $medicos // Or flatMedicos if DocumentExport trait uses it primarily
      ];

      $this->export($data, $type);
   }
}
 