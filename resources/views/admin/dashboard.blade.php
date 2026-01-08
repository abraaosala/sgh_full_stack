@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Dashboard</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}admin"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Painel de Controle</li>
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
                        <h6 class="text-white mb-1">Usuários</h6>
                        <h2 class="text-white mb-0">{{ $stats['usuarios'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-users f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Total no sistema</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Médicos</h6>
                        <h2 class="text-white mb-0">{{ $stats['medicos'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-user f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Corpo clínico registrado</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Pacientes</h6>
                        <h2 class="text-white mb-0">{{ $stats['pacientes'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-heart f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Pacientes cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Consultas</h6>
                        <h2 class="text-white mb-0">{{ $stats['consultas'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-calendar f-24"></i>
                    </div>
                </div>
                <p class="m-t-15 mb-0">Total de atendimentos</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Atividade Recente (Últimas Consultas)</h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-end">
                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Data/Hora</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentConsultas as $consulta)
                            <tr>
                                <td>
                                    <div class="d-inline-block align-middle">
                                        <div class="d-inline-block">
                                            <h6 class="m-b-0">{{ $consulta->paciente->usuario->nome }}</h6>
                                            <p class="m-b-0 text-muted">ID: #{{ $consulta->paciente->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $consulta->medico->usuario->nome }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($consulta->marcacao)) }}</td>
                                <td>
                                    @php
                                    $badgeClass = 'bg-light-primary text-primary';
                                    if($consulta->status == 'Cancelada') $badgeClass = 'bg-light-danger text-danger';
                                    if($consulta->status == 'Finalizada') $badgeClass = 'bg-light-success text-success';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $consulta->status }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ root() }}admin/consulta/{{ $consulta->id }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="feather icon-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Nenhuma consulta recente encontrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ root() }}admin/consultas" class="text-muted btn-link">Ver todas as consultas</a>
            </div>
        </div>
    </div>
</div>
@endsection