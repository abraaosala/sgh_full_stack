<?php

/**
 * -------------------------------------------------------------------
 * AS ROTAS DE API 
 * -------------------------------------------------------------------
 * Essas rotas expõem serviços RESTful consumidos pelo frontend web 
 * ou mobile. A maioria exige autenticação com token (ex: JWT).
 * Prefixo base: /api
 */

use App\Controllers\Medical\AgendaMedicaController;
use App\Http\Route;
use App\Middleware\AuthMiddleware;
use App\Middleware\PacienteMiddleware;
use Illuminate\Support\Js;

Route::group(['prefix' => '/api', 'middleware' => []], function () {


    Route::post('/login', \App\Controllers\Auth\AuthController::class . '::attempt');

    Route::get('/agenda/medico', [AgendaMedicaController::class, 'api']);

    Route::post('/agenda/medico/store', [AgendaMedicaController::class, 'store']);

    Route::put('/agenda/medico/save', [AgendaMedicaController::class, 'update']);

    Route::delete('/agenda/medico/deletar', 'App\Controllers\Medical\AgendaMedicaController::delete');

    Route::get('/consulta', 'App\Controllers\Web\ConsultaController::api')
        ->middleware(AuthMiddleware::class);
    Route::get('/consultas/paciente', "App\Controllers\Patient\ConsultaController::api");



    Route::get('consult/med-paciente', "App\Controllers\Medical\MedPasController::api");

    //a
    Route::get('/consulta/all', 'App\Controllers\Web\ConsultaController::apiAll');
    Route::post('/consulta/store', 'App\Controllers\Web\ConsultaController::store');



    Route::get('/diagnostico', 'App\Controllers\Medical\DiagnosticoController::api');
    Route::get('/diagnostico/doenca/[0-9]+', 'App\Controllers\Medical\DiagnosticoController::apipassdia');

    //Api do Paciente
    Route::get('/consulta/pac-listar', 'App\Controllers\Patient\ConsultaController::list')
        ->middleware(AuthMiddleware::class)
        ->middleware(PacienteMiddleware::class)
    ;
    Route::get('/consulta/paciente/all', 'App\Controllers\Patient\ConsultaController::apiAll');
    Route::post('/consulta-paciente/store', 'App\Controllers\Patient\ConsultaController::store');

    Route::post('/emitir-ficha', 'App\Controllers\Patient\ConsultaController::print');
    Route::post('/med_emitir_ficha', 'App\Controllers\Medical\MedPasController::print');




    //api de paciente para

    Route::get('/recepcao/paciente/nome/[a-z]+', \App\Controllers\Reception\RecepcaoController::class . '::api');
});
