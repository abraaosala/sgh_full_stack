<div class="mb-3">
    <?php flash('error')?>
    <label for="nome" class="form-label">Nome Completo <span style="color: red; "">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Maria Clara Silva" value="<?php echo $user->nome ?? old('nome'); ?>" required>
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail <span style="color: red; "">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
        <input type="email" class="form-control" id="email" name="email" placeholder="email@exemplo.com" value="<?php echo $user->email ?? old('email'); ?>" required>
    </div>
</div>

<div class="mb-3">
    <label for="perfil_id" class="form-label">Perfil de Acesso <span style="color: red; "">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-layers"></i></span>
        <select name="perfil" id="perfil_id" class="form-select" required>
            <option value="">Selecionar...</option>
            <?php foreach ($perfils as $perfil) { ?>
               <!--  -->
                <option value="<?php echo $perfil; ?>" <?php echo (isset($user) && $perfil == $user->perfil) ? 'selected' : ''; ?>>
                    <?php echo ucf($perfil); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
