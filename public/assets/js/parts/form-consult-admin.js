
// --- 1. Variáveis de Estado ---
let currentStep = 1;
const selections = {
  paciente: null,
  medico: null,
  data: null,
  horario: null,
};
let pacientesData = [];
let medicosData = [];

// --- 2. Referências de Elementos DOM (serão atribuídas em appInit) ---
let form;
let loadingIndicator;
let formSteps;
let stepperSteps;
let btnPrev;
let btnNext;
let pacienteSelect;
let medicoSelect;
let noScheduleMessage;

// --- 3. Funções Principais ---

/**
 * Ponto de entrada principal, chamado quando o DOM está pronto.
 */
function appInit() {
  // Atribui todas as referências do DOM
  form = document.getElementById("agendamento-form");
  loadingIndicator = document.getElementById("loading-indicator");
  formSteps = document.querySelectorAll(".form-step");
  stepperSteps = document.querySelectorAll(".step");
  btnPrev = document.querySelector(".btn-prev");
  btnNext = document.querySelector(".btn-next");
  pacienteSelect = document.getElementById("paciente-select");
  medicoSelect = document.getElementById("medico-select");
  noScheduleMessage = document.getElementById("no-schedule-message");

  // Inicia o processo de carregamento de dados
  carregarDadosIniciais();
}

/**
 * Busca os dados iniciais (pacientes e médicos) da API.
 */
async function carregarDadosIniciais() {
  try {
    const response = await fetch("/api/consulta/all");
    if (!response.ok) {
      throw new Error(`Erro HTTP: ${response.status}`);
    }
    const data = await response.json();

    pacientesData = data.pacientes;
    medicosData = data.medicos;

    populateSelects();

    loadingIndicator.style.display = "none";
    form.style.display = "block";

    // Configura os listeners de eventos e a UI inicial
    initializeFormLogic();
  } catch (error) {
    console.error("Falha ao buscar dados da API:", error);
    loadingIndicator.textContent =
      "Erro ao carregar os dados. Por favor, tente mais tarde.";
  }
}

/**
 * Preenche os <select> de pacientes e médicos com os dados da API.
 */
function populateSelects() {
  pacientesData.forEach(
    (p) =>
      (pacienteSelect.innerHTML += `<option value="${p.id}">${p.nome}</option>`)
  );
  medicosData.forEach(
    (m) =>
      (medicoSelect.innerHTML += `<option value="${m.id}">${m.nome}</option>`)
  );
}

/**
 * Configura todos os listeners de eventos para o formulário e botões.
 */
function initializeFormLogic() {
  btnNext.addEventListener("click", () => {
    if (currentStep < 4) {
      currentStep++;
      if (currentStep === 3) displayDoctorSchedule();
      if (currentStep === 4) displayConfirmation();
      updateUI();
    } else {
      confirmarAgendamento();
    }
  });

  pacienteSelect.addEventListener("change", (e) => {
    selections.paciente = pacientesData.find((p) => p.id == e.target.value);
    validateStep();
  });

  medicoSelect.addEventListener("change", (e) => {
    selections.medico = medicosData.find((m) => m.id == e.target.value);
    selections.data = null;
    selections.horario = null;
    const hasAgenda =
      selections.medico &&
      selections.medico.agenda &&
      typeof selections.medico.agenda === "object" &&
      !Array.isArray(selections.medico.agenda) &&
      selections.medico.agenda.dias &&
      selections.medico.agenda.dias.length > 0;
    if (hasAgenda) {
      noScheduleMessage.style.display = "none";
    } else {
      noScheduleMessage.textContent =
        "Este médico não possui uma agenda disponível para agendamento online.";
      noScheduleMessage.style.display = "block";
    }
    validateStep();
  });

  btnPrev.addEventListener("click", () => {
    if (currentStep > 1) {
      currentStep--;
      updateUI();
    }
  });

  // Define o estado inicial da UI
  updateUI();
}

/**
 * Envia os dados do agendamento para a API.
 */
async function confirmarAgendamento() {
  // --- INÍCIO DA CORREÇÃO ---
  // Verifica se o array 'ids' existe e tem pelo menos um item
  const agendaId = selections.medico?.agenda?.ids?.[0];

  if (!agendaId) {
    alert(
      "Erro: Não foi possível encontrar um ID de agenda para este médico."
    );
    return; // Interrompe a execução se não houver ID
  }

  const appointmentData = {
    paciente_id: selections.paciente.id,
    medico_id: selections.medico.id,
    agenda_id: agendaId, // Usa a variável segura que criamos
    marcacao: `${selections.data} ${selections.horario}:00`,
  };
  // --- FIM DA CORREÇÃO ---

  btnNext.disabled = true;
  btnNext.textContent = "Enviando...";

  try {
    const response = await fetch("http://sgh.test/api/consulta/store", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify(appointmentData),
    });

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({
        message: "Erro desconhecido no servidor.",
      }));
      throw new Error(errorData.message || `Erro HTTP: ${response.status}`);
    }

    const res = await response.json();
    if (res.status) {
      // Obtém o modal pelo ID
      const modalElement = document.getElementById("cadConsultaModal");

      // Cria uma instância do modal Bootstrap
      const modal =
        bootstrap.Modal.getInstance(modalElement) ||
        new bootstrap.Modal(modalElement);
      modalElement.addEventListener("hidden.bs.modal", function () {
        Swal.fire({
          title: "Agendamento",
          text: "Agendamento salvo com sucesso",
          icon: "success",
        }).then(()=>{
              window.location.reload(); // Recarrega para um novo agendamento
        });
       
      });

      // Fecha o modal
      modal.hide();
    }
  } catch (error) {
    console.error("Falha ao enviar agendamento:", error);
    alert(`Não foi possível confirmar o agendamento: ${error.message}`);
  } finally {
    btnNext.disabled = false;
    btnNext.textContent = "Confirmar";
  }
}

/**
 * Valida se o passo atual está completo para habilitar o botão "Próximo".
 */
function validateStep() {
  let isValid = false;
  switch (currentStep) {
    case 1:
      isValid = !!selections.paciente;
      break;
    case 2:
      // Adicionada verificação para garantir que existem dias disponíveis
      isValid =
        selections.medico &&
        selections.medico.agenda &&
        typeof selections.medico.agenda === "object" &&
        !Array.isArray(selections.medico.agenda) &&
        selections.medico.agenda.dias &&
        selections.medico.agenda.dias.length > 0;
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

/**
 * Atualiza a interface do usuário (stepper, botões, passo ativo).
 */
function updateUI() {
  formSteps.forEach((step) => step.classList.remove("active"));
  document.getElementById(`step-${currentStep}`).classList.add("active");
  stepperSteps.forEach((step, index) => {
    if (index + 1 < currentStep) {
      step.classList.add("completed");
      step.classList.remove("active");
    } else if (index + 1 === currentStep) {
      step.classList.add("active");
      step.classList.remove("completed");
    } else {
      step.classList.remove("active", "completed");
    }
  });
  btnPrev.disabled = currentStep === 1;
  btnNext.textContent = currentStep === 4 ? "Confirmar" : "Próximo";
  validateStep();

  // Additional check for button text based on current step
  if (currentStep === 4) {
    btnNext.textContent = "Confirmar";
  } else {
    btnNext.textContent = "Próximo";
  }
}

/**
 * Exibe o calendário de datas disponíveis para o médico selecionado.
 */
function displayDoctorSchedule() {
  const container = document.getElementById("doctor-schedule-container");
  const datesContainer = document.getElementById("available-dates");
  // Limpa containers antigos antes de popular
  document.getElementById("time-slots-container").innerHTML = "";
  document.getElementById("time-slots-group").style.display = "none";

  document.getElementById("selected-doctor-name").textContent =
    selections.medico.nome;
  datesContainer.innerHTML = "";
  selections.medico.agenda.dias.forEach((dia) => {
    const dataFormatada = new Date(dia + "T00:00:00").toLocaleDateString(
      "pt-BR"
    );
    const button = document.createElement("button");
    button.type = "button";
    button.textContent = dataFormatada;
    button.dataset.date = dia;
    button.addEventListener("click", (e) => {
      selections.data = e.target.dataset.date;
      selections.horario = null;
      datesContainer
        .querySelectorAll("button")
        .forEach((btn) => btn.classList.remove("selected"));
      e.target.classList.add("selected");
      displayTimeSlots();
      validateStep();
    });
    datesContainer.appendChild(button);
  });
  container.style.display = "block";
}

/**
 * Exibe os horários disponíveis para a data selecionada.
 */
function displayTimeSlots() {
  const container = document.getElementById("time-slots-container");
  const timeGroup = document.getElementById("time-slots-group");
  document.getElementById("selected-date-display").textContent = new Date(
    selections.data + "T00:00:00"
  ).toLocaleDateString("pt-BR");
  container.innerHTML = "";
  const { inicio, fim, intervalo } = selections.medico.agenda;
  let [hI, mI] = inicio.split(":").map(Number);
  let [hF, mF] = fim.split(":").map(Number);
  let tempo = new Date();
  tempo.setHours(hI, mI, 0, 0);
  let tempoFim = new Date();
  tempoFim.setHours(hF, mF, 0, 0);
  while (tempo < tempoFim) {
    const hora = tempo.toTimeString().substring(0, 5);
    const button = document.createElement("button");
    button.type = "button";
    button.textContent = hora;
    button.dataset.time = hora;
    button.addEventListener("click", (e) => {
      selections.horario = e.target.dataset.time;
      container
        .querySelectorAll("button")
        .forEach((btn) => btn.classList.remove("selected"));
      e.target.classList.add("selected");
      validateStep();
    });
    container.appendChild(button);
    tempo.setMinutes(tempo.getMinutes() + intervalo);
  }
  timeGroup.style.display = "block";
}

/**
 * Exibe o resumo final do agendamento para confirmação.
 */
function displayConfirmation() {
  const container = document.getElementById("confirmation-details");
  const dataF = new Date(selections.data + "T00:00:00").toLocaleDateString(
    "pt-BR"
  );
  container.innerHTML = `<p>Paciente: <span>${selections.paciente.nome}</span></p><p>Médico: <span>${selections.medico.nome}</span></p><p>Data: <span>${dataF}</span></p><p>Horário: <span>${selections.horario}</span></p>`;
}

// --- 4. Ponto de Entrada ---
// O único listener que espera o DOM estar pronto para iniciar a aplicação.
document.addEventListener("DOMContentLoaded", appInit);
