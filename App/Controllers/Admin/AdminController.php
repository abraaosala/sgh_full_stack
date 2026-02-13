<?php

namespace App\Controllers\Admin;

use App\Http\BaseController as Controller;
use App\library\View as LibraryView;

class AdminController
{
    protected $relatorioService;

    public function __construct()
    {
        $this->relatorioService = container(\App\Services\RelatorioService::class);
    }

    public function index()
    {
        $stats = $this->relatorioService->getGlobalStats();
        $recentConsultas = $this->relatorioService->getRecentConsultas(5);

        LibraryView::render('admin.dashboard', [
            'title' => 'Painel Administrativo',
            'stats' => $stats,
            'recentConsultas' => $recentConsultas,
            'dashboard' => true
        ]);
    }
}
