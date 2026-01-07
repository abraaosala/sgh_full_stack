<div class="pc-container" id="medicos-agenda">
    <div class="pc-content">
        <div class="mb-3">
            <a class="btn btn-secondary btn-sm " href="#" role="button" id="generate"> Gerar Escala</a>
        </div>
        <div id='calendar'></div>

    </div>
</div>
<!-- ======================================-->
<script src="<?=  asset('js/ajax/admin_agenda_med.js')?>"></script>
<!-- ======================================-->

<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visualizarModalLabel" style="display: block;">Visualizar Evento - <span
                        id="title-ver"></span></h1>
                <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Visualizar  -->
                <div id="medico-info">
                    <div class="mb-3">
                        <label class="form-label"><strong>Nome do Médico:</strong></label>
                        <span id="medico-nome"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Especialidade:</strong></label>
                        <span id="medico-especialidade"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Entrada:</strong></label>
                        <span id="medico-entrada"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Saída:</strong></label>
                        <span id="medico-saida"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Numero da Ordem:</strong></label>
                        <span id="medico-ordem"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Contato:</strong></label>
                        <span id="medico-contato"></span>
                    </div>

                    <div class="mb-2">
                        <button type="button" class="btn btn-primary" id="editar-btn">
                            <i class="ti ti-pencil"></i>
                            Editar
                        </button>
                    </div>

                    <!-- <div class="mb-2"> -->
                    <form id="form-eliminar">
                        <input type="hidden" name="id" id="eliminar-id-input">
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash"></i>
                            Eliminar
                        </button>
                    </form>
                    <!-- </div> -->
                </div>

                <!-- Fim -->
                <!-- Editar -->
                <div id="medico-edit" style="display: none;">
                    <form id="medico-edit-form">
                        <span id="msg-edit"></span>

                        <!-- <div class="mb-3">
              <label for="medico-nome-input" class="form-label"><strong>Nome do Médico:</strong></label>
              <input type="text" class="form-control" id="medico-nome-input" name="medico" readonly>
            </div> -->
                        <div class="mb-3">
                            <label for="medico-titulo-input" class="form-label"><strong>Titulo:</strong></label>
                            <input type="text" class="form-control" id="medico-titulo-input" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="medico-entrada-input" class="form-label"><strong>Entrada:</strong></label>
                            <input type="datetime-local" class="form-control" id="medico-entrada-input" name="start">
                        </div>
                        <div class="mb-3">
                            <label for="medico-saida-input" class="form-label"><strong>Saída:</strong></label>
                            <input type="datetime-local" class="form-control" id="medico-saida-input" name="end">
                        </div>
                        <input type="hidden" name="id" id="medico-id-input">
                        <!-- <div class="mb-3">
              <label for="medico-ordem-input" class="form-label"><strong>Numero da Ordem:</strong></label>
              <input type="text" class="form-control" id="medico-ordem-input" name="numero_ordem">
            </div> -->
                        <!-- <div class="mb-3">
              <label for="medico-contato-input" class="form-label"><strong>Contato:</strong></label>
              <input type="text" class="form-control" id="medico-contato-input" name="telefone">
            </div> -->
                        <button type="button" class="btn btn-secondary" id="first-btn">Voltar</button>
                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </form>
                </div>
                <!-- Fim -->




            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastrar Evento -->
<div class="modal fade" id="cadastrarModal" tabindex="-1" aria-labelledby="cadastrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cadastrarModalLabel">Cadastrar Novo Evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="cadastrar-evento-form">
                    <span id="msg-cad"></span>
                    <div class="mb-3">
                        <label for="cadastrar-medico-select" class="form-label"><strong>Médico:</strong></label>
                        <select class="form-select" id="cadastrar-medico-select" name="medico_id" required>
                            <option value="">Selecione um médico</option>
                            <!-- Aqui você pode adicionar as opções de médicos dinamicamente -->
                            <?php foreach ($medicos as $medico): ?>
                            <option value="<?php echo $medico->id; ?>"><?php echo $medico->nome; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--  <div class="mb-3">
            <label for="medico-titulo-input" class="form-label"><strong>Titulo:</strong></label>
            <input type="text" class="form-control" id="medico-titulo-input" name="title">
          </div> -->
                    <div class="mb-3">
                        <label for="medico-titulo-input" class="form-label"><strong>Titulo:</strong></label>
                        <select id="medico-titulo-input" name="title" class="form-select">
                            <option value="">Selecionar...</option>
                            <option value="Turno Matinal">Turno Matinal</option>
                            <option value="Turno Vespertino">Turno Vespertino</option>
                            <option value="Turno Noturno">Turno Noturno</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cadastrar-medico-entrada" class="form-label"><strong>Entrada:</strong></label>
                            <input type="datetime-local" class="form-control" id="cadastrar-medico-entrada" name="start"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cadastrar-medico-saida" class="form-label"><strong>Saída:</strong></label>
                            <input type="datetime-local" class="form-control" id="cadastrar-medico-saida" name="end"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Cor</label>
                        <select class="form-select" id="color" name="color" required>
                            <option value="">Selecione uma cor</option>
                            <option value="#007bff" style="color:#007bff;">Azul</option>
                            <option value="#28a745" style="color:#28a745;">Verde</option>
                            <option value="#dc3545" style="color:#dc3545;">Vermelho</option>
                            <option value="#ffc107" style="color:#ffc107;">Amarelo</option>
                            <option value="#6f42c1" style="color:#6f42c1;">Roxo</option>
                            <option value="#fd7e14" style="color:#fd7e14;">Laranja</option>
                            <option value="#20c997" style="color:#20c997;">Turquesa</option>
                            <option value="#343a40" style="color:#343a40;">Preto</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>