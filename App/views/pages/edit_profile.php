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
                                    <a href="<?php root()?>home">
                                        <i class="feather icon-home"></i> Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo root(); ?>profile/<?php echo $auth->id; ?>/name/<?php echo $auth->username; ?>">
                                        <i class="feather icon-user"></i> Meu Perfil
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-edit"></i> Editar Perfil
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title">Editar Perfil</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) $auth->nome); ?>&background=0D8ABC&color=fff&size=100"
                            alt="Avatar"
                            class="rounded-circle shadow mb-2"
                            width="100"
                            height="100">
                        <h4 class="mb-0"><?php echo htmlspecialchars((string) $auth->nome); ?></h4>
                        <small><?php echo htmlspecialchars((string) $auth->perfil); ?></small>
                    </div>

                    <form action="<?php echo root(); ?>perfil-update" method="post" autocomplete="off">
                        <div class="card-body">
                            <?php echo flash('error'); ?>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="feather icon-user"></i></span>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars((string) $auth->nome); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                               <?php if($perfil!=='superadmin'):?>
                                <label for="email" class="form-label">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars((string) $auth->email); ?>" disabled>
                                </div>
                               <?php else:?>
                                 <div class="input-group">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars((string) $auth->email); ?>">
                                </div>
                               <?php endif?>
                            </div>

                          <!--   <div class="mb-3">
                                <label for="username" class="form-label">Nome de Usuário</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="feather icon-user-check"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars((string) $auth->username); ?>" required>
                                </div>
                            </div> -->

                            <div class="mb-3">
                                <label for="perfil" class="form-label">Perfil</label>
                                <input type="text" class="form-control bg-light" id="perfil" value="<?php echo htmlspecialchars((string) $auth->perfil); ?>" disabled>
                            </div>
                        </div>

                        <div class="card-footer text-center bg-light">
                            <button type="submit" class="btn btn-warning px-5 py-2 fw-bold shadow-sm">
                                <i class="feather icon-save"></i> Salvar Alterações
                            </button>
                            <a href="<?php echo root(); ?>profile" class="btn btn-secondary ms-2">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>