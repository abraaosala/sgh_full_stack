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
                                    <a href="<?= lnk('admin/dashboard') ?>"><i class="feather icon-home"></i>
                                        Painel Hospitalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Gerenciar Usuários
                                </li>
                                <!--  <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Todos
                                </li> -->
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="page-header-title">Lista de Medicos</h2>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Exportar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/medico-export?type=pdf') ?>">PDF</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/medico-export?type=csv') ?>">CSV</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="<?= lnk('admin/medico-export?type=excel') ?>">Excel</a>
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

        <!-- Botão Adicionar Usuário -->
        <!-- Botão flutuante no canto inferior direito com estilo Mantis -->
        <div class="">
            <a href="<?= lnk('admin/medico-criar') ?>"
                class="btn btn-primary btn-sm rounded-circle shadow position-fixed d-flex pc-btn-float align-items-center justify-content-center"
                title="Adicionar Usuário">
                <i class="feather icon-plus"></i>
            </a>
        </div>

        <!-- Tabela de Usuários -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nivel</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicos as $i => $medico) { ?>
                        <tr>
                            <td class="text-center"><?php echo $i + $tools->firstItem(); ?></td>
                            <td class="text-center">
                                <img src="<?= avatar_url($medico->usuario->nome) ?>"
                                    alt="avatar" class="rounded-circle" width="40" height="40">
                            </td>
                            <td><?php echo htmlspecialchars((string) $medico->usuario->nome) ?? ''; ?>
                                <br>
                                <span>
                                    <?php echo htmlspecialchars((string) $medico->numero_ordem) ?? '' ?>
                                </span>
                                <br>
                                <span>
                                    <?php echo htmlspecialchars((string) $medico->especialidade->nome) ?? '' ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars((string) $medico->usuario->email) ?? ''; ?>
                            </td>
                            <td><?php echo htmlspecialchars((string) $medico->nivel) ?? ''; ?></td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="eye(<?php echo $medico->id; ?>)"><i class="feather icon-eye"></i></button>
                                <a href="<?= lnk('admin/medico-editar/' . $medico->id) ?>"
                                    class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                    <i class="feather icon-edit"></i>
                                </a>
                                <a href="<?= lnk('admin/medico-excluir/' . $medico->id) ?>"
                                    onclick="return confirm('Deseja realmente excluir este médico?')"
                                    class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="feather icon-trash-2"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (empty($medicos)) { ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Nenhum médico cadastrado.</td>
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

</div>
<!-- Modal de visualizar Medico -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visualizarModalLabel">
                    <i class="bi bi-person-circle me-2"></i> Detalhes do Medico
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
                        <div id="modalCarteira" class="text-muted mb-3">
                            <span class="">Numero não desponivel</span>
                        </div>

                        <!--  <a id="modalEditLink" href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil-square me-1"></i> Editar Perfil
                        </a> -->
                    </div>

                    <div class="col-md-8">
                        <h5 class="mb-3 text-primary"><i class="bi bi-person-lines-fill me-2"></i>Informações Pessoais
                        </h5>

                        <dl class="row">
                            <dt class="col-sm-4">Nome Completo:</dt>
                            <dd class="col-sm-8"><span id="modalNomeCompleto">Não informado</span></dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8"><span id="modalEmail">Não informado</span></dd>

                            <!-- <dt class="col-sm-4">Usuário:</dt>
                            <dd class="col-sm-8"><span id="modalUsername">Não informado</span></dd>
 -->
                            <!-- <dt class="col-sm-4">Perfil:</dt>
                            <dd class="col-sm-8"><span id="modalPerfil">Não informado</span></dd> -->
                        </dl>

                        <div id="detalhesProfissionais" class="">
                            <hr class="my-3">
                            <!-- <h5 class="mb-3 text-primary"><i class="bi bi-heart-pulse me-2"></i>Detalhes Profissionais
                            </h5> -->
                            <dl class="row">
                                <dt class="col-sm-4">Especialidade:</dt>
                                <dd class="col-sm-8"><span id="modalEspecialidade">Não informado</span></dd>

                                <dt class="col-sm-4">Nº da Ordem:</dt>
                                <dd class="col-sm-8"><span id="modalNumOrdem">Não informado</span></dd>

                                <dt class="col-sm-4">Nível:</dt>
                                <dd class="col-sm-8"><span id="modalNivel">Não informado</span></dd>

                                <dt class="col-sm-4">Hospital:</dt>
                                <dd class="col-sm-8"><span id="modalHospital">Não informado</span></dd>

                                <dt class="col-sm-4">Província:</dt>
                                <dd class="col-sm-8"><span id="modalProvincia">Não informado</span></dd>

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

        const response = await fetch(`/admin/medico/${id}`);
        const result = await response.json();
        // console.log(result);

        // Habilitar Modal
        const modal = new bootstrap.Modal(document.getElementById('visualizarModal'));
        modal.show();

        //Atribuir Dados no modal
        document.getElementById('modalNome').innerHTML = result.nome;
        document.getElementById('modalNome').innerHTML = result.nome;
        document.getElementById('modalCarteira').innerHTML = `<h5>${result.numero_ordem}</h5>`;
        document.getElementById('modalNomeCompleto').innerHTML = result.nome;
        document.getElementById('modalEmail').innerHTML = result.email;
        document.getElementById('modalEspecialidade').innerHTML = result.especialidade;
        document.getElementById('modalNumOrdem').innerHTML = result.numero_ordem;
        document.getElementById('modalNivel').innerHTML = result.nivel;
        document.getElementById('modalProvincia').innerHTML = result.provincia;
        document.getElementById('modalTelefone').innerHTML = result.telefone;
        /* document.getElementById('modalAvatar').innerHTML = `
        src = "https://ui-avatars.com/api/?name=${result.nome}&background=0D8ABC&color=fff&size=120"
        alt = "Avatar do Medico"
        class = "img-fluid rounded-circle shadow-sm mb-3" `; */




    }
</script>