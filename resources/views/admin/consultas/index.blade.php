@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}admin/dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Consultas</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-header-title">Gestão de Consultas</h2>
                    {{-- <a href="{{ root() }}admin/consulta-criar" class="btn btn-primary"><i class="feather icon-plus"></i> Nova Consulta</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Lista de Consultas Agendadas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="table-consultas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Data/Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($consultas as $consulta)
                            <tr>
                                <td>{{ $consulta->id }}</td>
                                <td>{{ $consulta->paciente->usuario->nome ?? 'N/A' }}</td>
                                <td>{{ $consulta->medico->usuario->nome ?? 'N/A' }}</td>
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
                                    <a href="{{ root() }}admin/consulta/{{ $consulta->id }}" class="btn btn-sm btn-info" title="Detalhes"><i class="feather icon-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhuma consulta encontrada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação se necessário -->
                {{-- {{ $consultas->links() }} --}}
            </div>
        </div>
    </div>
</div>
@endsection