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
                                    <i class="feather icon-users"></i> Gerenciar Usuários
                                </li>
                                <!--  <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Todos
                                </li> -->
                            </ol>
                        </nav>
                        <h2 class="page-header-title">Criar Usuarios de Funcionarios</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-lg border-0 col-sm-12 col-md-8 offset-md-2 mt-5 rounded-2">
            <form action="<?php echo lnk('admin/funcionario-store'); ?>" method="post" autocomplete="off"
                class="needs-validation" novalidate>
                <div class="card-header bg-gradient text-white text-center py-4 rounded-top"
                    style="background: linear-gradient(45deg, #4e73df, #224abe);">
                    <h4 class="mb-0"><i class="feather icon-user-plus me-2"></i> Cadastro de Novo Funcionário</h4>
                    <p class="small">Preencha os campos abaixo para registrar um novo utilizador</p>
                </div>

                <div class="card-body px-4 py-4">
                    <?php echo flash(['error']); ?>
                    <?php include iViewForm('user-funcionario') ?>
                </div>
                <div class="card-footer text-center bg-light ">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
                        <i class="feather icon-save me-2"></i>Salvar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>