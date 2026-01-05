<?php
$errors = $_SESSION['input_errors'] ?? [];
// Clear errors after consumption in view is tricky here without a framework feature, 
// usually done in controller or middleware. For now, we assume they persist for this request.
?>

<div class="mb-4">
    <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
    <hr>
    <label for="nome" class="form-label">Nome Completo <span style="color: red;">*</span></label>
    <div class="input-group has-validation">
        <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
        <input type="text" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>" id="nome" name="nome" placeholder="Ex: Maria Clara Silva"
            value="<?php echo $medico->usuario->nome ?? old('nome'); ?>" required>
        <?php if (isset($errors['nome'])): ?>
            <div class="invalid-feedback">
                <?= implode(', ', $errors['nome']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail <span style="color: red;">*</span></label>
    <div class="input-group has-validation">
        <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="email@exemplo.com"
            value="<?php echo $medico->usuario->email ?? old('email'); ?>" required>
        <?php if (isset($errors['email'])): ?>
            <div class="invalid-feedback">
                <?= implode(', ', $errors['email']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">
    <label for="perfil" class="form-label">Perfil <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-info"></i></span>
        <input type="text" class="form-control" id="perfil" name="perfil" readonly value="Medico">
    </div>
</div>
<h5 class="text-primary fw-semibold">Informações Adicionas</h5>
<hr>
<div class="row">
    <!-- Numero de Ordem -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <input type="text" class="form-control <?= isset($errors['numero_ordem']) ? 'is-invalid' : '' ?>" id="numero" name="numero_ordem" placeholder="Número de Ordem"
                value="<?= $medico->numero_ordem ?? old('numero_ordem') ?? '' ?>" required />
            <label for="numero">Número de Ordem</label>
            <?php if (isset($errors['numero_ordem'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['numero_ordem']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Especialidade (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <select class="form-select <?= isset($errors['especialidade_id']) ? 'is-invalid' : '' ?>" id="especialidade" name="especialidade_id" required>
                <option value="">Selecione uma especialidade</option>
                <?php foreach ($especialidades as $especialidade): ?>
                    <option value="<?= $especialidade->id ?>"
                        <?= ($medico->especialidade->nome ?? '') === $especialidade->nome || old('especialidade_id') == $especialidade->id ? 'selected' : '' ?>>
                        <?= $especialidade->nome ?></option>
                <?php endforeach ?>
            </select>
            <label for="especialidade">Especialidade</label>
            <?php if (isset($errors['especialidade_id'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['especialidade_id']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Nível (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <select class="form-select <?= isset($errors['nivel']) ? 'is-invalid' : '' ?>" id="nivel" name="nivel" required>
                <option value="">Selecione o nível</option>
                <option value="Generalista" <?= ($medico->nivel ?? '') === 'Generalista' || old('nivel') === 'Generalista' ? 'selected' : '' ?>>
                    Generalista</option>
                <option value="Especialista" <?= ($medico->nivel ?? '') === 'Especialista' || old('nivel') === 'Especialista' ? 'selected' : '' ?>>
                    Especialista</option>
                <option value="Interno" <?= ($medico->nivel ?? '') === 'Interno' || old('nivel') === 'Interno' ? 'selected' : '' ?>>Interno</option>
            </select>
            <label for="nivel">Nível</label>
            <?php if (isset($errors['nivel'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['nivel']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Sexo (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <select class="form-select <?= isset($errors['genero']) ? 'is-invalid' : '' ?>" id="genero" name="genero" required>
                <option value="">Selecione o Sexo</option>
                <option value="M" <?= ($medico->genero ?? '') === 'M' || old('genero') === 'M' ? 'selected' : '' ?>>Masculino</option>
                <option value="F" <?= ($medico->genero ?? '') === 'F' || old('genero') === 'F' ? 'selected' : '' ?>>Femenino</option>
                <option value="O" <?= ($medico->genero ?? '') === 'O' || old('genero') === 'O' ? 'selected' : '' ?>>Previso não Dizer</option>
            </select>
            <label for="genero">Sexo</label>
            <?php if (isset($errors['genero'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['genero']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Província (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <select class="form-select <?= isset($errors['provincia_id']) ? 'is-invalid' : '' ?>" id="provincia" name="provincia_id" required>
                <option value="">Selecione a província</option>
                <?php foreach ($provincias as $provincia): ?>
                    <option value="<?= $provincia->id ?>"
                        <?= ($medico->provincia->nome ?? '') === $provincia->nome || old('provincia_id') == $provincia->id ? 'selected' : '' ?>>
                        <?= $provincia->nome ?></option>
                <?php endforeach ?>
            </select>
            <label for="provincia">Província</label>
            <?php if (isset($errors['provincia_id'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['provincia_id']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Telefone -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <input type="tel" class="form-control <?= isset($errors['telefone']) ? 'is-invalid' : '' ?>" id="telefone" name="telefone" placeholder="Telefone"
                value="<?= $medico->telefone ?? old('telefone') ?? '' ?>" required />
            <label for="telefone">Telefone</label>
            <?php if (isset($errors['telefone'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['telefone']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Data Nascimento -->
    <div class="col-sm-6">
        <div class="form-floating mb-3 has-validation">
            <input type="date" class="form-control <?= isset($errors['data_nascimento']) ? 'is-invalid' : '' ?>" id="data_nascimento" name="data_nascimento" placeholder="Data de Nascimento"
                value="<?= $medico->usuario->data_nascimento ?? old('data_nascimento') ?? '' ?>" required />
            <label for="data_nascimento">Data de Nascimento</label>
            <?php if (isset($errors['data_nascimento'])): ?>
                <div class="invalid-feedback">
                    <?= implode(', ', $errors['data_nascimento']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>