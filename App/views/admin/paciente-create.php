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
                                    <a href="<?php echo root(); ?>dashboard"><i class="feather icon-home"></i> Painel Hospitalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="<?php echo root(); ?>pacientes"> <i class="feather icon-users"></i> Gerenciar Paciente</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-user-plus"></i> Novo
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title"><?php echo $title; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form de Create -->
        <div class="card shadow-lg border-0 col-sm-12 col-md-8 offset-md-2 mt-5 rounded-2">
            <form action="<?php echo root(); ?>admin/paciente-store" method="post" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-header bg-gradient text-white text-center py-4 rounded-top" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                    <h4 class="mb-0"><i class="feather icon-user-plus me-2"></i> Cadastro de Novo Paciente</h4>
                    <p class="small">Preencha os campos abaixo para registrar um novo utilizador</p>
                </div>

                <div class="card-body px-4 py-4">
                    <?php echo flash('error'); ?>

                    <div class="mb-4">
                        <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
                        <hr>
                        <?php include iViewForm('paciente') ?>
                    </div>

                    <!--  <div class="mt-4">
                        <h5 class="text-primary fw-semibold">Credenciais de Acesso</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-lock"></i></span>
                                    <input type="password" name="senha" id="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirme sua senha" required>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="card-footer text-center bg-light ">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
                        <i class="feather icon-save me-2"></i>Salvar Cadastro
                    </button>
                </div>
            </form>
        </div>
        <!-- Form de Create END-->

    </div>
</div>