<?php

namespace App\Controllers\Admin;

use App\classes\FileManager;
use App\classes\Password;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;
use App\library\PostOld;

class UserController extends Controller
{


   // Métodos padrão de controllers RESTful
   public function index()
   {


      $tools = (new User())->select()
         ->where('perfil', '!=', 'superadmin');
      if (!empty($_GET['q'])) {
         $tools->like(
            'nome',
            $_GET['q']
         );
      }

      //   dd($tools->paginate());
      $tools = $tools->paginate();
      // Listar com excepção do super Usuario

      $data = [

         'title' => 'Todos Usuarios',
         'usuarios' => $tools->Items,
         'tools' => $tools,

         'description' => 'Gerir Usuarios',
         'keywords' => 'Girir, Usuarios, Listar'

      ];

      $this->view(globals($data), 'admin.users');
      // dd($users);
   }

   public function show($params)
   {

      // Exibir recurso específico

   }

   public function store()
   {
      $model = new User(UserEntity::class);
      $model1 = new User(UserEntity::class);
      $user = new User(UserEntity::class);
      //armazenar no data e limpar 
      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      // dd($data);

      $nome = $data['nome'];
      $email = $data['email'];
      $perfil =  $data['perfil'];


      //verificar se esta vazio
      if (empty($nome) || empty($email) || empty($perfil)) {
         PostOld::set($data);
         redirect(ROUTE_ADMIN_USERS_CREATE, ['error', 'Campos obrigatórios', 'danger']);
      }



      //verificar email
      $emailAny = $model->findbyEmail($email, "COUNT(*) as total")->total;

      if ($emailAny == 1) {
         PostOld::set($data);
         redirect(ROUTE_ADMIN_USERS_CREATE, ['error', 'Email já existe', 'danger']);
      }

      $model1->findbyPerfil($perfil, "COUNT(*) as total")->total;

      //Limitar O codastro de SuperAdmin
      limiteCad($perfil, $model, ROUTE_ADMIN_USERS);
      /* Verificar se já existe um superadmin - O sistema só permite 1 */
      /*  if ($perfil == 'superadmin' && $PerfilAny == 1) {
         PostOld::set($data);
         redirect('admin/usuarios-criar', ['error', 'O sistema só permite 1 superadmin', 'danger']);
      } */

      /* Verificar se já existe um admin - O sistema só permite 2 */

      /*   if ($perfil == 'admin' && $PerfilAny == 2) {
         # code...
         PostOld::set($data);
         PostOld::clean();
         redirect('admin/usuarios-criar', ['error', 'O sistema só permite 2 admin não pode cadastrar', 'danger']);
      } */

      $user->setEntity()->nome = $nome;
      $user->setEntity()->email = $email;
      $user->setEntity()->perfil = $perfil;
      /* Gerar A Senha */
      $password = Password::generate(3);

      /* Armazenar Senha em um arquivo */
      $file = new FileManager();
      $file->add([
         'email' => $email,
         'senha' => $password
      ]);
      $user->setEntity()->senha = Password::hash($password);


      // Salvar novo recurso
      $store = $user->store();

      if ($store) {
         PostOld::clean();

         redirect(
            ROUTE_ADMIN_USERS,
            ['success', 'Usuarios Cadastrado com Successo']
         );
      }
   }

   public function create()
   {
      // PostOld::clean();
      $data = [

         'title' => 'Todos Usuarios',
         'description' => 'Gerir Usuarios',
         'keywords' => 'Girir, Usuarios, Listar'

      ];
      $this->view(globals($data), 'admin.user-criar');
   }

   public function edit($params)
   {


      $id = $params['usuario-editar'];
      $model = (new User())->findById($id);
      (new User())->findById($id, "Count(*) as total");

      //Proibir Usuario SuperAdmin ser alterado
      if ($model->perfil === 'superadmin') {
         redirect(
            ROUTE_ADMIN_USERS,
            ['error', 'Usuarios não pode ser alterado', 'danger']
         );
      }

      // dd($any->total);
      $data = [
         'user' => $model,
         'title' => 'Todos Usuarios',
         'description' => 'Gerir Usuarios',
         'keywords' => 'Girir, Usuarios, Listar',


      ];
      $this->view(globals($data), 'admin.user-edit');
      // Editar recurso existente

   }

   public function update($params)
   {

      $id = $params['usuario-save'];
      $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      $model = new User(UserEntity::class);
      $model->setEntity()->id = $id;

      entity_data_itera($data, $model);

      limiteCad($data['perfil'], $model, ROUTE_ADMIN_USERS);

      // Atualizar recurso existente
      if ($model->save()) {
         redirect(
            ROUTE_ADMIN_USERS,
            ['success', 'Usuarios não pode ser alterado']
         );
      } else {
         redirect(
            ROUTE_ADMIN_USERS,
            ['error', 'Usuarios não pode ser alterado', 'danger']
         );
      }
   }

   public function delete($params)
   {

      // Deletar recurso
   }

   public function list()
   {
      $tools = (new User())->select("id, nome,genero,email, perfil, criado_em")
         ->where('perfil', '!=', 'superadmin');
      $q = $_GET['q'];
      if (!empty($q)) {
         $tools->like(function ($query) use ($q) {
            $query->like([['nome', $q], ['email', $q]], 'or')

            ;
            // Lógica interna é AND
         });
      }

      $tools = $tools->get();
      echo json_encode(convertData($tools),  true);
   }
}