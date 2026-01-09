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
                            <i class="feather icon-users"></i> Gerenciar Funcionários
                        </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-header-title">Equipe Hospitalar</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Messages -->
<div class="row">
    <div class="col-12">
        {!! flash(['success', 'error', 'warning']) !!}
    </div>
</div>

<!-- Botão Adicionar -->
<div class="">
    <a href="{{ lnk('admin/funcionario-criar') }}" class="btn btn-primary btn-sm rounded-circle shadow position-fixed d-flex pc-btn-float align-items-center justify-content-center" title="Adicionar Funcionário" style="z-index: 1020;">
        <i class="feather icon-plus"></i>
    </a>
</div>

<!-- Tabela -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Avatar</th>
                        <th>Nome Funcionário</th>
                        <th>E-mail</th>
                        <th>Perfil / Função</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $i => $usuario)
                    <tr>
                        <td class="text-center">{{ $i + $tools->firstItem() }}</td>
                        <td class="text-center">
                            <img src="{{ avatar_url($usuario->nome, '17A2B8') }}" alt="avatar" class="rounded-circle" width="40" height="40">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $usuario->nome }}</div>
                        </td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            {!! levelBadge($usuario->perfil) !!}
                        </td>
                        <td class="text-center">
                            @if($usuario->perfil != 'superadmin')
                            <a href="{{ lnk('admin/usuario-editar/' . $usuario->id) }}" class="btn btn-icon btn-link-warning" title="Editar">
                                <i class="feather icon-edit"></i>
                            </a>
                            <a href="{{ lnk('admin/user-excluir/' . $usuario->id) }}" class="btn btn-icon btn-link-danger" onclick="return confirm('Deseja realmente excluir este funcionário?')" title="Excluir">
                                <i class="feather icon-trash-2"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <p class="mb-0">Nenhum funcionário cadastrado no sistema.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex flex-column gap-2 mt-3">
    <div class="text-start text-muted small">
        Mostrando {{ $tools->firstItem() }} a {{ $tools->lastItem() }} de {{ $tools->total() }} registros
    </div>
    <div class="d-flex justify-content-center">
        {!! paginate_links($tools) !!}
    </div>
</div>
@endsection