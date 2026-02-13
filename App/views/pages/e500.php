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
                             <div class="row justify-content-center">
                                 <div class="col-10">
                                     <img class="img-fluid" src="<?= asset('images/pages/Error500.png',true) ?>" alt="img">
                                 </div>
                             </div>
                         </div>
                         <div class="text-center">
                             <h1 class="mt-4"><b>Erro Interno do Servidor</b></h1>
                             <p class="mt-2 mb-4 text-sm text-muted"><?=$message .'| Ficheiro '.$exception->getFile(). " ". $exception->getLine()?> </p>
                             <p class="mt-2 mb-4 text-sm text-muted"><?=isset($trace) ? implode(' ', $trace) : '' ?></p>
                             <a href="<?= root() ?>" class="btn btn-primary mb-3">Ir para Inicio</a>
                             <!-- <button type="button" class="btn btn-primary mb-3">Ir para Inicio</button> -->
                             <!-- </div> -->
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- [ Main Content ] end -->