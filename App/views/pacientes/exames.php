<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Painel Hospitalar</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= root() ?>"><i class="feather icon-home"></i>
                                    Início</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Meus Exames</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <?= flash(['informar', 'success', 'danger'])?>
    </div>
</div>