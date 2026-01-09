@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ lnk('admin/dashboard') }}"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Relatórios Gerenciais</li>
                    </ol>
                </nav>
                <h2 class="page-header-title">Relatórios & Insights</h2>
                <p class="text-muted">Análise detalhada de desempenho e ocupação hospitalar.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-outline-primary btn-sm me-2" onclick="window.print()">
                    <i class="feather icon-printer me-1"></i> Imprimir Relatório
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ lnk('admin/relatorios') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase">Ano de Referência</label>
                <select name="year" class="form-select form-select-sm shadow-none border-light focus-ring">
                    @foreach($filters['years'] as $y)
                    <option value="{{ $y }}" {{ $filters['year'] == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase">Mês de Referência</label>
                <select name="month" class="form-select form-select-sm shadow-none border-light focus-ring">
                    <option value="">O Ano Todo</option>
                    @foreach($filters['months'] as $num => $name)
                    <option value="{{ $num }}" {{ $filters['month'] == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="feather icon-filter me-1"></i> Aplicar Filtros
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Resumo em Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <h6 class="text-muted mb-1 small">Pacientes</h6>
                <div class="d-flex align-items-center">
                    <h3 class="mb-0 me-2">{{ $stats['total_pacientes'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <h6 class="text-muted mb-1 small">Médicos</h6>
                <h3 class="mb-0">{{ $stats['total_medicos'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 bg-primary text-white">
            <div class="card-body p-3">
                <h6 class="text-white-50 mb-1 small">Consultas no Período</h6>
                <div class="d-flex align-items-center">
                    <h3 class="mb-0 text-white me-2">{{ $stats['total_consultas'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3">
                <h6 class="text-muted mb-1 small">Consultas Hoje</h6>
                <h3 class="mb-0 text-success">{{ $stats['consultas_hoje'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-body p-3 position-relative">
                <h6 class="text-muted mb-1 small">Ocupação de Leitos</h6>
                <h3 class="mb-0">{{ $stats['leitos_ocupados'] }}/{{ $stats['leitos_total'] }}</h3>
                <div class="progress mt-2" style="height: 6px;">
                    @php $p = $stats['leitos_total'] > 0 ? ($stats['leitos_ocupados'] / $stats['leitos_total']) * 100 : 0; @endphp
                    <div class="progress-bar bg-warning" style="width: {{ $p }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Consultas por Especialidade -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                <h5 class="card-title mb-0">Demanda por Especialidade</h5>
                <small class="text-muted">Top 5 mais procuradas</small>
            </div>
            <div class="card-body p-4">
                <div style="height:280px"><canvas id="especialidadeChart"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Gênero dos Pacientes -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="card-title mb-0">Perfil de Gênero</h5>
            </div>
            <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                <div style="height: 200px; width: 100%;">
                    <canvas id="generoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Crescimento e Status -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="card-title mb-0">Crescimento de Pacientes (Anual)</h5>
            </div>
            <div class="card-body p-4">
                <div style="height:200px"><canvas id="pacientesChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="card-title mb-0">Eficiência de Agendamento</h5>
            </div>
            <div class="card-body p-4">
                <div style="height:200px"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Rankings -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="card-title mb-0">Top Médicos (Atendimentos)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4">Médico</th>
                                <th class="border-0 text-center">Consultas</th>
                                <th class="border-0 text-end px-4">Impacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_medicos as $m)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="wid-30 hei-30 rounded-circle bg-light-primary text-primary d-flex align-items-center justify-content-center me-2">
                                            {{ substr($m->nome, 0, 1) }}
                                        </div>
                                        <span class="fw-semibold">{{ $m->nome }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $m->total }}</td>
                                <td class="text-end px-4">
                                    @php $perc = $stats['total_consultas'] > 0 ? ($m->total / $stats['total_consultas']) * 100 : 0; @endphp
                                    <span class="text-muted small">{{ round($perc, 1) }}%</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Nenhum dado disponível</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Atividades Recentes -->
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Atividade Recente</h5>
            </div>
            <div class="card-body p-4">
                <div class="recent-feed">
                    @forelse($recent_consultas as $rc)
                    <div class="d-flex mb-3 pb-3 border-bottom border-light">
                        <div class="flex-shrink-0">
                            <i class="feather icon-check-circle text-success fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 small fw-bold">{{ $rc->paciente->usuario->nome ?? 'Paciente' }}</h6>
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Consulta com Dr. {{ $rc->medico->usuario->nome ?? 'Médico' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted small">Sem atividades recentes.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js\plugins\apexcharts.min.js', true)}}"></script>

<script>
    Chart.defaults.font.family = "'Public Sans', sans-serif";
    Chart.defaults.color = "#6c757d";

    // Especialidade Chart
    const espLabels = {
        !!json_encode(array_column(isset($consultas_por_especialidade) ? $consultas_por_especialidade - > toArray() : [], 'nome')) !!
    };
    const espData = {
        !!json_encode(array_column(isset($consultas_por_especialidade) ? $consultas_por_especialidade - > toArray() : [], 'total')) !!
    };

    if (espLabels.length && document.getElementById('especialidadeChart')) {
        new Chart(document.getElementById('especialidadeChart'), {
            type: 'bar',
            data: {
                labels: espLabels,
                datasets: [{
                    label: 'Volume de Consultas',
                    data: espData,
                    backgroundColor: '#0d6efd',
                    hoverBackgroundColor: '#0b5ed7',
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Genero Chart
    const genData = {
        !!json_encode(isset($genero_distribuicao) ? $genero_distribuicao - > toArray() : []) !!
    };
    if (genData.length && document.getElementById('generoChart')) {
        new Chart(document.getElementById('generoChart'), {
            type: 'doughnut',
            data: {
                labels: genData.map(g => g.genero || 'N/A'),
                datasets: [{
                    data: genData.map(g => g.total),
                    backgroundColor: ['#0d6efd', '#d63384', '#6c757d', '#ffc107', '#198754'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Pacientes Chart
    const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const dataPacientes = new Array(12).fill(0);
    @if(isset($pacientes_por_mes) && count($pacientes_por_mes) > 0)
    @foreach($pacientes_por_mes as $item)
    @if(isset($item -> mes) && (int) $item ->mes >= 1 && (int) $item -> mes <= 12)
    dataPacientes[{
        {
            (int) $item->mes - 1
        }
    }] = {
        {
            (int) $item-> total ?? 0
        }
    };
    @endif
    @endforeach
    @endif

    if (document.getElementById('pacientesChart')) {
        new Chart(document.getElementById('pacientesChart'), {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Novos Pacientes',
                    data: dataPacientes,
                    borderColor: '#6610f2',
                    backgroundColor: 'rgba(102, 16, 242, 0.05)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Status Chart
    const statusData = {
        !!json_encode(isset($consultas_por_status) ? $consultas_por_status - > toArray() : []) !!
    };
    if (statusData.length && document.getElementById('statusChart')) {
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: statusData.map(s => s.status),
                datasets: [{
                    data: statusData.map(s => s.total),
                    backgroundColor: ['#ffc107', '#198754', '#dc3545', '#0dcaf0', '#6c757d'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 10,
                            padding: 10
                        }
                    }
                }
            }
        });
    }
</script>

<style>
    .focus-ring:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }

    .bg-light-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-light-success {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }

    @media print {

        .pc-sidebar,
        .card.mb-4,
        .btn-sm {
            display: none !important;
        }

        .pc-container {
            margin: 0 !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #eee !important;
        }
    }
</style>
@endsection