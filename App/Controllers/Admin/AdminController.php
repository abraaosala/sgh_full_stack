<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;

use App\trait\View;




class AdminController
{

  use View;

  // Métodos padrão de controllers RESTful
  public function index()
  {
    $stats = [
      'pacientes' => \App\Models\Paciente::count(),
      'medicos'   => \App\Models\Medico::count(),
      'usuarios'  => \App\Models\User::count(),
      'consultas' => \App\Models\Consulta::count(),
    ];

    $recentConsultas = \App\Models\Consulta::with(['paciente.usuario', 'medico.usuario'])
      ->orderBy('id', 'desc')
      ->limit(5)
      ->get();

    \App\library\View::render('admin.dashboard', globals([
      'title' => 'Painel Administrativo',
      'stats' => $stats,
      'recentConsultas' => $recentConsultas,
      'dashboard' => true
    ]));
  }
}
