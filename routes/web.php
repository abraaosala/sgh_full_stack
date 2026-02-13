<?php
/**
* -------------------------------------------------------------------
* AS ROTAS GERAIS pública
* -------------------------------------------------------------------
* Essas rotas expoem todas routas que são gerais
*
* Prefixo base
*/

use App\Controllers\Web\HomeController;
use App\Http\Route;
use App\library\Auth;

Route::get('/', function () {
   
   
   if (session()->has()) {
       match (session()->get('perfil')) {
         'superadmin', 'admin' => redirect(ROUTE_ADMIN_HOME),
         'medico' => redirect(ROUTE_MEDICO_HOME),
         'enfermeiro' => redirect(ROUTE_ENFERMEIRO_HOME),
         'recepcionista' => redirect(ROUTE_RECEPCAO_HOME),
         'paciente' => redirect(ROUTE_PACIENTE_HOME),
         default => redirect(ROUTE_LOGIN, ['error', 'Perfil de usuário desconhecido.', 'danger']),
      };
      
   }
   redirect(ROUTE_LOGIN, ['error', 'Usuario não foi Autenticado.', 'danger']);
}); //Landinguse App\Controllers\Web\HomeController;


Route::get('/meu-perfil', [HomeController::class, 'profile']);

// Route::get('/meu-perfil', \App\Controllers\Web\ProfileController::class . '::index');
// Route::get('/erro/[0-9]+', "ErrorPage::erro");
Route::get('/editar-perfil', [HomeController::class,  'profileEdit']);
Route::post('/perfil-update', [HomeController::class,  'profileSave']);



require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/other.php';