<?php

namespace App\Services;

use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Leito;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;

class RelatorioService extends AbstractService
{
    public function getGlobalStats(): array
    {
        return [
            'total_pacientes' => Paciente::count(),
            'total_medicos'   => Medico::count(),
            'total_usuarios'  => User::count(),
            'total_consultas' => Consulta::count(),
            'total_leitos'    => Leito::count(),
            'leitos_disponiveis' => Leito::where('status', 'Disponível')->count(),
        ];
    }

    public function getDashboardStats($year, $month): array
    {
        // Base query for appointments
        $appointmentsQuery = Consulta::whereYear('marcacao', $year);
        if ($month) {
            $appointmentsQuery->whereMonth('marcacao', $month);
        }

        // Base query for patients
        $patientsQuery = Paciente::whereYear('criado_em', $year);
        if ($month) {
            $patientsQuery->whereMonth('criado_em', $month);
        }

        // Base query for doctors
        $medicosQuery = Medico::whereHas('usuario', function ($q) use ($year, $month) {
            $q->whereYear('criado_em', $year);
            if ($month) {
                $q->whereMonth('criado_em', $month);
            }
        });

        return [
            'total_pacientes' => $patientsQuery->count(),
            'total_medicos'   => $medicosQuery->count(),
            'total_consultas' => $appointmentsQuery->count(),
            'consultas_hoje'  => Consulta::whereDate('marcacao', date('Y-m-d'))->count(),
            'leitos_total'    => Leito::count(),
            'leitos_ocupados' => Leito::where('status', '!=', 'Disponível')->count(),
        ];
    }

    public function getConsultasPorStatus($year, $month)
    {
        $query = Consulta::select('status', DB::raw('count(*) as total'))
            ->whereYear('marcacao', $year);

        if ($month) {
            $query->whereMonth('marcacao', $month);
        }

        return $query->groupBy('status')->get();
    }

    public function getPacientesPorMes($year)
    {
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

    public function getConsultasPorEspecialidade($year, $month)
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

    public function getTopMedicos($year, $month)
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

    public function getGeneroDistribuicao()
    {
        return User::select('genero', DB::raw('count(*) as total'))
            ->whereIn('perfil', ['paciente', 'medico', 'admin'])
            ->groupBy('genero')
            ->get();
    }

    public function getRecentConsultas(int $limit = 5)
    {
        return Consulta::with(['paciente.usuario', 'medico.usuario'])
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }
}
