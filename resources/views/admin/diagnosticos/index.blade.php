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
                            <a href="{{ lnk('admin/dashboard') }}"><i class="feather icon-home"></i> Painel Hospitalar</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="ti ti-stethoscope"></i> Diagnósticos
                        </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between">
                    <h2 class="page-header-title">Gestão de Diagnósticos</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabela -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Doença/Condição</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diagnosticos as $diagnostico)
                    <tr>
                        <td>{{ $diagnostico->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-dark">{{ $diagnostico->paciente->usuario->nome ?? 'N/A' }}</h6>
                                    <small class="text-muted">COD: {{ $diagnostico->paciente->code ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-dark">{{ $diagnostico->medico->usuario->nome ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border border-primary-subtle px-2 py-1">
                                {{ $diagnostico->doenca->nome ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            {{ date('d/m/Y', strtotime($diagnostico->data_diagnostico)) }}
                        </td>
                        <td>
                            @php
                                $statusClass = match($diagnostico->status) {
                                    'Ativo' => 'bg-danger',
                                    'Tratamento' => 'bg-warning text-dark',
                                    'Curado' => 'bg-success',
                                    'Controlado' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $diagnostico->status ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ lnk('admin/diagnostico/' . $diagnostico->id) }}" class="btn btn-icon btn-link-primary" title="Ver Detalhes">
                                <i class="ti ti-eye"></i>
                            </a>
                            <a href="{{ lnk('admin/diagnostico-excluir/' . $diagnostico->id) }}"
                               class="btn btn-icon btn-link-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este registro de diagnóstico?')"
                               title="Excluir">
                                <i class="ti ti-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="ti ti-report-medical fs-1 d-block mb-3 opacity-25"></i>
                            <p class="mb-0">Nenhum diagnóstico registrado no sistema.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
