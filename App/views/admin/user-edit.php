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
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="<?php echo root(); ?>users"> <i class="feather icon-users"></i> Gerenciar Usuários</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-edit"></i> Editar
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title"><?php echo $title; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Edit  -->
        <div class="card shadow-lg border-0 col-sm-12 col-md-8 offset-md-2 mt-5 rounded-2">
            <form action="<?php echo root(); ?>admin/usuario-save/<?=$user->id?>" method="post" autocomplete="off" class="needs-validation" novalidate>
                <div class="card-header bg-gradient text-white text-center py-4 rounded-top" style="background: linear-gradient(45deg, #0d6efd, #0a58ca);">
                    <h4 class="mb-0"> <i class="feather icon-edit me-2"></i>
                        Editar Usuário</h4>
                    <p class="small">Atualize os dados do utilizador abaixo</p>
                </div>

                <div class="card-body px-4 py-4">
                    <?php echo flash('error'); ?>

                    <div class="mb-4">
                        <h5 class="text-primary fw-semibold">Dados do Usuário</h5>
                        <hr>
                        <!--  -->
                        <?php require VIEW . '/form/user.php'; ?>
                    </div>
                </div>

               <!--  <input type="hidden" name="id" value="<?php echo $user->id; ?>"> -->
                <div class="card-footer text-center bg-light rounded-bottom">
                    <button type="submit" class="btn btn-warning px-5 py-2 fw-bold shadow-sm">
                        <i class="feather icon-save me-2"></i>Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
        <!-- Form Edit End -->
    </div>
</div>