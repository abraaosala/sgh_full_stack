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
use App\Controllers\Web\ProfileController;
use App\Http\Route;

Route::get('/', \App\Controllers\Web\HomeController::class . '::index'); //
Route::get('/meu-perfil', \App\Controllers\Web\ProfileController::class . '::index');
// Route::get('/erro/[0-9]+', "ErrorPage::erro");
Route::get('/editar-perfil', \App\Controllers\Web\ProfileController::class . '::edit');
Route::post('/perfil-update', \App\Controllers\Web\ProfileController::class . '::update');


require __DIR__ . '/settings.php';
require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/other.php';