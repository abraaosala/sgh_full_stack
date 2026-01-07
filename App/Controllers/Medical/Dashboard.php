<?php 

namespace App\Controllers\Medical;

use App\trait\View;

class Dashboard  {
    use View;
    
    public function index (){
        
        $this->view(
         globals([
            'title' => 'Painel do Medico',
            'count' => 0,
            'count_consultas' => 0
         ]), 'pages.dashboard');  
    }
}