<?php

namespace App\Controllers\Admin;

use App\Http\BaseController;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Especialidade;
use App\Models\User;
use App\Models\Leito;
use Illuminate\Database\Capsule\Manager as DB;
use App\trait\DocumentExport;

use App\Services\RelatorioService;

class RelatorioController extends BaseController
{
    use DocumentExport;

    protected RelatorioService $relatorioService;

    public function __construct()
    {           
        $this->relatorioService = container(RelatorioService::class);
    }

    public function index()
    {
        try {
            $year = $_GET['year'] ?? date('Y');
            $month = isset($_GET['month']) && $_GET['month'] !== '' ? $_GET['month'] : null;

            $data = [
                'title' => 'Relatórios Gerenciais',
                'filters' => [
                    'year' => $year,
                    'month' => $month,
                    'years' => range(date('Y'), date('Y') - 5),
                    'months' => [
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 
                        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 
                        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                    ]
                ],
                'stats' => $this->relatorioService->getDashboardStats($year, $month),
                'consultas_por_status' => $this->relatorioService->getConsultasPorStatus($year, $month),
                'pacientes_por_mes' => $this->relatorioService->getPacientesPorMes($year),
                'consultas_por_especialidade' => $this->relatorioService->getConsultasPorEspecialidade($year, $month),
                'top_medicos' => $this->relatorioService->getTopMedicos($year, $month),
                'genero_distribuicao' => $this->relatorioService->getGeneroDistribuicao(),
                'recent_consultas' => $this->relatorioService->getRecentConsultas(5),
            ];

            return $this->view(globals($data), 'admin.relatorios.index');
        } catch (\Exception $e) {
            dd("Erro no Relatório: " . $e->getMessage());
        }
    }

    // Required by BaseController
    public function show($params) {}
    public function create() {}
    public function store() {}
    public function edit($params) {}
    public function update($params) {}
    public function delete($params) {}

    public function exporte()
    {
        $type = sanitizeInput($_GET['type'] ?? 'pdf');
        $year = $_GET['year'] ?? date('Y');
        $month = isset($_GET['month']) && $_GET['month'] !== '' ? $_GET['month'] : null;

        $stats = $this->relatorioService->getDashboardStats($year, $month);

        $data = [
            'view' => 'document.relatorios',
            'data' => [
                'title' => 'Relatórios Gerenciais',
                'stats' => $stats,
                'filters' => ['year' => $year, 'month' => $month],
                'consultas_por_status' => $this->relatorioService->getConsultasPorStatus($year, $month),
                'pacientes_por_mes' => $this->relatorioService->getPacientesPorMes($year),
                'consultas_por_especialidade' => $this->relatorioService->getConsultasPorEspecialidade($year, $month),
                'top_medicos' => $this->relatorioService->getTopMedicos($year, $month),
                'genero_distribuicao' => $this->relatorioService->getGeneroDistribuicao(),
                'hospital' => HOSPITAL,
                'date' => date('d/m/Y H:i')
            ],
            'nome_arquivo' => "relatorio_gerencial_" . date('YmdHis'),
            'download' => false,
            'model' => [
                ['Indicador', 'Valor'],
                ['Total Pacientes', $stats['total_pacientes']],
                ['Total Médicos', $stats['total_medicos']],
                ['Consultas no Período', $stats['total_consultas']],
                ['Consultas Hoje', $stats['consultas_hoje']],
                ['Leitos Ocupados', $stats['leitos_ocupados'] . '/' . $stats['leitos_total']]
            ]
        ];

        $this->export($data, $type);
    }
}
