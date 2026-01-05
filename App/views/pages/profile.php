<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2">
                                <li class="breadcrumb-item mx-2 ">
                                    <a href="<?= root() ?>admin/dashboard"><i class="feather icon-home mx-2 "></i>Painel
                                        Hospitalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-user"></i> Meu Perfil
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title">Meu Perfil</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <?= flash(['success', 'error', 'warning']) ?>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 p-4">
                    <div class="row g-0 align-items-center">
                        <!-- Coluna: Avatar -->
                        <div class="col-md-4 text-center border-end">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode((string) $auth->nome) ?>&background=0D8ABC&color=fff&size=120"
                                alt="Avatar" class="rounded-circle shadow mb-3" width="120" height="120">
                            <h4 class="mb-0"><?= htmlspecialchars((string) $auth->nome) ?></h4>
                            <small class="text-muted"><?= levelBadge($auth->perfil) ?></small>
                            <div class="mt-3">
                                <a href="<?= root() ?>editar-perfil" class="btn btn-sm btn-outline-primary">
                                    <i class="feather icon-edit"></i> Editar Perfil
                                </a>
                            </div>
                        </div>

                        <!-- Coluna: Informações -->
                        <div class="col-md-8">
                            <div class="p-3">
                                <h5 class="text-primary mb-3"><i class="feather icon-info"></i> Detalhes Pessoais</h5>
                                <div class="row mb-2">
                                    <div class="col-sm-4 text-muted">Nome Completo:</div>
                                    <div class="col-sm-8"><?= htmlspecialchars((string) $auth->nome) ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 text-muted">Email:</div>
                                    <div class="col-sm-8"><?= htmlspecialchars((string) $auth->email) ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 text-muted">Nome de Usuário:</div>
                                    <div class="col-sm-8">
                                        <?= (isset($auth->username)) ? htmlspecialchars($auth->username) : 'Indisponivel' ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 text-muted">Perfil:</div>
                                    <div class="col-sm-8"><?= htmlspecialchars(ucfirst((string) $auth->perfil)) ?></div>

                                    <!-- Dados extra baseado no perfil -->
                                    <!-- <?php if ($auth->perfil == 'medico'): ?>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Especialidade:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($perfilUser->especialidade ?? 'Não informado') ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Nº da Ordem:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($perfilUser->numero_ordem ?? 'Não informado') ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Nível:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($perfilUser->nivel ?? 'Não informado') ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Hospital:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($perfilUser->hospital ?? 'Não informado') ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Província:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($auth->provincia ?? 'Não informado') ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 text-muted">Telefone:</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($auth->telefone ?? 'Não informado') ?></div>
                                        </div>
                                    <?php endif ?> -->

                                </div>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- card -->
                </div> <!-- col -->
            </div> <!-- row -->

        </div>
    </div>
    <!-- [ Main Content ] end -->