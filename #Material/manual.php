<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<link rel="stylesheet" href="<?php echo root(); ?>public/assets/vendor/bootstrap/css/bootstrap.min.css">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/fonts/tabler-icons.min.css">
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/fonts/feather.css">
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/fonts/fontawesome.css">
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/fonts/material.css">
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/css/style.css" id="main-style-link">
<link rel="stylesheet" href="<?php echo root(); ?>public/assets/css/custom.css" id="main-style-link">
<link rel="stylesheet" href="<?php echo root(); ?>public/ui/assets/css/style-preset.css">

<!--  -->
<div class="pc-container">
  <div class="pc-content">
    <div class="card p-3 mb-3">
      <h5 class="card-title">Agenda Médica</h5>
      <div class="row">
        <div class="col-md-6">
          <label for="medico">Selecione o Médico:</label>
          <select id="medico" name="medico_id" class="form-control">
            <option value="">-- Escolha um médico --</option>
            <?php foreach ($medicos as $item): ?>
              <option value="<?php echo $item->id; ?>">
                <?php echo $item->nome; ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-6">
          <div id="paciente-container" style="display:none; margin-top:10px;">
            <label for="paciente">Selecione o Paciente:</label>
            <select id="paciente" name="paciente_id" class="form-control">
              <option value="">-- Escolha um paciente --</option>
              <?php foreach ($pacientes as $paciente): ?>
                <option value="<?php echo $paciente->id; ?>">
                  <?php echo $paciente->nome; ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </div>


    </div>

    <div id="calendar" style="display:none;"></div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const selectMedico = document.getElementById("medico");
    const calendarEl = document.getElementById("calendar");
    let calendar = null;

    selectMedico.addEventListener("change", function() {
      const medicoId = this.value;

      if (!medicoId) {
        // Se não escolher médico, esconde calendário
        calendarEl.style.display = "none";
        if (calendar) {
          calendar.destroy();
          calendar = null;
        }
        return;
      }

      // Mostra calendário
      calendarEl.style.display = "block";

      if (calendar) {
        // Atualiza eventos usando URL amigável
        calendar.setOption("events", "/api/agenda/medico/" + medicoId);
      } else {
        // Cria calendário
        calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          initialView: "dayGridMonth",
          locale: "pt-br",
          events: "/api/agenda/medico/" + medicoId, // URL amigável aqui
          selectable: true,
          select: function(info) {
            let titulo = prompt("Descrição da consulta:");
            if (titulo) {
              fetch("/api/agenda/criar", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  medico_id: medicoId,
                  title: titulo,
                  start: info.startStr,
                  end: info.endStr,
                }),
              }).then(() => calendar.refetchEvents());
            }
          },
          eventClick: function(info) {
            if (confirm("Deseja remover este evento?")) {
              fetch("/api/agenda/remover/" + info.event.id, {
                method: "DELETE",
              }).then(() => calendar.refetchEvents());
            }
          },
        });
        calendar.render();
      }
    });
  });
</script>

<!--  -->
<script>
  const consultas = [{
      id: 3,
      data: "2025-08-20",
      hora: "14:00",
      paciente: "Mariana Costa",
      especialidade: "Psicologia",
      status: "Realizado"
    },
    {
      id: 4,
      data: "2025-08-20",
      hora: "09:00",
      paciente: "João Pereira",
      especialidade: "Fisioterapia",
      status: "Cancelado"
    },
    {
      id: 1,
      data: "2025-08-21",
      hora: "10:00",
      paciente: "Ana Silva",
      especialidade: "Clínica Geral",
      status: "Confirmado"
    },
    {
      id: 2,
      data: "2025-08-21",
      hora: "11:30",
      paciente: "Carlos Souza",
      especialidade: "Odontologia",
      status: "Confirmado"
    },
    {
      id: 5,
      data: "2025-08-22",
      hora: "15:00",
      paciente: "Beatriz Lima",
      especialidade: "Clínica Geral",
      status: "Confirmado"
    },
    {
      id: 6,
      data: "2025-08-22",
      hora: "16:30",
      paciente: "Ricardo Alves",
      especialidade: "Odontologia",
      status: "Confirmado"
    },
    {
      id: 7,
      data: "2025-08-24",
      hora: "08:00",
      paciente: "Fernanda Rocha",
      especialidade: "Psicologia",
      status: "Confirmado"
    },
  ];



  const timelineContainer = document.getElementById('timeline-container');
  const noResultsDiv = document.getElementById('no-results');
  const filterControls = document.querySelector('.filter-controls');
  const searchInput = document.getElementById('search-input');

  function normalizeStatus(status) {
    return status.toLowerCase().replace(/\s+/g, '-');
  }

  function getRelativeDate(dateString) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    const appointmentDate = new Date(dateString + 'T00:00:00');

    let dateLabel = appointmentDate.toLocaleDateString('pt-BR', {
      day: 'numeric',
      month: 'long'
    });
    let dateClass = '';

    if (appointmentDate < today) {
      dateClass = 'timeline-date-past';
    } else if (appointmentDate.getTime() === today.getTime()) {
      dateLabel = 'Hoje';
      dateClass = 'timeline-date-today';
    } else if (appointmentDate.getTime() === tomorrow.getTime()) {
      dateLabel = 'Amanhã';
    }

    return {
      label: dateLabel,
      cssClass: dateClass
    };
  }

  function renderizarConsultas(listaConsultas) {
    if (listaConsultas.length === 0) {
      noResultsDiv.style.display = 'block';
      timelineContainer.innerHTML = '';
      return;
    }
    noResultsDiv.style.display = 'none';

    const groupedByDate = listaConsultas.reduce((acc, c) => {
      (acc[c.data] = acc[c.data] || []).push(c);
      return acc;
    }, {});
    const sortedDates = Object.keys(groupedByDate).sort();
    let html = '';

    for (const date of sortedDates) {
      const relativeDate = getRelativeDate(date);
      html += `<div class="timeline-group"><div class="timeline-date ${relativeDate.cssClass}">${relativeDate.label}</div>`;
      const consultasDoDia = groupedByDate[date].sort((a, b) => a.hora.localeCompare(b.hora));
      for (const consulta of consultasDoDia) {
        html += `<div class="consulta-item status-${normalizeStatus(consulta.status)}">
                                <div class="consulta-time">${consulta.hora}</div>
                                <div class="consulta-details">
                                    <h3>${consulta.paciente}</h3>
                                    <p>${consulta.especialidade} - <span style="font-weight: bold;">${consulta.status}</span></p>
                                </div>
                             </div>`;
      }
      html += `</div>`;
    }
    timelineContainer.innerHTML = html;
  }

  // Função central que aplica AMBOS os filtros
  function atualizarVisualizacao() {
    // 1. Pega o valor do botão de status
    const filtroStatus = document.querySelector('input[name="status-filter"]:checked').value;
    // 2. Pega o valor do campo de pesquisa
    const termoBusca = searchInput.value.toLowerCase();

    // Começa com a lista completa
    let listaFiltrada = consultas;

    // 3. Aplica o filtro de status (se não for "Todos")
    if (filtroStatus !== 'Todos') {
      listaFiltrada = listaFiltrada.filter(c => c.status === filtroStatus);
    }

    // 4. Aplica o filtro de pesquisa (se houver texto)
    if (termoBusca) {
      listaFiltrada = listaFiltrada.filter(c =>
        c.paciente.toLowerCase().includes(termoBusca) ||
        c.especialidade.toLowerCase().includes(termoBusca)
      );
    }

    // 5. Renderiza o resultado final
    renderizarConsultas(listaFiltrada);
  }

  // Adiciona os 'escutadores' de eventos
  filterControls.addEventListener('change', atualizarVisualizacao);
  searchInput.addEventListener('input', atualizarVisualizacao);

  // Renderização Inicial ao carregar a página
  atualizarVisualizacao();
</script>