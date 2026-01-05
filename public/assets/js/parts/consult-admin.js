let consultas = [];

const timelineContainer = document.getElementById("timeline-container");
const noResultsDiv = document.getElementById("no-results");
const filterControls = document.querySelector(".filter-controls");
const searchInput = document.getElementById("search-input");

function normalizeStatus(status) {
  return status.toLowerCase().replace(/\s+/g, "-");
}

function getRelativeDate(dateString) {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  const appointmentDate = new Date(dateString + "T00:00:00");

  let dateLabel = appointmentDate.toLocaleDateString("pt-BR", {
    day: "numeric",
    month: "long",
  });
  let dateClass = "";

  if (appointmentDate < today) {
    dateClass = "timeline-date-past";
  } else if (appointmentDate.getTime() === today.getTime()) {
    dateLabel = "Hoje";
    dateClass = "timeline-date-today";
  } else if (appointmentDate.getTime() === tomorrow.getTime()) {
    dateLabel = "Amanhã";
  }

  return {
    label: dateLabel,
    cssClass: dateClass,
  };
}

function renderizarConsultas(listaConsultas) {
  if (listaConsultas.length === 0) {
    noResultsDiv.style.display = "block";
    timelineContainer.innerHTML = "";
    return;
  }
  noResultsDiv.style.display = "none";

  const groupedByDate = listaConsultas.reduce((acc, c) => {
    (acc[c.data] = acc[c.data] || []).push(c);
    return acc;
  }, {});

  const sortedDates = Object.keys(groupedByDate).sort();
  let html = "";

  for (const date of sortedDates) {
    const relativeDate = getRelativeDate(date);
    html += `<div class="timeline-group"><div class="timeline-date ${relativeDate.cssClass}">${relativeDate.label}</div>`;
    const consultasDoDia = groupedByDate[date].sort((a, b) =>
      a.hora.localeCompare(b.hora)
    );
    for (const consulta of consultasDoDia) {
      html += `<div class="consulta-item status-${normalizeStatus(
        consulta.status
      )}" onclick="show(${consulta.id})">
                    <div class="consulta-time">${consulta.hora}</div>
                    <div class="consulta-details">
                      <h3>${consulta.paciente}</h3>
                          <p>${consulta.medico}(${
        consulta.especialidade
      }) - <span style="font-weight: bold;">${consulta.status}</span></p>

                    </div>
                  </div>`;
    }
    html += `</div>`;
  }
  timelineContainer.innerHTML = html;
}

function atualizarVisualizacao() {
  const filtroStatus = document.querySelector(
    'input[name="status-filter"]:checked'
  ).value;
  const termoBusca = searchInput.value.toLowerCase();

  let listaFiltrada = consultas;

  if (filtroStatus !== "Todos") {
    listaFiltrada = listaFiltrada.filter((c) => c.status === filtroStatus);
  }

  if (termoBusca) {
    listaFiltrada = listaFiltrada.filter(
      (c) =>
        c.paciente.toLowerCase().includes(termoBusca) ||
        c.especialidade.toLowerCase().includes(termoBusca)
    );
  }

  renderizarConsultas(listaFiltrada);
}

filterControls.addEventListener("change", atualizarVisualizacao);
searchInput.addEventListener("input", atualizarVisualizacao);

async function carregarConsultas() {
  const api = "/api/consulta";
  try {
    const resposta = await fetch(api);
    if (!resposta.ok) throw new Error("Erro ao carregar os dados");
    consultas = await resposta.json();
    atualizarVisualizacao();
  } catch (erro) {
    console.error("Erro:", erro);
    timelineContainer.innerHTML =
      '<p style="color: red;">Erro ao carregar as consultas.</p>';
  }
}

//ver
async function show(id) {
  // console.log(id);
  const uri = `/api/consulta?id=${id}`;
  //  console.log(uri);
  /*  */
  const response = await fetch(uri);
  const res = await response.json();

  const model = new bootstrap.Modal(
    document.getElementById("VisulizarConsultaModal")
  );

  document.getElementById("consulta-pid").innerHTML = res.pid;
  document.getElementById("consulta-paciente").innerHTML = res.paciente;
  document.getElementById("consulta-data").innerHTML = res.data;
  document.getElementById("consulta-hora").innerHTML = res.hora;
  document.getElementById("consulta-status").innerHTML = res.status;

  model.show();
}

document.addEventListener("DOMContentLoaded", carregarConsultas);

const cadBtn = document.getElementById("btnCadastrar");
cadBtn.addEventListener("click", function () {
  const cadModal = document.getElementById("cadConsultaModal");
  const modal = new bootstrap.Modal(cadModal);
  modal.show();
});
document
  .getElementById("btnZerar")
  .addEventListener("click", async function () {
    const confirm = await swal.fire({
      title: "Tem certeza?",
      text: "Deseja realmente Apagar Tudo e Zerar?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sim, Apagar",
      cancelButtonText: "Cancelar",
    });

    if (confirm.isConfirmed) {
      try {
        const response = await fetch("/admin/zerar-consulta", {
          method: "DELETE",
        });
        if (!response.ok) {
          new Error("Erro do servidor");
        }
        const result = await response.json();
        const data = result.data;
        if (data.status) {
          swal.fire("Successo", result.message, "success").then(()=> {
                window.location.reload(); // Recarrega para um novo agendamento

          });
        }

        // console.log(result);
      } catch (error) {
        console.log(`Erro do Servidor ${error}`);
      }
    } else {
      swal.fire("Cancelado", "Açao cancelada");
    }
  });
