<?php

namespace App\Controllers\Patient;

use App\Http\BaseController as Controller;
use App\trait\TemplateView;

class UserController
{
     use TemplateView;

     /**
      * Métodos específicos para o controladores pacienteuser podem ser adicionados aqui.
      *
      * Exemplo:
      *
      * public function acao($params)
      * {
      *      $this->render([componentes], data([variaveis disponiveis na view]));
      *  
      *  
      *  
      * }
      */

     // Métodos padrão de controllers RESTful
     public function index()
     {
          $idUser = (int) session()->get('id');
          $paciente = \App\Models\Paciente::where('usuario_id', $idUser)->first();

          if (!$paciente) {
               redirect('/logout');
          }

          // Estatísticas
          $stats = [
               'totalConsultas' => \App\Models\Consulta::where('paciente_id', $paciente->id)->count(),
               'medicosVistos'  => \App\Models\Consulta::where('paciente_id', $paciente->id)
                    ->distinct('medico_id')
                    ->count('medico_id'),
          ];

          // Próxima Consulta
          $proxima = \App\Models\Consulta::with(['medico.usuario'])
               ->where('paciente_id', $paciente->id)
               ->where('marcacao', '>', date('Y-m-d H:i:s'))
               ->where('status', 'Agendada')
               ->orderBy('marcacao', 'asc')
               ->first();

          // Histórico Recente
          $historico = \App\Models\Consulta::with(['medico.usuario'])
               ->where('paciente_id', $paciente->id)
               ->orderBy('marcacao', 'desc')
               ->limit(5)
               ->get();

          \App\library\View::render('paciente.dashboard', globals([
               'title' => 'Painel do Paciente',
               'stats' => $stats,
               'proxima' => $proxima,
               'historico' => $historico
          ]));
     }

     //Resultado do Exames
     public function exames()
     {
          $this->view(globals(), 'pacientes.exames');
     }

     public function prescricoes()
     {
          $this->view(globals(), 'pacientes.prescricoes');
     }
}
