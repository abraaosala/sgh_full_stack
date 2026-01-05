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
                                <li class="breadcrumb-item">
                                    <a href="/dashboard"><i class="feather icon-home"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-user"></i> Perfil Social
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title mb-4">Perfil Social</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <?= flash('success') ?>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 p-4">
                    <div class="row g-0 align-items-center">
                        <!-- Avatar -->
                        <div class="col-md-4 text-center border-end">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode((string) $auth->nome) ?>&background=0D8ABC&color=fff&size=150"
                                alt="Avatar"
                                class="rounded-circle shadow mb-3"
                                width="150"
                                height="150">
                            <h4 class="mb-0"><?= htmlspecialchars((string) $auth->nome) ?></h4>
                            <small class="text-muted"><?= htmlspecialchars((string) $auth->perfil->nome) ?></small>

                            <!-- Social buttons -->
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill me-1">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm rounded-pill me-1">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="col-md-8">
                            <div class="p-3">
                                <h5 class="text-primary mb-3"><i class="feather icon-user"></i> Informações Pessoais</h5>
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
                                    <div class="col-sm-8"><?= htmlspecialchars((string) $auth->username) ?></div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-4 text-muted">Perfil:</div>
                                    <div class="col-sm-8"><?= htmlspecialchars((string) $auth->perfil->nome) ?></div>
                                </div>

                                <div class="text-end">
                                    <a href="/profile/<?= $auth->id ?>/edit" class="btn btn-primary">
                                        <i class="feather icon-edit"></i> Editar Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end card -->
            </div>
        </div>

        <!-- [ Main Content ] end -->
    </div>
</div>