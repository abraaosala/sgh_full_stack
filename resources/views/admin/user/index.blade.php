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
                            <a href="{{ lnk('admin/dashboard') }}">
                                <i class="feather icon-home"></i> Painel Hospitalar
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="feather icon-users"></i> Gerenciar Usuários
                        </li>
                    </ol>
                </nav>
                <h2 class="page-header-title">Lista de Usuários</h2>
            </div>
        </div>
    </div>
</div>

<!-- Flash -->
<div class="row">
    <div class="col-12">
        {!! flash(['success', 'error', 'warning']) !!}
    </div>
</div>

<!-- Filtro -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <form id="filter" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label" for="q">Buscar</label>
                <input type="search"
                       id="q"
                       class="form-control"
                       placeholder="Usuário..."
                       name="q"
                       oninput="filtrarTabela()" />
            </div>
        </form>
    </div>
</div>

<!-- Botão Adicionar -->
<a href="{{ lnk('admin/usuarios-criar') }}"
   class="btn btn-primary btn-sm rounded-circle shadow position-fixed d-flex pc-btn-float align-items-center justify-content-center"
   title="Adicionar Usuário"
   style="z-index:1020;">
    <i class="feather icon-plus"></i>
</a>

<!-- Tabela -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Perfil</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($usuarios as $i => $usuario)
                    <tr>
                        <td class="text-center">
                            {{ $i + $tools->firstItem() }}
                        </td>

                        <td class="text-center">
                            <img src="{{ avatar_url($usuario->nome, '17A2B8') }}"
                                 alt="avatar"
                                 class="rounded-circle"
                                 width="40"
                                 height="40">
                        </td>

                        <td>{{ $usuario->nome }}</td>
                        <td>{{ $usuario->email }}</td>

                        <td>
                            {!! levelBadge($usuario->perfil) !!}
                        </td>

                        <td class="text-center">
                            @if($usuario->perfil != 'superadmin')
                                <a href="{{ lnk('admin/usuario-editar/' . $usuario->id) }}"
                                   class="btn btn-icon btn-link-warning"
                                   title="Editar">
                                    <i class="feather icon-edit"></i>
                                </a>

                                <a href="{{ lnk('admin/user-excluir/' . $usuario->id) }}"
                                   onclick="return confirm('Deseja realmente excluir este usuário?')"
                                   class="btn btn-icon btn-link-danger"
                                   title="Excluir">
                                    <i class="feather icon-trash-2"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="linha-vazia-php">
                        <td colspan="6" class="text-center py-5 text-muted">
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>
                    @endforelse

                    <tr id="linha-vazia-js" style="display:none;">
                        <td colspan="6" class="text-center text-muted">
                            Nenhum usuário encontrado com o termo digitado.
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Paginação -->
<div class="d-flex flex-column gap-2 mt-3">
    <div class="text-start text-muted small">
        Mostrando {{ $tools->firstItem() }} a {{ $tools->lastItem() }} de {{ $tools->total() }} registros
    </div>
    <div class="d-flex justify-content-center">
        {!! paginate_links($tools) !!}
    </div>
</div>

@endsection

@section('scripts')
<script>
function filtrarTabela() {
    const termoPesquisa = document.getElementById('q').value.toUpperCase();
    const tabelaBody = document.querySelector('.table-responsive table tbody');
    if (!tabelaBody) return;

    const linhas = tabelaBody.getElementsByTagName('tr');
    let resultadosEncontrados = 0;

    const linhaVaziaPhp = document.getElementById('linha-vazia-php');
    const linhaVaziaJs = document.getElementById('linha-vazia-js');

    if (linhaVaziaPhp) linhaVaziaPhp.style.display = 'none';

    for (let i = 0; i < linhas.length; i++) {
        const linha = linhas[i];

        if (linha.id === 'linha-vazia-php' || linha.id === 'linha-vazia-js') {
            continue;
        }

        const celulaNome = linha.getElementsByTagName('td')[2];

        if (celulaNome) {
            const nomeUsuario = celulaNome.textContent || celulaNome.innerText;

            if (nomeUsuario.toUpperCase().indexOf(termoPesquisa) > -1) {
                linha.style.display = "";
                resultadosEncontrados++;
            } else {
                linha.style.display = "none";
            }
        }
    }

    if (linhaVaziaJs) {
        linhaVaziaJs.style.display = resultadosEncontrados === 0 ? "" : "none";
    }
}
</script>
@endsection