@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}paciente/dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Minhas Consultas</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-header-title">Minhas Consultas</h2>
                    <a href="{{ root() }}paciente/consulta/criar" class="btn btn-primary"><i class="feather icon-plus"></i> Agendar Nova</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Histórico de Consultas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-consultas-paciente">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Médico</th>
                                <th>Especialidade</th>
                                <th>Data/Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($consultas as $consulta)
                            <tr>
                                <td>{{ $consulta->id }}</td>
                                <td>{{ $consulta->medico->usuario->nome ?? 'N/A' }}</td>
                                <td>{{ $consulta->medico->especialidade->nome ?? 'Clínico Geral' }}</td>
                                <td>
                                    {{ date('d/m/Y', strtotime($consulta->marcacao)) }} <br>
                                    <small>{{ date('H:i', strtotime($consulta->marcacao)) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $consulta->status == 'Realizada' ? 'success' : ($consulta->status == 'Cancelada' ? 'danger' : 'warning') }}">
                                        {{ $consulta->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ root() }}paciente/consulta/{{ $consulta->id }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="feather icon-eye"></i>
                                    </a>
                                    <a href="{{lnk("paciente/consulta/emitir/{$consulta->id}")}}" class="btn btn-sm btn-secondary js-print-consulta" data-id="{{ $consulta->id }}" title="Imprimir Ficha">
                                        <i class="feather icon-printer"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Você não possui consultas agendadas.</td>
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