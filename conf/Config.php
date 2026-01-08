<?php


require_once "db.php";
//Namespeces de Controller

/**
 * NAMESPACE DO CONTROLLER
 */
define('CONTROLLER', 'App\\controllers\\');



define('ROOT', dirname(__DIR__));
define('VIEW', ROOT . "/app/views/");
define('IMG', root() . '/public/img/');

// define('HELPER', ROOT."/app/helpers/");
define('HELPER', ROOT . "/app/helpers/");


//DOMIN
define('DOMINIO', 'localhost');
define('PATH', '/school-simple/');
define('SISTEM_URL', "http://" . DOMINIO . PATH);

//PATH
// define('ROOT', __DIR__);
define('CONTROLLER_PATH', ROOT . "/app/controllers");
define('STORE_PATH', ROOT . "/store/");
define('ASSETS', 'assets/');

define('MENU', VIEW . 'menus/');








/* Definaçao da Aplicação 
ou constantes da aplicaçao

 */
define('APP', [
    'NAME' => 'Sistema de Gerenciamento Hospitalar',
    'VERSION' => "1.0.1",
    'DEVOLOPER' => 'salaab',
    // 'FULL_NAME' => env('APP_FULL_NAME', 'Sistema de Gerenciamento Hospitalar')
]);

define('HOSPITAL', [
    'name' => 'Hospital Municipal do Soyo',
    'street' => 'Rua a Direita ',
    'nif' => 54843900,
    'tel' => "(+244) 9xx xxx xxx (+244) 9xx xxx xxx",
    'email' => 'contact@hms.com'
]);


/**
 * CONST CHAVE SECRETA DO TOKEN
 */
define('TOKEN_KEY', 'alaSOaarbA');



//TODO: CONSTANTES PARA NAMESPACES
define("NAMESPACE_ENTITY", "App\\Dao\\Entity\\");
define("NAMESPACE_MODEL", "App\\Dao\\Models\\");
define("NAMESPACE_CONTROLLER", "App\\Controllers\\");

/* FIXME */
define('API', 'Content-Type: application/json');

/**
 * ROTAS DA APLICAÇÃO
 */
define('ROUTE_LOGIN', 'login');
define('ROUTE_ADMIN_HOME', 'admin');
define('ROUTE_MEDICO_HOME', 'medico/home');
define('ROUTE_ENFERMEIRO_HOME', 'enfermeiro/home');
define('ROUTE_RECEPCAO_HOME', 'recepcao/home');
define('ROUTE_PACIENTE_HOME', 'paciente/home');
define('ROUTE_ERROR_500', 'error/500');
define('ROUTE_PROFILE_EDIT', 'editar-perfil');
define('ROUTE_PROFILE_VIEW', 'meu-perfil');
define('ROUTE_ADMIN_USERS', 'admin/usuarios');
define('ROUTE_ADMIN_USERS_CREATE', 'admin/usuarios-criar');
