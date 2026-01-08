<?php
/* -------------------------------------------------------------------
 * Rotas de Medico
 * -------------------------------------------------------------------
 * Essas rotas expoem todas rotas medicas
 * 
 * Prefixo base /medico
 */

use App\Controllers\Admin\UserController;
use App\Controllers\Enfermeiro\UserController as EnfermeiroUserController;
use App\Controllers\Medical\Dashboard;
use App\controllers\PacienteUserController;
use App\Controllers\Patient\UserController as PatientUserController;
use App\Http\Route;
use App\Middleware\AuthMiddleware;
use App\Middleware\MedicoMiddleware;
use App\Middleware\VerifyPasswordGenerateMiddleware as Verify;

Route::group(['prefix' => '/medico', 'middleware' =>
[/* AuthMiddleware::class, Verify::class, 
   MedicoMiddleware::class */]], function () {


   Route::get('/home', [App\controllers\Medical\UserController::class, 'dashboard']);
   Route::get('/agenda', 'App\Controllers\Medical\AgendaMedicaController::index');
   Route::get('/api/agenda/[0-9]+', 'App\Controllers\Medical\AgendaMedicaController::show');
   Route::get('/api/consulta', 'consulta::api');


   //Pacientes
   Route::get('/pacientes', 'App\Controllers\Medical\MedPasController::index');
   Route::post('/paciente-criar', 'App\Controllers\Medical\MedPasController::store');



   //
   Route::get('/consultas', 'App\Controllers\Medical\ConsultaController::index');
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
   Route::get("/home", [PatientUserController::class, 'index']);
   Route::get('/consultas', "\App\Controllers\Patient\ConsultaController::index");
   Route::get('/consulta/criar', "App\Controllers\Patient\ConsultaController::create");
   Route::post('/consulta/salvar', "App\Controllers\Patient\ConsultaController::store");
   Route::get('/consulta/[0-9]+', "App\Controllers\Patient\ConsultaController::show");
   Route::get('/consulta/emitir/[0-9]+', "App\Controllers\Patient\ConsultaController::emitir");

   //Resultado dos exames
   Route::get('/exames', 'App\Controllers\Patient\PacienteUserController::exames');
   Route::get('/prescricoes', 'App\Controllers\Patient\PacienteUserController::prescricoes');

   //
   // Route::get('',"PacienteUser::print");
});




/* -------------------------------------------------------------------
 * Rotas de Recepcao
 * -------------------------------------------------------------------
 * Essas rotas expoem todas rotas medicas
 * 
 * Prefixo base /recepcao
 * 
*/

Route::group(['prefix' => '/recepcao', 'middleware' =>
[]], function () {
   Route::get("/home", \App\Controllers\Reception\RecepcaoController::class . '::index');


   //paciente
   Route::get('/pacientes', \App\Controllers\Reception\RecepcaoController::class . '::pacienteSearch');
   Route::get("paciente/cadastrar", \App\Controllers\Patient\PacienteController::class . '::create');


   //Resultado dos exames

});

Route::group(['prefix' => '/enfermeiro', 'middleware' =>
[]], function () {
   Route::get("/home", [EnfermeiroUserController::class, 'index']);
   Route::get("/", [EnfermeiroUserController::class, 'index']);
   Route::get("/leitos", [App\Controllers\Enfermeiro\LeitoController::class, 'index']);
   Route::get("/leito/criar", [App\Controllers\Enfermeiro\LeitoController::class, 'create']);
   Route::post("/leito/salvar", [App\Controllers\Enfermeiro\LeitoController::class, 'store']);
   Route::get("/leito/editar/[0-9]+", [App\Controllers\Enfermeiro\LeitoController::class, 'edit']);
   Route::post("/leito/atualizar/[0-9]+", [App\Controllers\Enfermeiro\LeitoController::class, 'update']);
   Route::get("/leito/excluir/[0-9]+", [App\Controllers\Enfermeiro\LeitoController::class, 'destroy']);
   Route::post("/leito/status", [App\Controllers\Enfermeiro\LeitoController::class, 'updateStatus']);




   //paciente
   Route::get('/pacientes', \App\Controllers\Reception\RecepcaoController::class . '::pacienteSearch');
   Route::get("paciente/cadastrar", \App\Controllers\Patient\PacienteController::class . '::create');


   //Resultado dos exames

});