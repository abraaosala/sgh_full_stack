<?php

namespace App\Controllers\Reception;

use App\Dao\Models\Paciente;
use App\Dao\Models\User as Usuario;
use App\Http\BaseController as Controller;
use App\trait\TemplateView;

class RecepcaoController
{

      use TemplateView;

      public function __invoke()
      {
            $this->view(globals(), 'pages.dashboard');
      }

      public function pacienteSearch(){
            $this->view(globals(), 'recepcao.pacientes');
      }

      public function api($params)
      {
            header(API);
            $nome = sanitizeInput($params[ 'nome']);

            $pacientes= new Paciente()

            ->select()
            ->join(Usuario::class, 'pacientes.usuario_id','=','usuarios.id')
            ->like('nome',$nome)
            ->toArray();

            foreach ($pacientes as $key => $value) {
                  $pacientes[$key]['idade'] = calcularIdade($value['data_nascimento']); 
                  // $pacientes[$key]['ano'] = $value->data_nascimento;
            }

      //      dd($pacientes);

           echo json_encode($pacientes);
      }
}