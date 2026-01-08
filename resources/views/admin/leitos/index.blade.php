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
                            <i class="feather icon-bed"></i> Leitos
                        </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between">
                    <h2 class="page-header-title">Gestão de Leitos</h2>
                    <!-- Botão Adicionar -->
                    <a href="{{ lnk('admin/leito-criar') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                        <i class="ti ti-plus"></i> Novo Leito
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Tabela -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Número/Identificação</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Descrição</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leitos as $leito)
                    <tr>
                        <td>{{ $leito->id }}</td>
                        <td class="fw-bold">{{ $leito->numero }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $leito->tipo }}</span>
                        </td>
                        <td>
                            @if($leito->status == 'Disponível')
                            <span class="badge bg-success">Disponível</span>
                            @elseif($leito->status == 'Ocupado')
                            <span class="badge bg-danger">Ocupado</span>
                            @elseif($leito->status == 'Manutenção')
                            <span class="badge bg-warning text-dark">Manutenção</span>
                            @else
                            <span class="badge bg-secondary">{{ $leito->status }}</span>
                            @endif
                        </td>
                        {{-- <td>{{ \App\utils\Str::limit($leito->descricao, 50) }}</td> --}}
                        <td>{{ $leito->descricao }}</td>
                        <td class="text-center">
                            <a href="{{ root() }}admin/leito-editar/{{ $leito->id }}" class="btn btn-icon btn-link-warning" title="Editar">
                                <i class="ti ti-edit"></i>
                            </a>
                            <a href="{{ root() }}admin/leito-excluir/{{ $leito->id }}"
                                class="btn btn-icon btn-link-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este leito?')"
                                title="Excluir">
                                <i class="ti ti-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="ti ti-bed fs-2 d-block mb-2"></i>
                            Nenhum leito cadastrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection