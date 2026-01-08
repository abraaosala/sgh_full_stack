@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Painel de Recepção</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}recepcao"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stat Cards -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Pacientes</h6>
                        <h2 class="text-white mb-0">{{ $stats['totalPacientes'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-users f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">C. Hoje</h6>
                        <h2 class="text-white mb-0">{{ $stats['consultasHoje'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-calendar f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Amanhã</h6>
                        <h2 class="text-white mb-0">{{ $stats['consultasAmanha'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-clock f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Médicos</h6>
                        <h2 class="text-white mb-0">{{ $stats['medicosAtivos'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-user f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Search Card -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Busca Rápida de Paciente</h5>
                <form action="{{ root() }}recepcao/pacientes" method="GET" class="mt-3">
                    <div class="input-group">
                        <input type="text" name="nome" class="form-control" placeholder="Digite o nome do paciente para buscar...">
                        <button class="btn btn-primary" type="submit"><i class="feather icon-search"></i> Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Current Appointments for Check-in -->
    <div class="col-xl-8 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Próximos Atendimentos (Check-in)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Hora</th>
                                <th class="text-end">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proximas as $consulta)
                            <tr>
                                <td>{{ $consulta->paciente->usuario->nome }}</td>
                                <td>Dr(a). {{ $consulta->medico->usuario->nome }}</td>
                                <td>{{ date('H:i', strtotime($consulta->marcacao)) }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-info">Check-in</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhuma consulta agendada para hoje.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reception Actions -->
    <div class="col-xl-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Ações de Recepção</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ root() }}recepcao/paciente/cadastrar" class="btn btn-outline-primary text-start">
                        <i class="feather icon-user-plus me-2"></i> Novo Cadastro Paciente
                    </a>
                    <a href="{{ root() }}admin/agenda" class="btn btn-outline-info text-start">
                        <i class="feather icon-calendar me-2"></i> Ver Agenda Geral
                    </a>
                    <a href="{{ root() }}recepcao/pacientes" class="btn btn-outline-success text-start">
                        <i class="feather icon-list me-2"></i> Listar Todos Pacientes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection