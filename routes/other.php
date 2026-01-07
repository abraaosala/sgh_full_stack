<?php
/* -------------------------------------------------------------------
 * Rotas de Medico
 * -------------------------------------------------------------------
 * Essas rotas expoem todas rotas medicas
 * 
 * Prefixo base /medico
 */

use App\Controllers\Medical\Dashboard;
use App\Controllers\Patient\PacienteUserController;
use App\Http\Route;
use App\Middleware\AuthMiddleware;
use App\Middleware\MedicoMiddleware;
use App\Middleware\VerifyPasswordGenerateMiddleware as Verify;

Route::group(['prefix' => '/medico', 'middleware' =>
[/* AuthMiddleware::class, Verify::class, 
   MedicoMiddleware::class */]], function () {


   Route::get('/home', [Dashboard::class, 'index']);
   Route::get('/agenda', 'App\Controllers\Medical\AgendaMedicaController::index');
   Route::get('/api/agenda/[0-9]+', 'App\Controllers\Medical\AgendaMedicaController::show');
   Route::get('/api/consulta', 'consulta::api');


   //Pacientes
   Route::get('/pacientes', 'App\Controllers\Medical\MedPasController::index');
   Route::post('/paciente-criar', 'App\Controllers\Medical\MedPasController::store');



   //
   Route::get('/consultas', 'App\Controllers\Medical\MedConsultaController::index');
   Route::get('/exames', 'App\Controllers\Medical\ExameController::index');
   Route::get('/diagnosticos', 'App\Controllers\Medical\DiagnosticoController::index');
   Route::get('/diagnostico', 'App\Controllers\Medical\DiagnosticoController::show');
});


/* -------------------------------------------------------------------
 * Rotas de Paciente
 * -------------------------------------------------------------------
 * Essas rotas expoem todas rotas medicas
 * 
 * Prefixo base /Paciente
*/
Route::group(['prefix' => '/paciente', 'middleware' =>
[]], function () {
   Route::get("/home", [PacienteUserController::class, 'index']);
   Route::get('/consultas', "App\Controllers\Patient\PcConsultaController::index");
   Route::get('/consulta/criar', "App\Controllers\Patient\PcConsultaController::create");

   //Resultado dos exames
   Route::get('/exames', 'App\Controllers\Patient\PacienteUserController::exames');
   Route::get('/prescricoes', 'App\Controllers\Patient\PacienteUserController::prescricoes');

   //
   // Route::get('',"PacienteUser::print");
});




Route::group(['prefix' => '/recepcao', 'middleware' =>
[]], function () {
   Route::get("/home", \App\Controllers\Reception\RecepcaoController::class . '::index');


   //paciente
   Route::get('/pacientes', \App\Controllers\Reception\RecepcaoController::class . '::pacienteSearch');
   Route::get("paciente/cadastrar",\App\Controllers\Patient\PacienteController::class . '::create');
   

   //Resultado dos exames
  
});