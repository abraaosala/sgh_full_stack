<?php

/**
 * -------------------------------------------------------------------
 * ROTAS DE  ADMINISTRAÇÃO
 * -------------------------------------------------------------------
 * Todas as rotas neste grupo são protegidas e exigem que o usuário
 * esteja logado (AuthMiddleware) e tenha permissão de administrador
 * (AdminOnlyMiddleware). Todas as URLs começarão com /admin.
 */

use App\Controllers\Web\ConsultaController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AdminOnlyMiddleware;
use App\Middleware\SuperAdminOnlyMiddleware;
use App\Http\Route;
use App\library\Auth;
use App\Middleware\AuthMiddleware;
use App\Models\Consulta;

Route::group(['prefix' => '/admin', 'middleware' => [
    AuthMiddleware::class,
    AdminOnlyMiddleware::class
]], function () {

    Route::get('/', \App\Controllers\Admin\AdminController::class . '::index');

    //usuarios e seus  perfis
    Route::get('/usuarios', \App\Controllers\Admin\UserController::class . '::index');
    Route::get('/usuarios-criar', \App\Controllers\Admin\UserController::class . '::create');
    Route::get('/usuario/[0-9]+', \App\Controllers\Admin\UserController::class . '::show');
    Route::post('/usuario-salvar', \App\Controllers\Admin\UserController::class . '::store');
    Route::get('/usuario-editar/[0-9]+', \App\Controllers\Admin\UserController::class . '::edit');
    Route::post('/usuario-save/[0-9]+', \App\Controllers\Admin\UserController::class . '::update');

    //Api de Usuarios
    Route::get('/api/usuarios', "UserController::list");



    // Medicos(Admin)
    Route::get('/medicos', \App\Controllers\Medical\MedicoController::class . '::index');

    Route::get('/medico-criar', \App\Controllers\Medical\MedicoController::class . '::create');
    Route::get('/medico/[0-9]+', \App\Controllers\Medical\MedicoController::class . '::show');
    Route::post('/medico-store', \App\Controllers\Medical\MedicoController::class . '::store');
    Route::get('/medico-editar/[0-9]+', \App\Controllers\Medical\MedicoController::class . '::edit');
    Route::post('/medico-update/[0-9]+', \App\Controllers\Medical\MedicoController::class . '::update');
    Route::get('/medico-excluir/[0-9]+', \App\Controllers\Medical\MedicoController::class . '::destroy');
    Route::get('/medico-export', \App\Controllers\Medical\MedicoController::class . '::exporte');

    Route::post('agenda-med-gerar', function () {});


    Route::get('/pacientes', \App\Controllers\Patient\PacienteController::class . '::index');
    Route::get('/agenda', "Reception\\AgendaController::index");

    // Pacientes (Admin)
    Route::get('/paciente-criar', \App\Controllers\Patient\PacienteController::class . '::create');
    Route::get('/paciente-editar/[0-9]+', \App\Controllers\Patient\PacienteController::class . '::edit');
    Route::get('/paciente/[0-9]+', \App\Controllers\Patient\PacienteController::class . '::show');
    Route::post('/paciente-update/[0-9]+', \App\Controllers\Patient\PacienteController::class . '::update');
    Route::get('/paciente-excluir/[0-9]+', \App\Controllers\Patient\PacienteController::class . '::destroy');
    Route::post('/paciente-store', \App\Controllers\Patient\PacienteController::class . '::store');
    Route::post('/paciente-save', \App\Controllers\Patient\PacienteController::class . '::update');
    Route::get('/paciente-export', \App\Controllers\Patient\PacienteController::class . '::exporte');


    //Funcionarios
    Route::get("/funcionarios", \App\Controllers\Admin\FuncionarioController::class . '::index');
    Route::get("/funcionario-criar", \App\Controllers\Admin\FuncionarioController::class . '::create');
    Route::post("/funcionario-store", \App\Controllers\Admin\FuncionarioController::class . '::store');


    //Leito
    Route::get('/leitos', \App\Controllers\Admin\LeitoController::class . '::index');
    Route::get('/leito-criar', \App\Controllers\Admin\LeitoController::class . '::create');
    Route::post('/leito-store', \App\Controllers\Admin\LeitoController::class . '::store');
    Route::get('/leito-editar/[0-9]+', \App\Controllers\Admin\LeitoController::class . '::edit');
    Route::post('/leito-update/[0-9]+', \App\Controllers\Admin\LeitoController::class . '::update');
    Route::get('/leito-excluir/[0-9]+', \App\Controllers\Admin\LeitoController::class . '::destroy');

    // Consultas 
    Route::get('/consultas', [ConsultaController::class, 'index']);
    Route::get('/consulta/[0-9]+', [ConsultaController::class, 'show']);
    Route::delete('/zerar-consulta', 'Consulta::truncate');

    // Diagnósticos
    Route::get('/diagnosticos', \App\Controllers\Admin\DiagnosticoController::class . '::index');
    Route::get('/diagnostico/[0-9]+', \App\Controllers\Admin\DiagnosticoController::class . '::show');
    Route::get('/diagnostico-excluir/[0-9]+', \App\Controllers\Admin\DiagnosticoController::class . '::delete');

    // Relatórios
    Route::get('/relatorios', \App\Controllers\Admin\RelatorioController::class . '::index');
});
