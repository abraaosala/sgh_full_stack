<?php

namespace App\Controllers\Patient;

use App\classes\FileManager;
use App\classes\Password;
use App\Models\Paciente;
use App\Models\Provincia;
use App\Models\User;
use App\Services\MailService;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\trait\DocumentExport;
use Illuminate\Database\Capsule\Manager as DB;
use App\helpers\ValidatorHelper;

class PacienteController extends Controller
{

   use DocumentExport;

   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos (Eloquent: Eager Load User)
      $pacientes = Paciente::with('usuario')->paginate(5);
      $pacientes->setPath(root() . 'admin/pacientes'); // Absolute path to fix double admin issue

      $data = [
         'pacientes' => $pacientes->items(), // Illuminate Paginator items
         'title' => 'Todos Pacientes',
         'tools' => $pacientes, // Paginator object for links
         'description' => 'Gerir Pacientes',
         'keywords' => 'Gerir, Pacientes, Listar'
      ];

      $this->view(globals($data), 'admin.pacientes.index');
   }

   public function show($params)
   {
      $id = $params['paciente'];
      $paciente = Paciente::with([
         'usuario',
         'provincia',
         'consultas.medico.usuario',
         'consultas.agenda',
         'historicos',
         'diagnosticos.medico.usuario',
         'diagnosticos.doenca'
      ])->find($id);

      if (!$paciente) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado']);
      }

      $data = [
         'paciente' => $paciente,
         'title' => 'Perfil do Paciente',
         'description' => 'Detalhes do Paciente',
      ];

      $this->view(globals($data), 'admin.pacientes.show');
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
      $data['perfil'] = 'paciente';

      // DEBUG: Inspect incoming data
      // dd($data);

      // Validação com Laravel Validator
      $validator = ValidatorHelper::make($data, [
         'nome' => 'required|min:3',
         'email' => 'required|email',
         'data_nascimento' => 'required|date',
         'telefone' => 'required',
         'endereco' => 'required',
         'provincia_id' => 'required|integer',
         'genero' => 'required'
      ]);

      if ($validator->fails()) {
         PostOld::set($data);
         // Concatenar erros para exibir (ou adaptar flash para aceitar array)
         $errors = $validator->errors()->all();
         $_SESSION['input_errors'] = $errors;
         redirect("admin/paciente-criar", ['error', implode('<br>', $errors), 'danger']);
      }

      // Verificar se e-mail já está cadastrado (Manual Unique check for now)
      if (User::where('email', $data['email'])->exists()) {
         PostOld::set($data);
         redirect("admin/paciente-criar", ['error', 'O E-mail já está em uso.', 'danger']);
      }

      DB::beginTransaction(); // Start Transaction

      try {
         // Gerar Senha
         $senha = Password::generate(2);

         // Create User
         $user = User::create([
            'nome' => $data['nome'],
            'email' => lower($data['email']),
            'perfil' => $data['perfil'],
            'genero' => $data['genero'],
            'data_nascimento' => $data['data_nascimento'],
            'senha' => Password::hash($senha),
            'senha_gerada' => 1
         ]);

         // Create Paciente via Relationship
         $user->paciente()->create([
            'code' => gerarCodigo(),
            'telefone' => $data['telefone'],
            'endereco' => $data['endereco'],
            'provincia_id' => $data['provincia_id']
         ]);

         DB::commit();
         PostOld::clean();

         // Armazenar temporariamente para o PDF
         session()->set('temp_credentials', [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => $senha
         ]);

         // Enviar E-mail (Opcional)
         (new MailService())->sendCredentials($data['email'], $data['nome'], $senha);

         $msg = sprintf(
            'Paciente registrado com sucesso! <br> <strong>Senha de Acesso: %s</strong> <br> ' .
               '<a href="%s" class="btn btn-sm btn-info mt-2" target="_blank"><i class="feather icon-printer"></i> Imprimir Protocolo de Acesso (PDF)</a>',
            $senha,
            lnk('admin/imprimir-credenciais')
         );
         redirect('admin/pacientes', ['success', $msg, 'success']);
      } catch (\Exception $exception) {
         DB::rollBack();
         redirect('admin/pacientes', ['error', 'Erro ao cadastrar: ' . $exception->getMessage()]);
      }
   }

   public function edit($params)
   {
      $id = (int) $params['paciente-editar'];
      $paciente = Paciente::with(['usuario', 'provincia'])->find($id);

      if (!$paciente) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado']);
      }

      // Inject user data into paciente object for view compatibility
      $paciente->nome = $paciente->usuario->nome;
      $paciente->email = $paciente->usuario->email;
      $paciente->genero = $paciente->usuario->genero;
      // $paciente->telefone = $paciente->usuario->telefone;
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

      $paciente = Paciente::with('usuario')->find($id);
      if (!$paciente) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
      }

      // Validação com Laravel Validator
      $validator = ValidatorHelper::make($data, [
         'nome' => 'required|min:3',
         'email' => 'required|email',
         'data_nascimento' => 'required|date',
         'telefone' => 'required',
         'endereco' => 'required',
         'provincia_id' => 'required|integer',
         'genero' => 'required'
      ]);

      if ($validator->fails()) {
         PostOld::set($data);
         $_SESSION['input_errors'] = $validator->errors()->toArray();
         redirect('admin/paciente-editar/' . $id, ['error', 'Verifique os erros no formulário.', 'danger']);
      }

      // Check unique email excluding current user
      if (User::where('email', $data['email'])->where('id', '!=', $paciente->usuario_id)->exists()) {
         PostOld::set($data);
         redirect('admin/paciente-editar/' . $id, ['error', 'O E-mail já está em uso por outro usuário.', 'danger']);
      }

      DB::beginTransaction();

      try {
         // Update User (data_nascimento here)
         $saveU =  $paciente->usuario()->update([
            'nome' => $data['nome'],
            'email' => lower($data['email']),
            'genero' => $data['genero'],
            'data_nascimento' => $data['data_nascimento']
         ]);

         // Update Paciente
         $saveP = $paciente->update([
            'telefone' => $data['telefone'],
            'endereco' => $data['endereco'],
            'provincia_id' => $data['provincia_id']
         ]);
         DB::commit();
         PostOld::clean();
         redirect('admin/pacientes', ['success', 'Paciente atualizado com sucesso']);
      } catch (\Exception $exception) {
         DB::rollBack();
         redirect('admin/paciente-editar/' . $id, ['error', 'Falha ao atualizar: ' . $exception->getMessage()]);
      }
   }

   public function destroy($params)
   {
      $id = (int) ($params['paciente-excluir'] ?? 0);

      if ($id === 0) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
      }

      $paciente = Paciente::find($id);
      if (!$paciente) {
         redirect('admin/pacientes', ['error', 'Paciente não encontrado', 'danger']);
      }

      DB::beginTransaction();
      try {
         $usuarioId = $paciente->usuario_id;
         $paciente->delete();
         User::destroy($usuarioId);

         DB::commit();
         redirect('admin/pacientes', ['success', 'Paciente excluído com sucesso']);
      } catch (\Exception $exception) {
         DB::rollBack();
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