<?php

declare(strict_types=1);

namespace App\Controllers\Reception;

use App\trait\View;

class UserController
{
    use View;
    public function index(){
        $this->view(globals(),'dashboard');
    }
}