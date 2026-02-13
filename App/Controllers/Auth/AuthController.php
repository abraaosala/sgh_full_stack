<?php

namespace App\Controllers\Auth;

use App\Http\BaseController as Controller;

use App\classes\Json;
use App\classes\Csrf;
use App\classes\Password;
use App\classes\Session;
use App\trait\TemplateView as View;
use App\Models\User;

use App\library\PostOld;

class AuthController
{
   use View;

   // Métodos padrão de controllers RESTful
   public function index()
   {

      // Listar recursos
      // Render the login view
      $data = [
         'title' => 'Login',
         'keywords' => 'login, sistema, hospitalar'
      ];
      $this->render([
         'partials/header-html',
         'auth/login',
         'partials/footer-html',
      ], data($data));
   }

   public function attempt()
   {


      //data
      $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      // CSRF Protection
      if (!(new Csrf())->isValid($data['csrf_token'] ?? null)) {
         redirect(ROUTE_LOGIN, ['error', "Token de Segurança Inválido (CSRF)", 'danger']);
      }

      $data = sanitizeInput(filter_input_array(INPUT_POST, FILTER_DEFAULT));
      //======================================
      $email = lower($data['email']);
      $senha = $data['password'];
      //======================================

      if ($email === '' || $email === '0' || empty($senha)) {
         PostOld::set($data);
         redirect(ROUTE_LOGIN, ['error', "Campos Obrigatórios", 'danger']);
      }

      // Eloquent Migration: Find user by email
      $find = User::where('email', $email)->first();

      if (!$find) {
         PostOld::set($data);
         redirect(ROUTE_LOGIN, ['error', "Credencias não coresponde", 'danger']);
      }


      // Check password (support both 'senha' and 'senha_hash' columns just in case)
      $dbPassword = $find->senha ?? $find->senha_hash;

      if (!Password::verify($senha, $dbPassword)) {
         PostOld::set($data);
         redirect(ROUTE_LOGIN, ['error', "Credencias não coresponde", 'danger']);
      }


      /* Autenticação baseada em Niveis */
      /* Session::multiSet([
         'id' => $find->id,
         'perfil' => $find->perfil,
         'model' => $model::class
      ]); */
      session()->sets([
         'id' => $find->id,
         'perfil' => $find->perfil,
      ]);

      // Verificar se a senha foi gerada pelo sistema (exige troca obrigatória)
      if ($find->senha_gerada == 1) {
         redirect('/renovar_senha_gerado', ['info', 'Por favor, altere sua senha temporária para continuar.', 'info']);
      }

      // Redireciona conforme o nível de perfil
      match ($find->perfil) {
         'superadmin', 'admin' => redirect(ROUTE_ADMIN_HOME),
         'medico' => redirect(ROUTE_MEDICO_HOME),
         'enfermeiro' => redirect(ROUTE_ENFERMEIRO_HOME),
         'recepcionista' => redirect(ROUTE_RECEPCAO_HOME),
         'paciente' => redirect(ROUTE_PACIENTE_HOME),
         default => redirect(ROUTE_LOGIN, ['error', 'Perfil de usuário desconhecido.', 'danger']),
      };
      // Super Admin
      if ($find->perfil === 'superadmin') {
         # code...
         Session::multiSet([
            'id' => $find->id,
            'perfil' => $find->perfil,
            'model' => $model::class
         ]);
         redirect(ROUTE_ADMIN_HOME);
      }
   }

   public function logout()
   {
      Session::destroy();
      redirect(ROUTE_LOGIN, ['success', 'Logout realizado com sucesso!', 'success']);
   }

   public function apiSair()
   {
      header(API);
      Session::destroy();
      Json::encode([
         'status' => 'true',
         'msg' => 'Saiu com Sucesso',
         'redirect' => '/login'
      ]);
   }
}
