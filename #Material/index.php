<?php
declare(strict_types = 1); //

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
// Disponibilizar variavel de Ambiente 
safeEnv();

/* ======================================= */

// require "phinx.php";

if (env('APP_PRODUCTION', 'APP_PRODUCTION') === 'true') {

    error_log("Você cometeu um erro!", E_ALL, "my-errors.log");
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('error_reporting', 0);
    // Captura erros leves

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        $caminho = $_SERVER['REQUEST_URI'] ?? '';

        if (in_array($errno, [E_NOTICE, E_WARNING, E_USER_NOTICE, E_USER_WARNING])) {
            if (strpos($caminho, '/error/500') === false) {
                header("Location: /error/500");
                exit;
            }
        }
    });

    
    // Captura erros fatais no fim do script
    register_shutdown_function(function () {
        $erro = error_get_last();
        if ($erro && in_array($erro['type'], [E_ERROR, E_PARSE, E_core_ERROR, E_COMPILE_ERROR])) {
            (new ErrorPage)->in(500, $erro);
            exit;
        }
    });
}


// Configurações do Sistema
require_once 'conf/Config.php';



/* ======================================= */


/* ======================================= */
if (env('APP_TEST', 'APP_TEST') == 'true') {
    require_once __DIR__ . "/tests/index.php";
    die();
}

/* ======================================= */
// dd(new Router);
/* core da Aplicação */
router(); // -- 