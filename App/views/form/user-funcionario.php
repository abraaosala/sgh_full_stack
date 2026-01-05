<div class="mb-4">
    <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
    <hr>
    <label for="nome" class="form-label">Nome Completo <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Maria Clara Silva"
            value="<?php echo $funcionario->nome ?? old('nome'); ?>" required>
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">E-mail <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
        <input type="email" class="form-control" id="email" name="email" placeholder="email@exemplo.com"
            value="<?php echo $funcionario->email ?? old('email'); ?>" required>
    </div>
</div>

<div class="mb-3">
    <label for="perfil" class="form-label">Perfil <span style="color: red;">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light"><i class="feather icon-users"></i></span>
        <select class="form-select" id="perfil" name="perfil" required>
            <option value="">Selecione o perfil</option>
            <?php foreach ($funcionarios as $funcionario): ?>
            <option value="<?= strtolower((string) $funcionario) ?>"
                <?= (isset($funcionario->perfil) && $funcionario->perfil === strtolower($funcionario)) || old('perfil') === strtolower((string) $funcionario) ? 'selected' : '' ?>>
                <?= $funcionario ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <h5 class="text-primary fw-semibold">Informações Adicionais</h5>
    <hr>

    <div class="row">
        <!-- Numero de Ordem -->
        <div class="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="numero" name="numero_ordem" placeholder="Número de Ordem"
                    value="<?= $funcionario->numero_ordem ?? '' ?>" required />
                <label for="numero">Número de Ordem</label>
            </div>
        </div>

        <!-- Especialidade (select) -->
        <!-- <div class="col-sm-6"> -->
        <!--      <div class="form-floating mb-3">
                <select class="form-select" id="especialidade" name="especialidade_id" required>
                    <option value="">Selecione uma especialidade</option>
                    <?php foreach ($especialidades as $especialidade): ?>
                    <option value="<?= $especialidade->id ?>"
                        <?= ($funcionario->especialidade ?? '') === $especialidade->nome ? 'selected' : '' ?>>
                        <?= $especialidade->nome ?></option>
                    <?php endforeach ?> -->

        <!-- Adicione outras especialidades conforme necessário -->
        <!-- </select>
            <label for="especialidade">Especialidade</label>
        </div> -->
        <!-- </div> -->

        <!-- Nível (select) -->
        <!-- <div class="col-sm-6">
            <div class="form-floating mb-3">
                <select class="form-select" id="nivel" name="nivel" required>
                    <option value="">Selecione o nível</option>
                    <option value="Generalista" <?= ($funcionario->nivel ?? '') === 'Generalista' ? 'selected' : '' ?>>
                        Generalista</option>
                    <option value="Especialista"
                        <?= ($funcionario->nivel ?? '') === 'Especialista' ? 'selected' : '' ?>>
                        Especialista</option>
                    <option value="Interno" <?= ($funcionario->nivel ?? '') === 'Interno' ? 'selected' : '' ?>>Interno
                    </option>
                </select>
                <label for="nivel">Nível</label>
            </div>
        </div> -->
        <!-- Sexo (select) -->
        <div class="col-sm-6">
            <div class="form-floating mb-3">
                <select class="form-select select2" id="genero" name="genero" required>
                    <option value="">Selecione o Sexo</option>
                    <option value="M" <?= ($funcionario->genero ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= ($funcionario->genero ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                    <option value="O" <?= ($funcionario->genero ?? '') === 'O' ? 'selected' : '' ?>>Previso não Dizer
                    </option>
                </select>
                <label for="genero">Sexo</label>
            </div>
        </div>

        <!-- Hospital -->
        <!--  <div class="col-sm-6">
        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control"
                id="hospital"
                name="hospital"
                placeholder="Hospital"
                value="<?= $funcionario->hospital ?? '' ?>"
                required />
            <label for="hospital">Hospital</label>
        </div>
    </div> -->

        <!-- Província (select) -->
        <div class="col-sm-6">
            <div class="form-floating mb-3">
                <select class="form-select" id="provincia" name="provincia_id" required>
                    <option value="">Selecione a província</option>
                    <?php foreach ($provincias as $provincia): ?>
                    <option value="<?= $provincia->id ?>"
                        <?= ($funcionario->provincia ?? '') === $provincia->nome ? 'selected' : '' ?>>
                        <?= $provincia->nome ?></option>
                    <?php endforeach ?>

                </select>
                <label for="provincia">Província</label>
            </div>
        </div>
    </div>

    <?=csrf()->field()?>