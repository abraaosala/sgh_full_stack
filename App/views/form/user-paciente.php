<div class="mb-4">
    <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
    <hr>
    <label for="nome" class="form-label">Nome Completo <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Maria Clara Silva"
            value="<?php echo $paciente->nome ?? old('nome'); ?>" required>
    </div>
    <?php echo error_msg('nome'); ?>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
        <input type="email" class="form-control" id="email" name="email" placeholder="email@exemplo.com"
            value="<?php echo $paciente->email ?? old('email'); ?>" required>
    </div>
    <?php echo error_msg('email'); ?>
</div>

<div class="mb-3">
    <label for="perfil" class="form-label">Perfil <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
        <input type="text" class="form-control" id="perfil" name="perfil" placeholder="" readonly value="Paciente">
    </div>
</div>

<h5 class="text-primary fw-semibold">Informações Adicionais</h5>
<hr>

<div class="row">
    <!-- Data de Nascimento -->

    <div class="col-sm-6">
        <div class="form-floating mb-3">
           <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="Data de Nascimento" value="<?= $paciente->data_nascimento ?? old('data_nascimento') ?>" required />
            <label for="data_nascimento">Data de Nascimento</label>
        </div>
    </div>

    <!-- Gênero (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <select class="form-select select2" id="genero" name="genero" required>
                <option value="">Selecione o Sexo</option>
                <option value="M" <?= ($paciente->genero ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($paciente->genero ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                <option value="O" <?= ($paciente->genero ?? '') === 'O' ? 'selected' : '' ?>>Previso não Dizer
                </option>
            </select>
            <label for="genero">Sexo</label>
        </div>
        <?php echo error_msg('genero'); ?>

    </div>
        <!-- </div>

<div class="row"> -->
    <!-- Província (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <select class="form-select" id="provincia" name="provincia_id" required>
                <option value="">Selecione a província</option>
                <?php foreach ($provincias as $provincia): ?>
                    <option value="<?= $provincia->id ?>"
                        <?= ($paciente->provincia_id ?? '') === $provincia->id ? 'selected' : '' ?>>
                        <?= $provincia->nome ?></option>
                <?php endforeach ?>
            </select>
            <label for="provincia">Província</label>
        </div>
        <?php echo error_msg('provincia_id'); ?>
    </div>

    <!-- Telefone -->
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Telefone"
                value="<?= $paciente->telefone ?? old('telefone') ?>" required />
            <label for="telefone">Telefone</label>
        </div>
        <?php echo error_msg('telefone'); ?>
    </div>
    <div class="mb-4">
        <label for="endereco" class="form-label">Endereço</label>
        <textarea name="endereco" id="endereco"
            class="form-control"><?= $paciente->endereco ?? old('endereco') ?></textarea>
        <?php echo error_msg('endereco'); ?>

    </div>
</div>