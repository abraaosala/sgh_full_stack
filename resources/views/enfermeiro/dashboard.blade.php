@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Painel de Enfermagem</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}enfermeiro/home"><i class="feather icon-home"></i></a></li>
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
                        <h6 class="text-white mb-1">Total de Leitos</h6>
                        <h2 class="text-white mb-0">{{ $stats['totalLeitos'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-sidebar f-24"></i>
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
                        <h6 class="text-white mb-1">Ocupados</h6>
                        <h2 class="text-white mb-0">{{ $stats['leitosOcupados'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-user-minus f-24"></i>
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
                        <h6 class="text-white mb-1">Disponíveis</h6>
                        <h2 class="text-white mb-0">{{ $stats['leitosLivres'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-user-plus f-24"></i>
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
                        <h6 class="text-white mb-1">Triagens Hoje</h6>
                        <h2 class="text-white mb-0">{{ $stats['triagensHoje'] }}</h2>
                    </div>
                    <div class="p-3 bg-white bg-opacity-25 rounded">
                        <i class="feather icon-activity f-24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bed Status Table -->
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>Status dos Leitos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nº Leito</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leitos as $leito)
                            <tr>
                                <td>{{ $leito->numero }}</td>
                                <td>{{ $leito->tipo }}</td>
                                <td>
                                    <span class="badge bg-{{ $leito->status == 'Livre' ? 'success' : 'danger' }}">
                                        {{ $leito->status }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ root() }}admin/leito-editar/{{ $leito->id }}" class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhum leito cadastrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ root() }}enfermeiro/leitos" class="text-muted btn-link">Gerir todos os leitos</a>
            </div>
        </div>
    </div>
</div>
@endsection