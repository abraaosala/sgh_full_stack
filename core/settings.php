<?php

/** 
 * -------------------------------------------------------------------
 * AS ROTAS DE CONFIGURAÇÃO 
 * -------------------------------------------------------------------
 * Essas rotas expoem rotas do sistema
 * Onde estarão presentes todas rotas de configuração do sistema
 * Prefixo base: /config ou sem 
 */

use App\Http\Route;
use App\library\Auth;
use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;

/* Rotas para Auteticação */

Route::get('/login', \App\Controllers\Auth\AuthController::class . '::index')->middleware(GuestMiddleware::class);

Route::post('/login/auth', \App\Controllers\Auth\AuthController::class . '::attempt');
// Route::get('/logout', 'AuthController::logout');
Route::post('/logout', \App\Controllers\Auth\AuthController::class . '::logout');
Route::post('/sair', \App\Controllers\Auth\AuthController::class . '::apiSair');

Route::group(['prefix' => '/config', 'middleware' => [AuthMiddleware::class]], function () {
    
    Route::get('/renovar_senha_gerado', \App\Controllers\Admin\SettingController::class . '::renovarSenhaGerate');
    Route::post('/salvar-senha', \App\Controllers\Admin\SettingController::class . '::renovarSenha');
});
//Recuperar Senha
Route::get('/recuperar_senha', \App\Controllers\Admin\SettingController::class . '::recuperarSenha');
Route::post('/alterar-senha/etapa/[1-2]', \App\Controllers\Admin\SettingController::class . '::recovery');