<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ Main Content ] start -->
<div class="maintenance-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card error-card">
                    <div class="card-body">
                        <div class="error-image-block">
                            <img class="img-fluid" src="<?= asset('images/pages/Error404.png', true) ?>" alt=" img">
                            <img class="img-fluid img-twocone" src="<?= asset('images/pages/TwoCone.png', true) ?>"
                                alt="img">
                        </div>
                        <div class="text-center">
                            <h1 class="mt-5"><b>Método Não Permitido</b></h1>
                            <p class="mt-2 mb-4 text-muted">
                                <?= $message . '| Ficheiro ' . $exception->getFile() . " " . $exception->getLine() ?></p>

                            <p class="mt-2 mb-4 text-muted"><?= isset($trace) ? implode(' ', $trace) : '' ?></p>
                            <a href="<?= root() ?>" class="btn btn-primary mb-3">Ir para o Início</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->