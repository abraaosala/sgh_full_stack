<div class="pc-container">
    <div class="pc-content">

        <div class="page-header mb-3">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo root(); ?>admin/dashboard"><i class="feather icon-home"></i>
                                        Painel Hospitalar</a>
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


        <?php echo flash(['success', 'error', 'warning']); ?>

        <div class="">
            <div class="toolbar">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <form id="filter" class="row g-3 align-items-end">
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="q">Buscar</label>
                                <input type="search" id="q" class="form-control" placeholder="Usuario..." name="q"
                                    oninput="filtrarTabela()" />
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <a href="<?php echo root(); ?>admin/usuarios-criar"
                class="btn btn-primary btn-sm rounded-circle shadow position-fixed d-flex pc-btn-float align-items-center justify-content-center"
                title="Adicionar Usuário">
                <i class="feather icon-plus"></i>
            </a>
        </div>


        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap">
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
                    <?php foreach ($usuarios as $i => $usuario) { ?>
                    <tr>
                        <td class="text-center"><?php echo $i + 1; ?></td>
                        <td class="text-center">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) $usuario->nome); ?>&background=17A2B8&color=fff&size=64"
                                alt="avatar" class="rounded-circle" width="40" height="40">
                        </td>
                        <td><?php echo htmlspecialchars((string) $usuario->nome); ?></td>
                        <td><?php echo htmlspecialchars((string) $usuario->email); ?></td>
                        <td>
                            <?= levelBadge($usuario->perfil) ?>
                        </td>
                        <td class="text-center">
                            <?php if ($usuario->perfil != 'superadmin'): ?>
                            <a href="<?php echo root(); ?>admin/usuario-editar/<?php echo $usuario->id; ?>"
                                class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="feather icon-edit"></i>
                            </a>
                            <a href="<?php echo root(); ?>admin/user-excluir/<?php echo $usuario->id; ?>"
                                onclick="return confirm('Deseja realmente excluir este usuário?')"
                                class="btn btn-sm btn-outline-danger" title="Excluir">
                                <i class="feather icon-trash-2"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if (empty($usuarios)) { ?>
                    <tr id="linha-vazia-php">
                        <td colspan="7" class="text-center text-muted">Nenhum usuário cadastrado.</td>
                    </tr>
                    <?php } ?>

                    <tr id="linha-vazia-js" style="display: none;">
                        <td colspan="7" class="text-center text-muted">Nenhum usuário encontrado com o termo digitado.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column gap-2 mt-3">
            <div class="text-start">
                <?php echo str_replace('text-end', 'text-start', $tools->info); ?>
            </div>
            <div class="d-flex justify-content-center">
                <?php echo $tools->paginacao; ?>
            </div>
        </div>


    </div>

</div>

<script>
function filtrarTabela() {
    // 1. Obter o valor digitado (e formatar para busca não sensível a caso)
    const termoPesquisa = document.getElementById('q').value.toUpperCase();

    // 2. Obter referências à tabela e às linhas (tr)
    const tabelaBody = document.querySelector('.table-responsive table tbody');
    if (!tabelaBody) return;

    const linhas = tabelaBody.getElementsByTagName('tr');
    let resultadosEncontrados = 0;

    // Referência às mensagens de "vazio"
    const linhaVaziaPhp = document.getElementById('linha-vazia-php');
    const linhaVaziaJs = document.getElementById('linha-vazia-js');

    // Oculta a mensagem de "Nenhum usuário cadastrado" se ela existir
    if (linhaVaziaPhp) {
        linhaVaziaPhp.style.display = 'none';
    }

    // 3. Iterar sobre as linhas
    for (let i = 0; i < linhas.length; i++) {
        const linha = linhas[i];

        // Ignora as linhas de mensagem vazia (para não tentar filtrar nelas)
        if (linha.id === 'linha-vazia-php' || linha.id === 'linha-vazia-js') {
            continue;
        }

        // A célula do nome está na 3ª posição (índice 2)
        const celulaNome = linha.getElementsByTagName('td')[2];

        if (celulaNome) {
            const nomeUsuario = celulaNome.textContent || celulaNome.innerText;

            // 4. Comparar
            if (nomeUsuario.toUpperCase().indexOf(termoPesquisa) > -1) {
                linha.style.display = ""; // Exibe a linha
                resultadosEncontrados++;
            } else {
                linha.style.display = "none"; // Esconde a linha
            }
        }
    }

    // 5. Mostrar a mensagem apropriada se não houver resultados
    if (linhaVaziaJs) {
        if (resultadosEncontrados === 0) {
            linhaVaziaJs.style.display = ""; // Mostra a mensagem de "Nenhum usuário encontrado"
        } else {
            linhaVaziaJs.style.display = "none"; // Esconde a mensagem
        }
    }
}
</script>