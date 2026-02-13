@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}admin/dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}admin/consultas">Consultas</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Detalhes da Consulta</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-header-title">Consulta #{{ $consulta->id }}</h2>
                    <a href="{{ root() }}admin/consultas" class="btn btn-secondary btn-sm"><i class="feather icon-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="feather icon-info me-2 text-primary"></i> Informações Gerais</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">Status da Consulta</label>
                        <div>
                            <span class="badge bg-{{ $consulta->status == 'Realizada' ? 'success' : ($consulta->status == 'Cancelada' ? 'danger' : 'warning') }} fs-6">
                                {{ $consulta->status }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">Data e Hora Agendada</label>
                        <div class="fw-bold fs-5">
                            <i class="feather icon-calendar me-1"></i> {{ date('d/m/Y', strtotime($consulta->marcacao)) }}
                            <span class="text-primary ms-2"><i class="feather icon-clock me-1"></i> {{ date('H:i', strtotime($consulta->marcacao)) }}</span>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="p-3 bg-light rounded">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-2">Observações / Motivo</label>
                            <p class="mb-0">{{ $consulta->observacao ?? 'Nenhuma observação registrada para esta consulta.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="feather icon-user me-2 text-primary"></i> Detalhes do Paciente</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-parent me-3">
                        <img src="{{ avatar_url($consulta->paciente->usuario->nome ?? 'Paciente') }}" class="rounded-circle border" width="64" alt="Paciente">
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-primary">{{ $consulta->paciente->usuario->nome ?? 'Paciente não identificado' }}</h4>
                        <p class="text-muted mb-0"><i class="feather icon-mail me-1"></i> {{ $consulta->paciente->usuario->email ?? 'Sem e-mail' }}</p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">ID do Paciente</label>
                        <p class="fw-semibold">#{{ $consulta->paciente->id }}</p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">Telefone</label>
                        <p class="fw-semibold">{{ $consulta->paciente->telefone ?? 'Não informado' }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ root() }}admin/paciente/{{ $consulta->paciente->id }}" class="btn btn-outline-primary btn-sm">Ver Perfil Completo</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4 text-center">
            <div class="card-header bg-white py-3 text-start">
                <h5 class="mb-0 fw-bold"><i class="feather icon-activity me-2 text-primary"></i> Médico Responsável</h5>
            </div>
            <div class="card-body py-4">
                <img src="{{ avatar_url($consulta->medico->usuario->nome ?? 'Medico') }}" class="rounded-circle border mb-3" width="80" alt="Médico">
                <h5 class="fw-bold mb-1 text-primary">{{ $consulta->medico->usuario->nome ?? 'Médico não atribuído' }}</h5>
                <p class="badge bg-light text-primary border border-primary-subtle px-3 py-2 mb-3">
                    {{ $consulta->medico->especialidade->nome ?? 'Sem especialidade' }}
                </p>
                <div class="text-start border-top pt-3">
                    <div class="mb-2">
                        <label class="text-muted small fw-bold text-uppercase d-block">Número da Ordem</label>
                        <span>{{ $consulta->medico->numero_ordem ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <a href="{{ root() }}admin/medico/{{ $consulta->medico->id }}" class="btn btn-sm btn-link p-0">Ver Detalhes do Médico</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="feather icon-settings me-2 text-primary"></i> Ações Administrativas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-warning btn-sm" disabled><i class="feather icon-edit"></i> Remarcar Consulta</button>
                    <button class="btn btn-outline-danger btn-sm" disabled><i class="feather icon-x-circle"></i> Cancelar Consulta</button>
                    <hr>
                    <button class="btn btn-light btn-sm text-start" onclick="window.print()"><i class="feather icon-printer me-2"></i> Imprimir Comprovante</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection