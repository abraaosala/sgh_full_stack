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

class RelatorioController extends BaseController
{
    public function index()
    {
        try {
            $year = $_GET['year'] ?? date('Y');
            $month = $_GET['month'] ?? null;

            // Simplified statistics
            $stats = [
                'total_pacientes' => Paciente::count(),
                'total_medicos'   => Medico::count(),
                'total_consultas' => Consulta::whereYear('marcacao', $year)->count(),
                'consultas_hoje'  => Consulta::whereDate('marcacao', date('Y-m-d'))->count(),
                'leitos_total'    => Leito::count(),
                'leitos_ocupados' => Leito::where('status', '!=', 'Disponível')->count(),
            ];

            $data = [
                'title' => 'Relatórios Gerenciais',
                'filters' => [
                    'year' => $year,
                    'month' => $month,
                    'years' => range(date('Y'), date('Y') - 5),
                    'months' => [
                        1 => 'Janeiro',
                        2 => 'Fevereiro',
                        3 => 'Março',
                        4 => 'Abril',
                        5 => 'Maio',
                        6 => 'Junho',
                        7 => 'Julho',
                        8 => 'Agosto',
                        9 => 'Setembro',
                        10 => 'Outubro',
                        11 => 'Novembro',
                        12 => 'Dezembro'
                    ]
                ],
                'stats' => $stats,
                'consultas_por_status' => $this->getConsultasPorStatus($year, $month),
                'pacientes_por_mes' => $this->getPacientesPorMes($year),
                'consultas_por_especialidade' => $this->getConsultasPorEspecialidade($year, $month),
                'top_medicos' => $this->getTopMedicos($year, $month),
                'genero_distribuicao' => $this->getGeneroDistribuicao(),
                'recent_consultas' => Consulta::with(['paciente.usuario', 'medico.usuario'])
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->get(),
            ];

            return $this->view(globals($data), 'admin.relatorios.index');
        } catch (\Exception $e) {
            dd("Erro no Relatório: " . $e->getMessage() . " em " . $e->getFile() . ":" . $e->getLine());
        }
    }

    private function getConsultasPorStatus($year, $month)
    {
        $query = Consulta::select('status', DB::raw('count(*) as total'))
            ->whereYear('marcacao', $year);

        if ($month) {
            $query->whereMonth('marcacao', $month);
        }

        return $query->groupBy('status')->get();
    }

    private function getPacientesPorMes($year)
    {
        // SQL-Agnostic simple month aggregation
        $results = DB::table('usuarios')
            ->where('perfil', 'paciente')
            ->whereYear('criado_em', $year)
            ->select(DB::raw('substr(criado_em, 6, 2) as mes'), DB::raw('count(*) as total'))
            ->groupBy('mes')
            ->get();

        return $results->map(function ($item) {
            $item->mes = (int) $item->mes;
            return $item;
        });
    }

    private function getConsultasPorEspecialidade($year, $month)
    {
        $query = DB::table('consultas')
            ->join('medicos', 'consultas.medico_id', '=', 'medicos.id')
            ->join('especialidades', 'medicos.especialidade_id', '=', 'especialidades.id')
            ->select('especialidades.nome', DB::raw('count(*) as total'))
            ->whereYear('consultas.marcacao', $year);

        if ($month) {
            $query->whereMonth('consultas.marcacao', $month);
        }

        return $query->groupBy('especialidades.nome')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
    }

    private function getTopMedicos($year, $month)
    {
        $query = DB::table('consultas')
            ->join('medicos', 'consultas.medico_id', '=', 'medicos.id')
            ->join('usuarios', 'medicos.usuario_id', '=', 'usuarios.id')
            ->select('usuarios.nome', DB::raw('count(*) as total'))
            ->whereYear('consultas.marcacao', $year);

        if ($month) {
            $query->whereMonth('consultas.marcacao', $month);
        }

        return $query->groupBy('usuarios.nome')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
    }

    private function getGeneroDistribuicao()
    {
        return User::select('genero', DB::raw('count(*) as total'))
            ->whereIn('perfil', ['paciente', 'medico', 'admin'])
            ->groupBy('genero')
            ->get();
    }

    // Required by BaseController
    public function show($params) {}
    public function create() {}
    public function store() {}
    public function edit($params) {}
    public function update($params) {}
    public function delete($params) {}
}
