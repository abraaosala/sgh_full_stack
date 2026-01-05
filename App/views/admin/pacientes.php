<div class="pc-container">
    <div class="pc-content">

        <!-- Breadcrumb -->
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
                                    <i class="feather icon-users"></i> Gerenciar Pacientes
                                </li>
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="page-header-title">Lista de Pacientes</h2>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Exportar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/paciente-export?type=pdf') ?>">PDF</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/paciente-export?type=csv') ?>">CSV</a></li>
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/paciente-export?type=excel') ?>">Excel</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensagens de Sucesso, Erro e Aviso -->
        <?php echo flash(['success', 'error', 'warning']); ?>

        <!-- Botão Adicionar Paciente -->
        <div class="">
            <a href="<?php echo root(); ?>admin/paciente-criar"
                class="btn btn-primary btn-sm rounded-circle shadow position-fixed d-flex pc-btn-float align-items-center justify-content-center"
                title="Adicionar Paciente">
                <i class="feather icon-plus"></i>
            </a>
        </div>

        <!-- Tabela de Pacientes -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $i => $paciente) { ?>
                        <tr>
                        <tr>
                            <td class="text-center"><?php echo $i + $tools->firstItem(); ?></td>
                            <td class="text-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) ($paciente->usuario->nome ?? 'User')); ?>&background=6f42c1&color=fff&size=64"
                                    alt="avatar" class="rounded-circle" width="40" height="40">
                            </td>
                            <td><?php echo htmlspecialchars((string) ($paciente->usuario->nome ?? '')); ?></td>
                            <td><?php echo htmlspecialchars((string) ($paciente->usuario->email ?? '')); ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->usuario->data_nascimento); ?></td>
                            <td><?php echo genero(htmlspecialchars((string) ($paciente->usuario->genero ?? ''))); ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->telefone) ?? ''; ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="eye(<?php echo $paciente->id; ?>)"><i class="feather icon-eye"></i></button>
                                <a href="<?php echo root(); ?>admin/paciente-editar/<?php echo $paciente->id; ?>"
                                    class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                    <i class="feather icon-edit"></i>
                                </a>
                                <a href="<?php echo root(); ?>admin/paciente-excluir/<?php echo $paciente->id; ?>"
                                    onclick="return confirm('Deseja realmente excluir este paciente?')"
                                    class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="feather icon-trash-2"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (empty($pacientes)) { ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Nenhum paciente cadastrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column gap-2 mt-3">
            <!-- Info (à esquerda) -->
            <div class="text-start">
                Mostrando <?php echo $tools->firstItem(); ?> a <?php echo $tools->lastItem(); ?> de <?php echo $tools->total(); ?> registros
            </div>

            <!-- Paginação (centralizada corretamente) -->
            <div class="d-flex justify-content-center">
                <?php echo paginate_links($tools); ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal de visualizar Paciente -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visualizarModalLabel">
                    <i class="bi bi-person-circle me-2"></i> Detalhes do Paciente
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 align-items-center">

                    <div class="col-md-4 text-center border-md-end">
                        <img id="modalAvatar"
                            src="https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff&size=120"
                            alt="Avatar do Usuário" class="img-fluid rounded-circle shadow-sm mb-3" />

                        <h4 id="modalNome" class="mb-1">Nome do Usuário</h4>
                        <div id="modalCod" class="text-muted mb-3">
                            <span class="">Numero não desponivel</span>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <h5 class="mb-3 text-primary"><i class="bi bi-person-lines-fill me-2"></i>Informações Pessoais
                        </h5>

                        <dl class="row">
                            <dt class="col-sm-4">Nome Completo:</dt>
                            <dd class="col-sm-8"><span id="modalNomeCompleto">Não informado</span></dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8"><span id="modalEmail">Não informado</span></dd>
                        </dl>

                        <div id="detalhesProfissionais" class="">
                            <hr class="my-3">
                            <dl class="row">
                                <dt class="col-sm-4">Codigo :</dt>
                                <dd class="col-sm-8"><span id="modalCode">Não informado</span></dd>
                                <dt class="col-sm-4">Província:</dt>
                                <dd class="col-sm-8"><span id="modalProv">Não informado</span></dd>
                                <dt class="col-sm-4">Telefone:</dt>
                                <dd class="col-sm-8"><span id="modalTelefone">Não informado</span></dd>
                            </dl>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function eye(id) {

        const response = await fetch(`/admin/paciente/${id}`);
        const result = await response.json();
        // console.log(result);

        // Habilitar Modal
        const modal = new bootstrap.Modal(document.getElementById('visualizarModal'));
        modal.show();

        //Atribuir Dados no modal
        document.getElementById('modalNome').innerHTML = result.nome;
        document.getElementById('modalCod').innerHTML = `<h5>${result.code}</h5>`;
        document.getElementById('modalNomeCompleto').innerHTML = result.nome;
        document.getElementById('modalEmail').innerHTML = result.email;
        document.getElementById('modalCode').innerHTML = result.code;
        document.getElementById('modalProv').innerHTML = result.provincia;
        document.getElementById('modalTelefone').innerHTML = result.telefone;
        /* document.getElementById('modalAvatar').innerHTML = `
        src = "https://ui-avatars.com/api/?name=${result.nome}&background=0D8ABC&color=fff&size=120"
        alt = "Avatar do Paciente"
        class = "img-fluid rounded-circle shadow-sm mb-3" `; */




    }
</script>