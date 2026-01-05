<link rel="stylesheet" href="<?= asset("css/parts/form-consult-admin.css")?>">
<div class="form-container">
    <div id="loading-indicator">Carregando dados do sistema...</div>

    <form id="agendamento-form" style="display: none;">
        <div class="stepper-container">
            <div class="step active" data-step="1">
                <div class="step-circle">1</div>
                <p>Paciente</p>
            </div>
            <div class="step" data-step="2">
                <div class="step-circle">2</div>
                <p>Médico</p>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle">3</div>
                <p>Horário</p>
            </div>
            <div class="step" data-step="4">
                <div class="step-circle">4</div>
                <p>Confirmar</p>
            </div>
        </div>

        <div class="form-step active" id="step-1">
            <div class="form-group">
                <label for="paciente-select">Selecione o Paciente</label>
                <select id="paciente-select">
                    <option value="">-- Escolha um paciente --</option>
                </select>
            </div>
        </div>
        <div class="form-step" id="step-2">
            <div class="form-group">
                <label for="medico-select">Selecione o Médico</label>
                <select id="medico-select">
                    <option value="">-- Escolha um médico --</option>
                </select>
                <div id="no-schedule-message" style="display: none; margin-top: 15px;"></div>
            </div>
        </div>
        <div class="form-step" id="step-3">
            <div id="doctor-schedule-container" style="display: none;">
                <h4>Agenda de <strong id="selected-doctor-name"></strong></h4>
                <div class="form-group"><label>Dias Disponíveis</label>
                    <div class="schedule-grid" id="available-dates"></div>
                </div>
                <div class="form-group" id="time-slots-group" style="display: none;"><label>Horários para <strong
                            id="selected-date-display"></strong></label>
                    <div class="schedule-grid" id="time-slots-container"></div>
                </div>
            </div>
        </div>
        <div class="form-step" id="step-4">
            <h3>Resumo do Agendamento</h3>
            <div id="confirmation-details"></div>
        </div>
        <div class="form-navigation">
            <button type="button" class="btn btn-prev" disabled>Anterior</button>
            <button type="button" class="btn btn-next">Próximo</button>
        </div>
    </form>
</div>

<script src="<?=asset("js/parts/form-consult-admin.js")?>"></script>