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

Route::get('/', [HomeController::class,'index']); //Landinguse App\Controllers\Web\HomeController;


Route::get('/meu-perfil', [HomeController::class, 'profile']);

// Route::get('/meu-perfil', \App\Controllers\Web\ProfileController::class . '::index');
// Route::get('/erro/[0-9]+', "ErrorPage::erro");
Route::get('/editar-perfil', [HomeController::class,  'profileEdit']);
Route::post('/perfil-update', [HomeController::class,  'profileSave']);



require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/other.php';