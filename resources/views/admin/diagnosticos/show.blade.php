@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item"><a href="{{ lnk('admin/dashboard') }}">Painel</a></li>
                        <li class="breadcrumb-item"><a href="{{ lnk('admin/diagnosticos') }}">Diagnósticos</a></li>
                        <li class="breadcrumb-item active">Detalhes</li>
                    </ol>
                </nav>
                <h2 class="page-header-title">Detalhes do Diagnóstico #{{ $diagnostico->id }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-info-circle text-primary me-2"></i>Informações Clínicas</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label class="text-muted small text-uppercase fw-bold">Doença / Condição</label>
                        <p class="fs-5 text-dark fw-semibold">{{ $diagnostico->doenca->nome ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small text-uppercase fw-bold">Data do Diagnóstico</label>
                        <p class="fs-5 text-dark">{{ date('d/m/Y', strtotime($diagnostico->data_diagnostico)) }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold">Observações Médicas</label>
                    <div class="p-3 bg-light rounded border mt-1">
                        {{ $diagnostico->observacoes ?: 'Nenhuma observação registrada para este diagnóstico.' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label class="text-muted small text-uppercase fw-bold">Status Atual</label>
                        <div>
                            @php
                            $statusClass = match($diagnostico->status) {
                            'Ativo' => 'bg-danger',
                            'Tratamento' => 'bg-warning text-dark',
                            'Curado' => 'bg-success',
                            'Controlado' => 'bg-info',
                            default => 'bg-secondary'
                            };
                            @endphp
                            <span class="badge {{ $statusClass }} fs-6 px-3 py-2">{{ $diagnostico->status ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-user text-primary me-2"></i>Paciente</h5>
            </div>
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($diagnostico->paciente->usuario->nome ?? 'U') }}&background=0D8ABC&color=fff&size=80" class="rounded-circle mb-3 shadow-sm" alt="Avatar">
                <h5 class="mb-1">{{ $diagnostico->paciente->usuario->nome ?? 'N/A' }}</h5>
                <p class="text-muted mb-3">Código: {{ $diagnostico->paciente->code ?? 'N/A' }}</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1"><strong>Telefone:</strong> {{ $diagnostico->paciente->telefone ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Endereço:</strong> {{ $diagnostico->paciente->endereco ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-stethoscope text-primary me-2"></i>Responsável</h5>
            </div>
            <div class="card-body">
                <h6 class="mb-1">Dr(a). {{ $diagnostico->medico->usuario->nome ?? 'N/A' }}</h6>
                <p class="text-muted small mb-0">{{ $diagnostico->medico->especialidade->nome ?? 'Médico Geral' }}</p>
                <p class="text-muted small">Nº Ordem: {{ $diagnostico->medico->numero_ordem ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-2">
    <a href="{{ lnk('admin/diagnosticos') }}" class="btn btn-outline-secondary">
        <i class="ti ti-arrow-left"></i> Voltar para a Listagem
    </a>
</div>
@endsection