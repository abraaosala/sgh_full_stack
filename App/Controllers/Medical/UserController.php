<?php

namespace App\controllers\Medical;

use App\classes\Session;
use App\Dao\Models\Consulta;
use App\Dao\Models\Paciente;
use App\Dao\Models\User;
use App\Http\BaseController as Controller;


//Controlado do Usuario com Perfil Medico /medico
class UserController extends Controller
{

   public function dashboard()
   {
      $idUser = (int) session()->get('id');
      // Usando helper ou consulta direta para pegar o perfil do médico
      $medico = \App\Models\Medico::where('usuario_id', $idUser)->first();

      if (!$medico) {
         redirect('/logout');
      }

      // Estatísticas
      $stats = [
         'meusPacientes' => \App\Models\Consulta::where('medico_id', $medico->id)
            ->distinct('paciente_id')
            ->count('paciente_id'),

         'proximosSeteDias' => \App\Models\Consulta::where('medico_id', $medico->id)
            ->where('marcacao', '>=', date('Y-m-d H:i:s'))
            ->where('marcacao', '<=', date('Y-m-d H:i:s', strtotime('+7 days')))
            ->count(),

         'atendimentosHoje' => \App\Models\Consulta::where('medico_id', $medico->id)
            ->whereDate('marcacao', date('Y-m-d'))
            ->count(),

         'atendimentosMes' => \App\Models\Consulta::where('medico_id', $medico->id)
            ->whereMonth('marcacao', date('m'))
            ->whereYear('marcacao', date('Y'))
            ->count(),
      ];

      // Agenda de Hoje
      $hoje = \App\Models\Consulta::with(['paciente.usuario'])
         ->where('medico_id', $medico->id)
         ->whereDate('marcacao', date('Y-m-d'))
         ->orderBy('marcacao', 'asc')
         ->get();

      // Próximo Paciente
      $proximo = \App\Models\Consulta::with(['paciente.usuario'])
         ->where('medico_id', $medico->id)
         ->where('marcacao', '>', date('Y-m-d H:i:s'))
         ->where('status', 'Agendada')
         ->orderBy('marcacao', 'asc')
         ->first();

      \App\library\View::render('medico.dashboard', globals([
         'title' => 'Painel do Médico',
         'stats' => $stats,
         'hoje' => $hoje,
         'proximo' => $proximo
      ]));
   }

   // Métodos padrão de controllers RESTful
   public function index()
   {

      //Consultar O perfil

      // Painel Administrativo 
      $this->view(
         [
            'title' => 'Painel do Medico',
            'count' => 0,
            'count_consultas' => 0
         ],
         'pages.dashboard'
      );
   }

   public function show($params)
   {

      // Exibir recurso específico

   }

   public function create()
   {
      // criar novo recurso
   }

   public function store()
   {

      // Salvar novo recurso

   }

   public function edit($params)
   {

      // Editar recurso existente

   }

   public function update($params)
   {

      // Atualizar recurso existente
   }

   public function delete($params)
   {

      // Deletar recurso
   }

   public function list() {}
}
