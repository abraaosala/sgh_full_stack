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
                            <td><?php echo $paciente->usuario->data_nascimento ? date('d/m/Y', strtotime($paciente->usuario->data_nascimento)) : 'Não informado'; ?></td>
                            <td><?php echo genero(htmlspecialchars((string) ($paciente->usuario->genero ?? ''))); ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->telefone) ?? ''; ?></td>
                            <td class="text-center">
                                <a href="<?php echo root(); ?>admin/paciente/<?php echo $paciente->id; ?>" class="btn btn-sm btn-outline-primary me-1"
                                    title="Ver Perfil"><i class="feather icon-eye"></i></a>
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