
<div class="form-floating mb-3">
    <input
        type="text"
        class="form-control"
        id="nome"
        name="nome"
        placeholder="Maria Clara" value="<?= $paciente->nome ?? '' ?>" required />
    <label for="nome">Nome Completo</label>

</div>
<div class="form-floating mb-3">
    <input
        type="text"
        class="form-control"
        id="endereco"
        name="endereco"
        placeholder="Enderenco" value="<?= $paciente->endereco ?? '' ?>" required />
    <label for="endereco">Endereço</label>

</div>
<div class="form-floating mb-3">
    <input
        type="date"
        class="form-control"
        id="data_nascimento"
        name="data_nascimento"
        placeholder="Nascimento" value="<?= $paciente->data_nascimento ?? '' ?>" required />
    <label for="data_nascimento">Data de Nascimento</label>

</div>
<div class="row">
    <div class="col-md-6 form-floating mb-3">
        <div class="form-floating">
            <select class="form-select" id="sexo" name="sexo" aria-label="Escolha de Genero" required>
                <option value="" disabled <?php echo (isset($paciente) && $paciente->sexo == '') ? 'selected' : ''; ?>>Selecionar...</option>
                <option value="M" <?php echo (isset($paciente) && $paciente->sexo == 'M') ? 'selected' : ''; ?>>Masculino</option>
                <option value="F" <?php echo (isset($paciente) && $paciente->sexo == 'F') ? 'selected' : ''; ?>>Feminino</option>
                <option value="Outro" <?php echo (isset($paciente) && $paciente->sexo == 'Outro') ? 'selected' : ''; ?>>Outro</option>
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
                placeholder="Contacto" value="<?= $paciente->telefone ?? '' ?>" required />
            <label for="tel">Contacto</label>
        </div>
    </div>
        <!-- Província (select) -->
    <div class="col-sm-6">
        <div class="form-floating mb-3">
            <select class="form-select" id="provincia" name="provincia_id" required>
                <option value="">Selecione a província</option>
                <?php foreach ($provincias as $provincia): ?>
                    <option value="<?=$provincia->id?>" <?= ($medico->provincia->nome ?? '') === $provincia->nome ? 'selected' : '' ?>><?=$provincia->nome?></option>
                <?php endforeach ?>
            
            </select>
            <label for="provincia">Província</label>
        </div>
    </div>

</div>