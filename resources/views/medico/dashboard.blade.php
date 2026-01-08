@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Olá, Dr(a). {{ $auth->nome }}</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}medico/home"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Painel Médico</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stats Cards (Following Admin Style) -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Meus Pacientes</h6>
                        <h2 class="text-white mb-0">{{ $stats['meusPacientes'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-users f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Total pacientes únicos</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Hoje</h6>
                        <h2 class="text-white mb-0">{{ $stats['atendimentosHoje'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-clock f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Atendimentos p/ hoje</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Próximos 7 dias</h6>
                        <h2 class="text-white mb-0">{{ $stats['proximosSeteDias'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-calendar f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Agenda da semana</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Este Mês</h6>
                        <h2 class="text-white mb-0">{{ $stats['atendimentosMes'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-activity f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Total consultas no mês</p>
            </div>
        </div>
    </div>

    <!-- Next Patient Highlight (Same Card Style as Admin Stats for consistency) -->
    @if($proximo)
    <div class="col-xl-4 col-md-12">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Próximo Atendimento</h6>
                        <h4 class="text-white mb-0 text-truncate" style="max-width: 200px;">{{ $proximo->paciente->usuario->nome }}</h4>
                        <p class="mt-2 mb-0">Hoje às {{ date('H:i', strtotime($proximo->marcacao)) }}</p>
                        <div class="mt-3">
                            <a href="{{ root() }}medico/atendimento/{{ $proximo->id }}" class="btn btn-sm btn-light text-info font-weight-bold">Iniciar Chamada</a>
                        </div>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-play-circle f-30"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-xl-4 col-md-12">
        <div class="card bg-light">
            <div class="card-body text-center py-4">
                <i class="feather icon-smile text-success f-30 mb-2 d-block"></i>
                <h6 class="mb-0">Sem atendimentos urgentes</h6>
                <p class="text-muted small mt-1">Agenda livre no momento.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Today's List (Table Style following Admin) -->
    <div class="col-xl-8 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Agenda de Hoje ({{ date('d/m/Y') }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Hora</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hoje as $consulta)
                            <tr>
                                <td>
                                    <h6 class="m-b-0">{{ $consulta->paciente->usuario->nome }}</h6>
                                </td>
                                <td>{{ date('H:i', strtotime($consulta->marcacao)) }}</td>
                                <td>
                                    @php
                                    $badgeClass = 'bg-light-primary text-primary';
                                    if($consulta->status == 'Em Atendimento') $badgeClass = 'bg-light-info text-info';
                                    if($consulta->status == 'Finalizada') $badgeClass = 'bg-light-success text-success';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $consulta->status }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ root() }}medico/atendimento/{{ $consulta->id }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="feather icon-play"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <p class="text-muted mb-0">Nenhum paciente agendado para hoje.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ root() }}medico/consultas" class="text-muted">Ver agenda completa</a>
            </div>
        </div>
    </div>
</div>
@endsection