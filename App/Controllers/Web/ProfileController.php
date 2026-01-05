<?php

namespace App\Controllers\Web;

use App\classes\Session;
use App\Dao\Entity\UserEntity;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;



class ProfileController extends Controller
{

   // Métodos padrão de controllers RESTful
   public function index()
   {
      // Listar recursos
      $logado = (int) session()->get('id');

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . htmlspecialchars($logado),
         'keywords' => 'perfil, usuario, ' . htmlspecialchars($logado),
         'description' => 'Perfil de Usuario ' . htmlspecialchars($logado),
      ]), 'pages.profile');
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
      // $logado = (int) Session::get('id');
      $logado = (int) session()->get('id');

      $this->view(globals([
         'title' => 'Perfil de Usuario ' . htmlspecialchars($logado),
         'keywords' => 'perfil, usuario, ' . htmlspecialchars($logado),
         'description' => 'Perfil de Usuario ' . htmlspecialchars($logado),
      ]), 'pages.edit_profile');
   }

   public function update($params)
   {

      // Atualizar recurso existente
      $model = new User(UserEntity::class);
      // $id = (int) Session::get('id');
      $id = (int) session()->get('id');

      $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


      if (empty($data['nome'])) {
         redirect(ROUTE_PROFILE_EDIT, ['error', 'Todos os campos são obrigatórios.', 'danger']);
      }

      entity_data_itera($data, $model);
      $model->setEntity()->id = $id;
      $save = $model->save();

      if ($save) {
         // FlashMessage::set();
         redirect(ROUTE_PROFILE_VIEW, ['success', 'Seu Perfil foi actualizado com sucesso.']);
      }
   }

   public function delete($params)
   {

      // Deletar recurso
   }
}
