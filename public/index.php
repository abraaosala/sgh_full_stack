<?php

use core\Router;

require_once "../bootstrap.php"; 


//Route 
require ROOT."/routes/web.php";
require ROOT."/core/web.php";


/* ======================================= */
// dd(new Router);
/* core da Aplicação */



router(new Router); 