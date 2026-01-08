<?php

namespace App\Controllers\Reception;

use App\Dao\Models\Paciente;
use App\Dao\Models\User as Usuario;
use App\Http\BaseController as Controller;
use App\trait\TemplateView;

class RecepcaoController
{

      use TemplateView;

      public function index()
      {
            // Stats para Recepção
            $stats = [
                  'totalPacientes' => \App\Models\Paciente::count(),
                  'consultasHoje' => \App\Models\Consulta::whereDate('marcacao', date('Y-m-d'))->count(),
                  'consultasAmanha' => \App\Models\Consulta::whereDate('marcacao', date('Y-m-d', strtotime('+1 day')))->count(),
                  'medicosAtivos' => \App\Models\Medico::count(),
            ];

            // Próximas consultas para facilitar check-in
            $proximas = \App\Models\Consulta::with(['paciente.usuario', 'medico.usuario'])
                  ->whereDate('marcacao', date('Y-m-d'))
                  ->orderBy('marcacao', 'asc')
                  ->limit(10)
                  ->get();

            \App\library\View::render('recepcao.dashboard', globals([
                  'title' => 'Painel de Recepção',
                  'stats' => $stats,
                  'proximas' => $proximas
            ]));
      }

      public function pacienteSearch()
      {
            $this->view(globals(), 'recepcao.pacientes');
      }

      public function api($params)
      {
            header(API);
            $nome = sanitizeInput($params['nome']);

            $pacientes = (new Paciente())
                  ->select()
                  ->join(Usuario::class, 'pacientes.usuario_id', '=', 'usuarios.id')
                  ->like('nome', $nome)
                  ->toArray();

            foreach ($pacientes as $key => $value) {
                  $pacientes[$key]['idade'] = calcularIdade($value['data_nascimento']);
                  // $pacientes[$key]['ano'] = $value->data_nascimento;
            }

            //      dd($pacientes);

            echo json_encode($pacientes);
      }
}
