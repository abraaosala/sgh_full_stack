<?php

use App\Http\Route;

// 1. Rota simples (pública)
Route::get('/', 'HomeController@index');
Route::get('/contact', 'ContactController@show');

// 2. Rota com middleware específico
Route::post('/login', 'AuthController@login')->middleware('GuestMiddleware');

// 3. Grupo de rotas autenticadas com prefixo
// Todas as rotas aqui dentro exigirão 'AuthMiddleware' e começarão com '/admin'
Route::group(['prefix' => '/admin', 'middleware' => 'AuthMiddleware'], function () {

    Route::get('/dashboard', 'AdminController@dashboard'); // URL: /admin/dashboard
    Route::get('/settings', 'AdminController@settings'); // URL: /admin/settings

    // Adicionando um middleware extra a uma rota que já está no grupo
    // Esta rota exigirá 'AuthMiddleware' E 'AdminOnlyMiddleware'
    Route::get('/users', 'UserController@list')->middleware('AdminOnlyMiddleware'); // URL: /admin/users
});

// 4. Grupo de rotas de API com múltiplos middlewares de grupo
Route::group(['prefix' => '/api', 'middleware' => ['ApiTokenMiddleware', 'ThrottleRequestsMiddleware']], function () {

    Route::get('/products', 'ApiController@getProducts'); // URL: /api/products
    Route::get('/orders/{id}', 'ApiController@getOrder');  // URL: /api/orders/{id}

});

// A classe Route está pronta para ser usada pelo seu Router principal
// que irá ler as rotas com `Route::getAllRoutes()`