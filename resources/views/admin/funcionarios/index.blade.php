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

<!-- Filtro e Pesquisa -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ lnk('admin/funcionarios') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-9">
                <label class="form-label small fw-bold text-uppercase">Pesquisar Funcionário</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="feather icon-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control form-control-sm border-start-0 shadow-none focus-ring" 
                           placeholder="Pesquisar por nome..." value="{{ $_GET['search'] ?? '' }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="feather icon-filter me-1"></i> Filtrar
                    </button>
                    @if(isset($_GET['search']) && $_GET['search'] !== '')
                        <a href="{{ lnk('admin/funcionarios') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="feather icon-x"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
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
                            <button type="button" onclick="eye({{ $usuario->id }})" class="btn btn-icon btn-link-primary" title="Visualizar">
                                <i class="feather icon-eye"></i>
                            </button>
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

<!-- Modal de visualizar Funcionário -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white" id="visualizarModalLabel">
                    <i class="feather icon-user me-2"></i> Detalhes do Funcionário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center border-md-end">
                        <img id="modalAvatar" src="https://ui-avatars.com/api/?name=User&background=17A2B8&color=fff&size=120"
                            alt="Avatar" class="img-fluid rounded-circle shadow mb-3" />
                        <h4 id="modalNome" class="mb-1">Nome do Funcionário</h4>
                        <div id="modalPerfil" class="badge bg-light text-dark fs-6 mt-2">Perfil: -</div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-uppercase text-muted small fw-bold mb-3">Informações Pessoais</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">Email:</dt>
                            <dd class="col-sm-8" id="modalEmail">-</dd>

                            <dt class="col-sm-4 text-muted">Gênero:</dt>
                            <dd class="col-sm-8" id="modalGenero">-</dd>

                            <dt class="col-sm-4 text-muted">Nascimento:</dt>
                            <dd class="col-sm-8" id="modalNascimento">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function eye(id) {
        try {
            const response = await fetch(`{{ lnk('admin/funcionario/') }}${id}?json=1`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();

            if (result.error) {
                alert(result.error);
                return;
            }

            const modal = new bootstrap.Modal(document.getElementById('visualizarModal'));

            document.getElementById('modalNome').innerHTML = result.nome;
            document.getElementById('modalEmail').innerHTML = result.email;
            document.getElementById('modalGenero').innerHTML = result.genero;
            document.getElementById('modalNascimento').innerHTML = result.data_nascimento;
            document.getElementById('modalPerfil').innerHTML = `Perfil: ${result.perfil}`;
            document.getElementById('modalAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(result.nome)}&background=17A2B8&color=fff&size=120`;

            modal.show();
        } catch (error) {
            console.error('Erro ao buscar dados do funcionário:', error);
            alert('Não foi possível carregar as informações do funcionário.');
        }
    }
</script>
@endsection