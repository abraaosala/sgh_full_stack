<div class="form-floating mb-3">
    <input
        type="text"
        class="form-control"
        id="nome"
        name="nome"
        placeholder="Maria Clara" value="<?= $mpaciente->nome ?? '' ?>" required />
    <label for="nome">Nome Completo</label>

</div>
<div class="form-floating mb-3">
    <input
        type="text"
        class="form-control"
        id="email"
        name="email"
        placeholder="Maria Clara" value="<?= $mpaciente->email ?? '' ?>" required />
    <label for="email">Email </label>

</div>
<div class="form-floating mb-3">
    <input
        type="text"
        class="form-control"
        id="endereco"
        name="endereco"
        placeholder="Enderenco" value="<?= $mpaciente->endereco ?? '' ?>" required />
    <label for="endereco">Endereço</label>

</div>
<div class="form-floating mb-3">
    <input
        type="date"
        class="form-control"
        id="data_nascimento"
        name="data_nascimento"
        placeholder="Nascimento" value="<?= $mpaciente->data_nascimento ?? '' ?>" required />
    <label for="data_nascimento">Data de Nascimento</label>

</div>

<div class="form-floating mb-3">
    <select class="form-select" id="provincia" name="provincia_id" required>
        <option value="">Selecione a província</option>
        <?php foreach ($provincias as $provincia): ?>
            <option value="<?= $provincia->id ?>" <?= ($medico->provincia->nome ?? '') === $provincia->nome ? 'selected' : '' ?>><?= $provincia->nome ?></option>
        <?php endforeach ?>

    </select>
    <label for="provincia">Província</label>
</div>
<div class="row">
    <div class="col-md-6 form-floating mb-3">
        <div class="form-floating">
            <select class="form-select" id="sexo" name="genero" aria-label="Escolha de Genero" required>
                <option value="" disabled <?php echo (isset($mpaciente) && $mpaciente->sexo == '') ? 'selected' : ''; ?>>Selecionar...</option>
                <option value="M" <?php echo (isset($mpaciente) && $mpaciente->sexo == 'M') ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo (isset($mpaciente) && $mpaciente->sexo == 'F') ? 'selected' : ''; ?>>Feminino</option>
                <option value="0" <?php echo (isset($mpaciente) && $mpaciente->sexo == 'Outro') ? 'selected' : ''; ?>>Outro</option>
            </select>
            <label for="sexo">Gêneros</label>
        </div>
    </div>

    <div class="col-md-6 form-floating mb-3">
        <div class="form-floating mb-3">
            <input
                type="text"
                class="form-control"
                id="tel"
                name="telefone"
                placeholder="Contacto" value="<?= $mpaciente->telefone ?? '' ?>" required />
            <label for="tel">Contacto</label>
        </div>
    </div>


    <!-- Província (select) -->

</div>
</div>