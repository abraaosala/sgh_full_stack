@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Detalhes da Consulta</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}paciente/home"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ root() }}paciente/consultas">Minhas Consultas</a></li>
                    <li class="breadcrumb-item active">#{{ $consulta->id }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Informações Gerais</h5>
                <span class="badge {{ $consulta->status == 'Finalizada' ? 'bg-success' : ($consulta->status == 'Cancelada' ? 'bg-danger' : 'bg-primary') }}">
                    {{ $consulta->status }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Médico:</div>
                    <div class="col-sm-8">Dr(a). {{ $consulta->medico->usuario->nome }} ({{ $consulta->medico->especialidade->nome }})</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Data/Hora:</div>
                    <div class="col-sm-8">{{ date('d/m/Y \à\s H:i', strtotime($consulta->marcacao)) }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Observações/Notas:</div>
                    <div class="col-sm-8">{{ $consulta->observacao ?? 'Nenhuma observação informada.' }}</div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ root() }}paciente/consulta/emitir/{{ $consulta->id }}" class="btn btn-outline-info" target="_blank">
                    <i class="feather icon-printer me-2"></i>Imprimir Ficha
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header">
                <h5>Precisa de ajuda?</h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">Caso deseje cancelar esta consulta ou tenha alguma dúvida, entre em contato com a nossa recepção.</p>
                <a href="#" class="btn btn-block btn-secondary disabled">Solicitar Cancelamento</a>
            </div>
        </div>
    </div>
</div>
@endsection