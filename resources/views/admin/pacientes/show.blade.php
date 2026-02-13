@extends('layouts.admin')

@section('content')
<!-- Breadcrumb -->
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}admin/pacientes"><i class="feather icon-users"></i> Pacientes</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Perfil do Paciente
                        </li>
                    </ol>
                </nav>
                <h2 class="page-header-title">Perfil do Paciente</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Coluna Esquerda: Informações do Paciente -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($paciente->usuario->nome) }}&background=0D8ABC&color=fff&size=120"
                    alt="Avatar" class="img-fluid rounded-circle mb-3 shadow">
                <h4 class="mb-1">{{ $paciente->usuario->nome }}</h4>
                <p class="text-muted mb-3">{{ $paciente->code }}</p>

                <div class="d-flex justify-content-center gap-2 mb-4">
                    <a href="mailto:{{ $paciente->usuario->email }}" class="btn btn-outline-primary btn-sm"><i class="feather icon-mail"></i> Email</a>
                    <a href="tel:{{ $paciente->telefone }}" class="btn btn-outline-success btn-sm"><i class="feather icon-phone"></i> Ligar</a>
                </div>

                <ul class="list-group list-group-flush text-start">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="feather icon-calendar me-2 text-primary"></i> Nascimento</span>
                        <span class="fw-semibold">
                            {{ $paciente->usuario->data_nascimento ? date('d/m/Y', strtotime($paciente->usuario->data_nascimento)) : 'N/A' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="feather icon-map-pin me-2 text-primary"></i> Província</span>
                        <span class="fw-semibold">{{ $paciente->provincia->nome ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="feather icon-user me-2 text-primary"></i> Gênero</span>
                        <span class="fw-semibold">{{ genero($paciente->usuario->genero) }}</span>
                    </li>
                    <li class="list-group-item px-0">
                        <span class="d-block mb-1"><i class="feather icon-home me-2 text-primary"></i> Endereço</span>
                        <small class="text-muted">{{ $paciente->endereco }}</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Abas de Informações -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-transparent border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="consultas-tab" data-bs-toggle="tab" href="#consultas" role="tab">
                            <i class="feather icon-calendar me-2"></i> Consultas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="diagnosticos-tab" data-bs-toggle="tab" href="#diagnosticos" role="tab">
                            <i class="feather icon-activity me-2"></i> Diagnósticos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="historico-tab" data-bs-toggle="tab" href="#historico" role="tab">
                            <i class="feather icon-file-text me-2"></i> Histórico Clínico
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="profileTabContent">

                    <!-- Aba Consultas -->
                    <div class="tab-pane fade show active" id="consultas" role="tabpanel">
                        @if($paciente->consultas && $paciente->consultas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data</th>
                                        <th>Médico</th>
                                        <th>Motivo</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paciente->consultas as $consulta)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ date('d/m/Y', strtotime($consulta->marcacao)) }}</div>
                                            <small class="text-muted">{{ date('H:i', strtotime($consulta->marcacao)) }}</small>
                                        </td>
                                        <td>{{ $consulta->medico->usuario->nome ?? 'N/A' }}</td>
                                        <td>{{ $consulta->motivo ?? 'Consulta de Rotina' }}</td>
                                        <td>
                                            @php
                                            $badge = 'bg-secondary';
                                            if($consulta->status == 'Agendada') $badge = 'bg-primary';
                                            if($consulta->status == 'Realizada') $badge = 'bg-success';
                                            if($consulta->status == 'Cancelada') $badge = 'bg-danger';
                                            @endphp
                                            <span class="badge rounded-pill {{ $badge }}">{{ $consulta->status }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="feather icon-calendar display-6 mb-3"></i>
                            <p>Nenhuma consulta registrada.</p>
                        </div>
                        @endif
                    </div>

                    <!-- Aba Diagnósticos -->
                    <div class="tab-pane fade" id="diagnosticos" role="tabpanel">
                        @if($paciente->diagnosticos && $paciente->diagnosticos->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($paciente->diagnosticos as $diag)
                            <div class="list-group-item px-0 py-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 text-danger">{{ $diag->doenca->nome ?? 'Doença não especificada' }}</h5>
                                    <small>{{ date('d/m/Y', strtotime($diag->data_diagnostico)) }}</small>
                                </div>
                                <p class="mb-1 text-muted">{{ $diag->observacoes }}</p>
                                <small class="text-secondary">Médico: {{ $diag->medico->usuario->nome ?? 'N/A' }}</small>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="feather icon-activity display-6 mb-3"></i>
                            <p>Nenhum diagnóstico registrado.</p>
                        </div>
                        @endif
                    </div>

                    <!-- Aba Histórico -->
                    <div class="tab-pane fade" id="historico" role="tabpanel">
                        @if($paciente->historicos && $paciente->historicos->count() > 0)
                        <ul class="timeline">
                            @foreach($paciente->historicos as $hist)
                            <li class="pb-3 border-bottom mb-3">
                                <p class="mb-1 text-dark fw-semibold">{{ date('d/m/Y', strtotime($hist->data_registro)) }}</p>
                                <p class="text-muted m-0">{!! nl2br(e($hist->descricao)) !!}</p>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="feather icon-file-text display-6 mb-3"></i>
                            <p>Nenhum histórico registrado.</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection