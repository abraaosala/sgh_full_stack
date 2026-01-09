<?php

namespace App\Controllers\Admin;

use App\classes\Password;
use App\Dao\Entity\FuncionarioEntity;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\Funcionario;
use App\Dao\Models\Provincia;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;
use App\utils\Str;

class FuncionarioController extends Controller
{

   private array $perfil = ['enfermeiro', 'recepcionista'];

   // Métodos padrão de controllers RESTful
   public function index()
   {


      $func = \App\Models\User::whereIn('perfil', $this->perfil)->paginate(5);
      $func->setPath(lnk('admin/funcionarios'));
      
      $this->view(globals([
         'title' => 'Todos Funcionários',
         'usuarios' => $func->items(),
         'tools' => $func
      ]), 'admin.funcionarios.index');
   }

   public function show($params)
   {

      // Exibir recurso específico

   }

   public function create()
   {
      // criar novo recurso

      $provincias = (new Provincia())->all();
      // dd($provincias);
      $this->view(globals(
         [
            'title' => 'Criar Novo Funcionário',
            'description' => 'Gerir Funcionários',
            'keywords' => 'Girir, Funcionários, Listar',
            'provincias' => $provincias,
            'funcionarios' => ['Enfermeiro', 'Recepcionista']
         ]
      ), 'admin.funcionarios.create');
   }

   public function store()
   {
      // Salvar novo recurso

      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS));
      // Validar CSRF
      if (!csrf()->isValid($data['csrf_token'])) {
         // Redirecionar com mensagem de erro se o token for inválido
         redirect('admin/funcionario-criar', ['error', 'Erro ao processar o formulário. Por favor, tente novamente.', 'danger']);
      }

      unset($data['csrf_token']);

      // dd($_POST);
      $user = new User(UserEntity::class);
      $funcionario = new Funcionario(FuncionarioEntity::class);


      // Separar os dados do usuário dos dados de endereço
      $userKeys = $user->fillable;
      $funcionarioKeys = $funcionario->fillable;

      //gerar Senha 


      // Usar array_flip e array_intersect_key para separar os dados
      $userData = sepatateDate($data, $userKeys);
      $funcionarioData = sepatateDate($data, $funcionarioKeys);
      // dd($data);

      /* Validação */
      $validate = validator($data);

      $validate
         ->Roles('nome', 'required', "Campo nome é Obrigatório")
         ->Roles('email', 'required', "Campo email é Obrigatório")
         ->Roles('email', 'email', "Não é compativel ao um email ex:exemplo@dominio.com")
         ->Roles('numero_ordem', 'required', "Campo Numero da ordem é Obrigatório");

      if (!$validate->validation()) {
         PostOld::set($_POST);
         $errors = $validate->getErrors();
         $erros = iteraErrorValidator($errors);
         // $error= explode('<br> ', $erros);
         // unset()
         // dd($error);
         // $erros = Str::implode($errors);
         // dd($_SESSION);
         redirect('admin/funcionario-criar', ['error', $erros, 'danger']);
      }


      if ($user->unique($data['email'], 'email')) {
         # code...
         redirect('admin/funcionario-criar', ['error', 'Usuario já está Cadastrado', 'danger']);
      }

      // entity_itera($userData, $user->setEntity());
      $uentity = $user->setEntity();
      $fentity = $funcionario->setEntity();

      entity_itera($userData, $uentity);


      $senha = Password::generate(2);
      $uentity->senha = Password::hash($senha);
      $file = manager();

      if (!$file->exists('email', $data['email'])) {
         # code...
         $file->add([
            'email' => $data['email'],
            'senha' => $senha
         ]);
      }

      entity_itera($funcionarioData, $fentity);


      // Iniciar transação (se disponível)
      // $user->beginTransaction();

      //Armazenar Usuario funcionario
      $userStore = $user->store();

      if ($userStore) {
         $funcionario->setEntity()->usuario_id = (int) $userStore;


         //Armazenar Dados funcionario
         $funcionarioStore = $funcionario->store();
         // dd($funcionarioStore);

         if ($funcionarioStore) {
            redirect('admin/funcionarios', ['success', 'Funcionario Registrado com sucesso']);

            PostOld::clean();
         } else {
            redirect('admin/funcionarios', ['error', 'Funcionario não Cadastrado', 'danger']);
         }
      } else {
         redirect('admin/funcionarios', ['error', 'Usuario não Cadastrado', 'danger']);
      }


      //  dd($user);     

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
