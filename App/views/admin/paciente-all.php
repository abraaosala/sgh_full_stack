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
                                    <a href="<?php echo root(); ?>dashboard"><i class="feather icon-home"></i> Painel
                                        Hospitalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Gerenciar Pacientes
                                </li>
                                <!--  <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Todos
                                </li> -->
                            </ol>
                        </nav>
                        <h2 class="page-header-title">Lista de Pacientes</h2>
                    </div>
                </div>
            </div>
        </div>


        <!-- Mensagens de Sucesso, Erro e Aviso -->
        <?php echo flash('success'); ?>
        <?php echo flash('error'); ?>
        <?php echo flash('warning'); ?>

        <!-- Botão Adicionar Usuário -->
        <!-- Botão flutuante no canto inferior direito com estilo Mantis -->
        <div class="">
            <a href="<?php echo root(); ?>admin/paciente-cadastrar"
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
                        <th>Idade</th>
                        <th>Genero</th>
                        <th>Endereco</th>
                        <th>Contactos</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $i => $paciente) { ?>
                    <tr>
                        <td class="text-center"><?php echo $i+$tools->init + 1; ?></td>
                        <td class="text-center">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) $paciente->nome); ?>&background=17A2B8&color=fff&size=64"
                                alt="avatar" class="rounded-circle" width="40" height="40">
                        </td>
                        <td><?php echo htmlspecialchars((string) $paciente->nome); ?></td>
                        <td><?php echo htmlspecialchars((string) calcularIdade($paciente->data_nascimento)); ?></td>
                        <td><?php echo htmlspecialchars((string) $paciente->sexo); ?></td>
                        <td><?php echo htmlspecialchars((string) $paciente->endereco); ?></td>
                        <td><?php echo htmlspecialchars((string) $paciente->telefone); ?></td>
                        <td class="text-center">
                            <a href="<?php echo root(); ?>admin/paciente-editar/<?php echo $paciente->id; ?>"
                                class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                <i class="feather icon-edit"></i>
                            </a>
                            <a href="<?php echo root(); ?>admin/paciente-excluir/<?php echo $paciente->id; ?>"
                                onclick="return confirm('Deseja realmente excluir este usuário?')"
                                class="btn btn-sm btn-outline-danger" title="Excluir">
                                <i class="feather icon-trash-2"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if (empty($pacientes)) { ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Nenhum usuário cadastrado.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column gap-2 mt-3">
            <!-- Info (à esquerda) -->
            <div class="text-start">
                <?php echo str_replace('text-end', 'text-start', $tools->info ?? '') ?? ''; ?>
            </div>

            <!-- Paginação (centralizada corretamente) -->
            <div class="d-flex justify-content-center">
                <?php echo $tools->paginacao ?? ''; ?>
            </div>

        </div>


    </div>

</div>