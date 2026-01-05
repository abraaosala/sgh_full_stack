 <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --primary-color: #3B82F6;
    --secondary-color: #10B981;
    --background-color: #F9FAFB;
    --card-bg: #FFFFFF;
    --text-primary: #1F2937;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;
}

/* .modal-body {
         font-family: 'Inter', sans-serif;
         background-color: var(--background-color);
         margin: 0;
         color: var(--text-primary);
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 50vh;
         padding: 40px;
     } */


.form-container {
    width: 100%;
    max-width: 700px;
    background-color: var(--card-bg);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    padding: 30px;
    box-sizing: border-box;
}

.stepper-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
    position: relative;
}

.stepper-container::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background-color: var(--border-color);
    transform: translateY(-50%);
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    z-index: 2;
    background-color: var(--card-bg);
    padding: 0 10px;
}

.step-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.3s ease;
}

.step p {
    margin: 8px 0 0 0;
    font-size: 0.9rem;
    font-weight: 500;
}

.step.active .step-circle {
    border-color: var(--primary-color);
    background-color: var(--primary-color);
    color: white;
}

.step.completed .step-circle {
    border-color: var(--secondary-color);
    background-color: var(--secondary-color);
    color: white;
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.form-group select {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
}

#doctor-schedule-container {
    margin-top: 20px;
}

#no-schedule-message {
    color: var(--text-secondary);
    font-style: italic;
    text-align: center;
    padding: 20px;
    border: 1px dashed var(--border-color);
    border-radius: 8px;
}

.schedule-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
}

.schedule-grid button {
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background-color: #F9FAFB;
    cursor: pointer;
    transition: all 0.2s;
}

.schedule-grid button:hover {
    background-color: #F3F4F6;
}

.schedule-grid button.selected {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

#confirmation-details p {
    font-size: 1.1rem;
    line-height: 1.6;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 10px;
}

#confirmation-details span {
    font-weight: 600;
    color: var(--primary-color);
}

.form-navigation {
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
}

.form-navigation .btn {
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-prev {
    background-color: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-primary);
}

.btn-prev:hover {
    background-color: #F3F4F6;
}

.btn-next {
    background-color: var(--primary-color);
    color: white;
}

.btn-next:hover {
    background-color: #1D4ED8;
}

.btn:disabled {
    background-color: #D1D5DB;
    cursor: not-allowed;
}

#loading-indicator {
    text-align: center;
    font-size: 1.2rem;
    color: var(--text-secondary);
    padding: 40px;
}
 </style>
 <div class="form-container">
     <div id="loading-indicator">Carregando dados do sistema...</div>

     <form id="agendamento-form" style="display: none;">
         <div class="stepper-container">
             <div class="step active" data-step="1">
                 <div class="step-circle">1</div>
                 <p>Especialidade</p>
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
                 <label for="especialidade-select">Selecione o Especialidade</label>
                 <select id="paciente-select">
                     <option value="">-- Escolha um Especialidade --</option>
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


 <script>
document.addEventListener('DOMContentLoaded', () => {
    const base = "http://sgh.test/";
    let currentStep = 1;
    const selections = {
        especialidade: null,
        medico: null,
        data: null,
        horario: null,
        agendaSelecionada: null
    };

    let especialidadesData = [];
    let medicosData = [];

    const form = document.getElementById('agendamento-form');
    const loadingIndicator = document.getElementById('loading-indicator');
    const formSteps = document.querySelectorAll('.form-step');
    const stepperSteps = document.querySelectorAll('.step');
    const btnPrev = document.querySelector('.btn-prev');
    const btnNext = document.querySelector('.btn-next');
    const especialidadeSelect = document.getElementById('paciente-select'); // já estava errado no HTML
    const medicoSelect = document.getElementById('medico-select');
    const noScheduleMessage = document.getElementById('no-schedule-message');

    async function carregarDadosIniciais() {
        try {
            const response = await fetch('http://sgh.test/api/consulta/paciente/all');
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            const data = await response.json();

            especialidadesData = data.especialidade;
            medicosData = data.medicos;

            populateEspecialidades();

            loadingIndicator.style.display = 'none';
            form.style.display = 'block';

            initializeFormLogic();

        } catch (error) {
            console.error('Falha ao buscar dados da API:', error);
            loadingIndicator.textContent = 'Erro ao carregar os dados. Por favor, tente mais tarde.';
        }
    }

    carregarDadosIniciais();

    function populateEspecialidades() {
        especialidadesData.forEach(e => {
            especialidadeSelect.innerHTML += `<option value="${e.id}">${e.nome}</option>`;
        });
    }

    function populateMedicos(especialidadeId) {
        medicoSelect.innerHTML = `<option value="">-- Escolha um médico --</option>`;
        medicosData
            .filter(m => m.especialidade_id == especialidadeId)
            .forEach(m => {
                medicoSelect.innerHTML += `<option value="${m.id}">${m.nome}</option>`;
            });
    }

    function initializeFormLogic() {
        async function confirmarAgendamento() {
            if (!selections.agendaSelecionada) {
                alert('Erro: Nenhuma agenda selecionada.');
                return;
            }

            const appointmentData = {
                medico_id: selections.medico.id,
                agenda_id: selections.agendaSelecionada.id,
                marcacao: `${selections.data} ${selections.horario}:00`
            };

            btnNext.disabled = true;
            btnNext.textContent = 'Enviando...';

            try {
                const response = await fetch('http://sgh.test/api/consulta-paciente/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(appointmentData)
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({
                        message: 'Erro desconhecido no servidor.'
                    }));
                    throw new Error(errorData.message || `Erro HTTP: ${response.status}`);
                }

                const res = await response.json();

                // console.log('Resposta da API:', res);
                if (res.status) {
                    alert("Agendamento confirmado com sucesso!");
                    window.location.reload();
                } else {
                    throw new Error(res.message || 'Erro ao confirmar o agendamento.');
                }

            } catch (error) {
                console.error('Falha ao enviar agendamento:', error);
                alert(`Não foi possível confirmar o agendamento: ${error.message}`);
            } finally {
                btnNext.disabled = false;
                btnNext.textContent = 'Confirmar';
            }
        }

        btnNext.addEventListener('click', () => {
            if (currentStep < 4) {
                currentStep++;
                if (currentStep === 3) displayDoctorSchedule();
                if (currentStep === 4) displayConfirmation();
                updateUI();
            } else {
                confirmarAgendamento();
            }
        });

        especialidadeSelect.addEventListener('change', (e) => {
            selections.especialidade = especialidadesData.find(es => es.id == e.target.value);
            populateMedicos(e.target.value);
            selections.medico = null;
            selections.data = null;
            selections.horario = null;
            validateStep();
        });

        medicoSelect.addEventListener('change', (e) => {
            selections.medico = medicosData.find(m => m.id == e.target.value);
            selections.data = null;
            selections.horario = null;
            if (selections.medico && selections.medico.agenda.length > 0) {
                noScheduleMessage.style.display = 'none';
            } else {
                noScheduleMessage.textContent =
                    'Este médico não possui uma agenda disponível para agendamento online.';
                noScheduleMessage.style.display = 'block';
            }
            validateStep();
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateUI();
            }
        });

        function validateStep() {
            let isValid = false;
            switch (currentStep) {
                case 1:
                    isValid = !!selections.especialidade;
                    break;
                case 2:
                    isValid = selections.medico && selections.medico.agenda.length > 0;
                    break;
                case 3:
                    isValid = !!selections.data && !!selections.horario;
                    break;
                case 4:
                    isValid = true;
                    break;
            }
            btnNext.disabled = !isValid;
        }

        function updateUI() {
            formSteps.forEach(step => step.classList.remove('active'));
            document.getElementById(`step-${currentStep}`).classList.add('active');
            stepperSteps.forEach((step, index) => {
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                    step.classList.remove('active');
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                    step.classList.remove('completed');
                } else {
                    step.classList.remove('active', 'completed');
                }
            });
            btnPrev.disabled = currentStep === 1;
            btnNext.textContent = currentStep === 4 ? "Confirmar" : "Próximo";
            validateStep();
        }

        function displayDoctorSchedule() {
            const container = document.getElementById('doctor-schedule-container');
            const datesContainer = document.getElementById('available-dates');
            document.getElementById('time-slots-container').innerHTML = '';
            document.getElementById('time-slots-group').style.display = 'none';

            document.getElementById('selected-doctor-name').textContent = selections.medico.nome;
            datesContainer.innerHTML = '';

            const agendas = selections.medico.agenda;
            const diasUnicos = [...new Set(agendas.map(a => a.dia))];

            diasUnicos.forEach(dia => {
                const dataFormatada = new Date(dia + 'T00:00:00').toLocaleDateString('pt-BR');
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = dataFormatada;
                button.dataset.date = dia;
                button.addEventListener('click', (e) => {
                    selections.data = e.target.dataset.date;
                    selections.horario = null;
                    datesContainer.querySelectorAll('button').forEach(btn => btn.classList
                        .remove('selected'));
                    e.target.classList.add('selected');
                    displayTimeSlots(dia);
                    validateStep();
                });
                datesContainer.appendChild(button);
            });
            container.style.display = 'block';
        }

        function displayTimeSlots(diaSelecionado) {
            const container = document.getElementById('time-slots-container');
            const timeGroup = document.getElementById('time-slots-group');
            document.getElementById('selected-date-display').textContent =
                new Date(diaSelecionado + 'T00:00:00').toLocaleDateString('pt-BR');
            container.innerHTML = '';

            const agendas = selections.medico.agenda.filter(a => a.dia === diaSelecionado);

            agendas.forEach(agenda => {
                selections.agendaSelecionada = agenda;

                let [hI, mI] = agenda.inicio.split(':').map(Number);
                let [hF, mF] = agenda.fim.split(':').map(Number);

                let tempo = new Date();
                tempo.setHours(hI, mI, 0, 0);
                let tempoFim = new Date();
                tempoFim.setHours(hF, mF, 0, 0);

                while (tempo <= tempoFim) {
                    const hora = tempo.toTimeString().substring(0, 5);
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.textContent = hora;
                    button.dataset.time = hora;
                    button.addEventListener('click', (e) => {
                        selections.horario = e.target.dataset.time;
                        container.querySelectorAll('button').forEach(btn => btn.classList
                            .remove('selected'));
                        e.target.classList.add('selected');
                        validateStep();
                    });
                    container.appendChild(button);
                    tempo.setMinutes(tempo.getMinutes() + agenda.intervalo);
                }
            });

            timeGroup.style.display = 'block';
        }

        function displayConfirmation() {
            const container = document.getElementById('confirmation-details');
            const dataF = new Date(selections.data + 'T00:00:00').toLocaleDateString('pt-BR');
            container.innerHTML =
                `<p>Médico: <span>${selections.medico.nome}(${selections.especialidade.nome})</span></p>
                 <p>Data: <span>${dataF}</span></p>
                 <p>Horário: <span>${selections.horario}</span></p>
                 
                 `;
        }
        /* <p>Especialidade: <span>${selections.especialidade.nome}</span></p> */
        updateUI();
    }
});
 </script>