@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Olá, {{ $auth->nome }}</h2>
                    <p class="text-muted">Bem-vindo ao seu portal de saúde.</p>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}paciente/home"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Área do Paciente</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Stats -->
    <div class="col-md-6 col-xl-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Minhas Consultas</h6>
                        <h2 class="text-white mb-0">{{ $stats['totalConsultas'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-calendar f-24"></i>
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
                        <h6 class="text-white mb-1">Médicos Consultados</h6>
                        <h2 class="text-white mb-0">{{ $stats['medicosVistos'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-user-check f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Appointment Highlight -->
    <div class="col-md-12 col-xl-6">
        @if($proxima)
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-1">Sua Próxima Consulta</h6>
                        <h4 class="text-white mb-0">Com Dr(a). {{ $proxima->medico->usuario->nome }}</h4>
                        <p class="mt-2 mb-0"><i class="feather icon-clock mr-1"></i> {{ date('d/m/Y \à\s H:i', strtotime($proxima->marcacao)) }}</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ root() }}paciente/consulta/{{ $proxima->id }}" class="btn btn-sm btn-light text-info mt-2">Ver Detalhes</a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card bg-light border-dashed">
            <div class="card-body d-flex align-items-center justify-content-between py-4">
                <div>
                    <h6 class="text-muted mb-1">Nenhuma consulta agendada</h6>
                    <p class="mb-0 small">Precisando de um médico?</p>
                </div>
                <a href="{{ root() }}paciente/consulta/criar" class="btn btn-primary btn-sm">Agendar Agora</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent History -->
    <div class="col-xl-8 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Histórico Recente</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Médico</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historico as $item)
                            <tr>
                                <td>Dr(a). {{ $item->medico->usuario->nome }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->marcacao)) }}</td>
                                <td>
                                    <span class="badge bg-light-secondary text-secondary">{{ $item->status }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ root() }}paciente/consulta/{{ $item->id }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="feather icon-file-text"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Você ainda não possui consultas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Ações Rápidas</h5>
            </div>
            <div class="card-body pt-2">
                <div class="d-grid gap-2">
                    <a href="{{ root() }}paciente/consulta/criar" class="btn btn-outline-primary text-start">
                        <i class="feather icon-plus-circle me-2"></i> Agendar Nova Consulta
                    </a>
                    <a href="{{ root() }}paciente/exames" class="btn btn-outline-info text-start">
                        <i class="feather icon-file-plus me-2"></i> Meus Exames
                    </a>
                    <a href="{{ root() }}paciente/prescricoes" class="btn btn-outline-success text-start">
                        <i class="feather icon-clipboard me-2"></i> Ver Prescrições
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection