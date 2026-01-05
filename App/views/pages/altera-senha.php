<div class="card shadow-lg border-0 col-sm-12 col-md-4 offset-md-4 mt-5 rounded-2">
    <form action="<?php echo lnk('alterar-senha/etapa/'); ?>2" method="post" autocomplete="off" class="needs-validation"
        novalidate>
        <div class="card-body px-4 py-4">
            <?php echo flash(['info','error']); ?>

            <div class="mt-4">
                <h5 class="text-primary fw-semibold">Actualizar Senha</h5>
                <hr>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha <span style="color: red; "">* <?=flashMessage('password')?>
                            </span></label> 
                       <!--  </div> -->
                                <div class=" input-group">
                            <span class="input-group-text bg-light"><i class="feather icon-lock"></i></span>
                            <input type="password" name="senha" id="password" class="form-control"
                                placeholder="Mínimo 6 caracteres" required>
                </div>

            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Senha</label> <span
                    style="color: red; ">*</span> <i><?=flashMessage('confirm_password')?></i></label>
                <div class=" input-group">
                    <span class="input-group-text bg-light"><i class="feather icon-lock"></i></span>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        placeholder="Confirme sua senha" required>
                </div>
            </div>
        </div>
        <!-- </div> 
                </div> -->

        <div class="card-footer text-center bg-light ">
            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
                <i class="feather icon-save me-2"></i>Alterar
            </button>
        </div>
    </form>
</div>