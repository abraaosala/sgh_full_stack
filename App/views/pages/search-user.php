<div class="card shadow-lg border-0 col-sm-12 col-md-4 offset-md-4 mt-5 rounded-2">
    <form action="<?php echo lnk("alterar-senha/etapa/"); ?>1" method="post" autocomplete="off" class="needs-validation"
        novalidate>
        <div class="card-body px-4 py-4">
            <?php echo flash(['info','error']); ?>

            <div class="mt-4">
                <h5 class="text-primary fw-semibold">Procurar Usuario</h5>
                <hr>
                <div class="mb-3">
                    <label for="user" class="form-label"> Usuario <span style="color: red; "">* <?=flashMessage('user')?>
                            </span></label> 
                       <!--  </div> -->
                                <div class=" input-group">
                            <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
                            <input type="name" name="user" id="user" class="form-control"
                                placeholder="Digite o Email ou BI" required>
                </div>

            </div>
        </div>
</div>
<!-- </div> 
                </div> -->

<div class="card-footer text-center bg-light ">
    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
        <i class="feather icon-save me-2"></i>Avançar
    </button>

</div>
<a class="link-primary" href="<?=lnk('login')?>">Voltar</a>
</form>

</div>