<?php

declare(strict_types=1);

namespace App\Controllers\Enfermeiro;

use App\trait\View;

class UserController
{
    use View;
    public function index()
    {
        $idUser = (int) session()->get('id');

        // Stats
        $stats = [
            'totalLeitos' => \App\Models\Leito::count(),
            'leitosOcupados' => \App\Models\Leito::where('status', 'Ocupado')->count(),
            'leitosLivres' => \App\Models\Leito::where('status', 'Livre')->count(),
            'triagensHoje' => 0, // Placeholder
        ];

        // Recent Bed Activity
        $leitos = \App\Models\Leito::limit(5)->get();

        \App\library\View::render('enfermeiro.dashboard', globals([
            'title' => 'Painel de Enfermagem',
            'stats' => $stats,
            'leitos' => $leitos,
        ]));
    }
}
