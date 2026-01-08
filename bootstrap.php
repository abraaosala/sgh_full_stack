<?php

declare(strict_types=1); //

use App\controllers\ErrorPage;
use core\Router;

session_start(); //inicio de sessao

// Incluir Autoload de Classes
/* ======================================= */
require __DIR__ . "/vendor/autoload.php";

//DataZona Local 
/* ======================================= */
date_default_timezone_set(env('TIME_ZONE', 'Africa/Luanda')); // 

/* ======================================= */


/* ======================================= */
// Disponibilizar variavel de Ambiente 
safeEnv();

// Inicializar Eloquent ORM
(new App\library\Database)->init();

// Configurar o Paginator Resolver
Illuminate\Pagination\Paginator::currentPageResolver(function ($pageName = 'page') {
    $page = $_GET[$pageName] ?? 1;
    return filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1 ? (int) $page : 1;
});

/* ======================================= */




// require "phinx.php";

if (true) { // Force error display for debugging
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    /* 
    error_log("Você cometeu um erro!", E_ALL, "my-errors.log");
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('error_reporting', 0);
    // Captura erros leves

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        $caminho = $_SERVER['REQUEST_URI'] ?? '';

        if (in_array($errno, [E_NOTICE, E_WARNING, E_USER_NOTICE, E_USER_WARNING])) {
            if (str_contains((string) $caminho, '/error/500') === false) {
                header("Location: /error/500");
                exit;
            }
        }
    });
    */


    // Captura erros fatais no fim do script
    // register_shutdown_function(function () {
    //     $erro = error_get_last();
    //     if ($erro && in_array($erro['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
    //         (new ErrorPage)->in(500, $erro);
    //         exit;
    //     }
    // });
}


// Configurações do Sistema
require_once 'conf/Config.php';



/* ======================================= */

/* ======================================= */
if (env('APP_TEST', 'APP_TEST') == 'true') {
    require_once __DIR__ . "/tests/index.php";
    die();
}
