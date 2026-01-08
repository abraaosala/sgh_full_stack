@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}medico/dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Minhas Consultas</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-header-title">Minhas Consultas</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Agenda de Consultas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-consultas-medico">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paciente</th>
                                <th>Data/Hora</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($consultas as $consulta)
                            <tr>
                                <td>{{ $consulta->id }}</td>
                                <td>
                                    {{ $consulta->paciente->usuario->nome ?? 'N/A' }} <br>
                                    <small class="text-muted">{{ $consulta->paciente->usuario->genero ?? '' }}</small>
                                </td>
                                <td>
                                    {{ date('d/m/Y', strtotime($consulta->marcacao)) }} <br>
                                    <small>{{ date('H:i', strtotime($consulta->marcacao)) }}</small>
                                </td>
                                <td>{{ $consulta->tipo ?? 'Consulta Regular' }}</td>
                                <td>
                                    <span class="badge bg-{{ $consulta->status == 'Realizada' ? 'success' : ($consulta->status == 'Cancelada' ? 'danger' : 'warning') }}">
                                        {{ $consulta->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ root() }}medico/consulta/{{ $consulta->id }}" class="btn btn-sm btn-primary" title="Atender">
                                        <i class="feather icon-play-circle"></i> Atender
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhuma consulta agendada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection