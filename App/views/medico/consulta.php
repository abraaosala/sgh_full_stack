 <!-- CSS Incorporado -->
 <style>
/* Importando uma fonte mais agradável */
/*  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap'); */

:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --danger-color: #e74c3c;
    --grey-color: #7f8c8d;
    --light-grey-color: #ecf0f1;
    --background-color: #f7f9fc;
    --text-color: #2c3e50;
    --white-color: #ffffff;
    --border-radius: 12px;
}

/*   body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 25px;
            color: var(--text-color);
        } */

.container {
    max-width: 800px;
    margin: 0 auto;
}

.header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.header h1 {
    margin: 0;
    font-size: 2.5rem;
}

.header p {
    font-size: 1.1rem;
    color: var(--grey-color);
    margin-top: 0.5rem;
}

#search-input {
    width: 100%;
    padding: 16px 20px;
    margin-bottom: 1.5em;
    border: 2px solid var(--light-grey-color);
    border-radius: var(--border-radius);
    box-sizing: border-box;
    font-size: 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

#search-input:focus {
    border-color: var(--primary-color);
    outline: 0;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
}

.filter-controls {
    display: flex;
    justify-content: center;
    margin-bottom: 2.5rem;
    background-color: var(--light-grey-color);
    border-radius: var(--border-radius);
    padding: 5px;
}

.filter-controls input[type="radio"] {
    display: none;
}

.filter-controls label {
    padding: 12px 25px;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--grey-color);
    cursor: pointer;
    border-radius: 9px;
    transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
    text-align: center;
    flex-grow: 1;
}

.filter-controls input[type="radio"]:checked+label {
    background-color: var(--white-color);
    color: var(--primary-color);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 15px;
    bottom: 15px;
    width: 3px;
    background-color: var(--light-grey-color);
    border-radius: 3px;
}

.timeline-group {
    margin-bottom: 2.5rem;
}

.timeline-date {
    display: inline-block;
    background-color: var(--secondary-color);
    color: var(--white-color);
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
    left: -10px;
}

.timeline-date-today {
    background-color: var(--primary-color);
}

.timeline-date-past {
    background-color: var(--grey-color);
}

.consulta-item {
    background-color: var(--white-color);
    border-radius: var(--border-radius);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    padding: 20px;
    margin-left: 50px;
    margin-bottom: 1rem;
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.2s ease;
}

.consulta-item:hover {
    transform: translateX(5px);
}

.consulta-item::before {
    content: '';
    position: absolute;
    left: -42px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: var(--white-color);
    border: 4px solid var(--primary-color);
}

.consulta-item.status-realizado::before {
    border-color: var(--grey-color);
}

.consulta-item.status-cancelado::before {
    border-color: var(--danger-color);
}

.consulta-time {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-color);
    padding: 10px 15px;
    background-color: var(--light-grey-color);
    border-radius: 8px;
    text-align: center;
}

.consulta-details {
    flex-grow: 1;
}

.consulta-details h3 {
    margin: 0 0 5px 0;
    font-size: 1.2rem;
}

.consulta-details p {
    margin: 0;
    color: var(--grey-color);
}

.no-results {
    text-align: center;
    padding: 40px;
    font-size: 1.2em;
    color: var(--grey-color);
}
 </style>
 <div class="pc-container" id="medico_agenda">
     <div class="pc-content">
         <div class="container">
             <header class="header">
                 <h1>Agenda de Consultas</h1>
                 <p>Visualize e gerencie os próximos agendamentos.</p>


                 <button class="btn btn-light-success" id="btnPrint">Imprimir</button>
             </header>

             <input type=" search" id="search-input" placeholder="Pesquisar por paciente ou especialidade...">

             <div class="filter-controls">
                 <input type="radio" id="filter-todos" name="status-filter" value="Todos" checked>
                 <label for="filter-todos">Todos</label>

                 <input type="radio" id="filter-confirmado" name="status-filter" value="Agendada">
                 <label for="filter-confirmado">Confirmados</label>

                 <input type="radio" id="filter-realizado" name="status-filter" value="Concluída">
                 <label for="filter-realizado">Realizados</label>

                 <input type="radio" id="filter-cancelado" name="status-filter" value="Cancelada">
                 <label for="filter-cancelado">Cancelados</label>
             </div>

             <div id="timeline-container" class="timeline">
                 <!-- A timeline será gerada aqui pelo JavaScript -->
             </div>

             <div id="no-results" class="no-results" style="display: none;">
                 Nenhuma consulta encontrada.
             </div>
         </div>
     </div>
 </div>

 <!-- JavaScript Incorporado -->
 <script>
let consultas = [];
const id = <?= $id?>;
const print = document.getElementById('btnPrint');

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

        print.classList.add("disabled");
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
        html +=
            `<div class="timeline-group"><div class="timeline-date ${relativeDate.cssClass}">${relativeDate.label}</div>`;
        const consultasDoDia = groupedByDate[date].sort((a, b) => a.hora.localeCompare(b.hora));
        for (const consulta of consultasDoDia) {
            html += `<div class="consulta-item status-${normalizeStatus(consulta.status)}" onclick="show(${consulta.id})">
                    <div class="consulta-time">${consulta.hora}</div>
                    <div class="consulta-details">
                      <h3>${consulta.paciente}</h3>
                      <p><span style="font-weight: bold;">${consulta.status}</span></p>
                    </div>
                  </div>`;
        }
        html += `</div>`;
    }
    timelineContainer.innerHTML = html;
}

function atualizarVisualizacao() {
    const filtroStatus = document.querySelector('input[name="status-filter"]:checked').value;
    const termoBusca = searchInput.value.toLowerCase();

    let listaFiltrada = consultas;

    if (filtroStatus !== 'Todos') {
        listaFiltrada = listaFiltrada.filter(c => c.status === filtroStatus);
    }

    if (termoBusca) {
        listaFiltrada = listaFiltrada.filter(c =>
            c.paciente.toLowerCase().includes(termoBusca) ||
            c.especialidade.toLowerCase().includes(termoBusca)
        );
    }

    renderizarConsultas(listaFiltrada);
}

filterControls.addEventListener('change', atualizarVisualizacao);
searchInput.addEventListener('input', atualizarVisualizacao);

async function carregarConsultas() {
    try {
        const resposta = await fetch(`http://sgh.test//api/consult/med-paciente?id=${id}`);
        if (!resposta.ok) throw new Error('Erro ao carregar os dados');
        consultas = await resposta.json();
        // console.log(consultas);
        atualizarVisualizacao();
    } catch (erro) {
        console.error('Erro:', erro);
        timelineContainer.innerHTML = '<p style="color: red;">Erro ao carregar as consultas.</p>';
    }
}
document.addEventListener('DOMContentLoaded', carregarConsultas);

async function show(id) {
    // console.log(id);
    const uri = `/medico/api/consulta?id=${id}`;
    //  console.log(uri);
    /*  */
    const response = await fetch(uri);
    const res = await response.json();

    const model = new bootstrap.Modal(document.getElementById('VisulizarConsultaModal'));

    document.getElementById('consulta-pid').innerHTML = res.pid;

    document.getElementById('consulta-paciente').innerHTML = res.paciente;

    document.getElementById('consulta-data').innerHTML = res.data;
    document.getElementById('consulta-hora').innerHTML = res.hora;
    document.getElementById('consulta-status').innerHTML = res.status;

    model.show();

}
print.addEventListener("click", async function() {


    try {
        const response = await fetch('/api/med_emitir_ficha', {
            method: 'post'
        });

        if (!response.ok) {
            const errorResponse = await response.json(); // Assuming error responses are JSON
            throw new Error(errorResponse.error ||
                `Erro ao emitir ficha: ${response.status} ${response.statusText}`);
        }
        const result = await response.json();
        const data = result.data

        // console.log(result);
        if (data.success) {
            Swal.fire({
                title: 'Gerar Fecha',
                text: result.message,
                icon: 'success'
            }).then(() => {
                location.href = data.fileUrl;
            })
        }

    } catch (error) {
        console.error(`Houve erro no Servidor: ${error}`);
    }


});
 </script>

 <!-- Modal de ver  Consultas-->
 <div class="modal fade" id="VisulizarConsultaModal" tabindex="-1" aria-labelledby="VisulizarConsultaModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="VisulizarConsultaModalLabel" style="display: block;">Visualizar A
                     Consulta do Paciante #<span id="consulta-pid"></span><span id="title-ver"></span></h1>
                 <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Visualizar  -->
                 <div id="consulta-info">

                     <div class="mb-3">
                         <label class="form-label"><strong>Paciente:</strong></label>
                         <span id="consulta-paciente"></span>
                     </div>
                     <div class="mb-3">
                         <label class="form-label"><strong>Data:</strong></label>
                         <span id="consulta-data"></span>
                     </div>
                     <div class="mb-3">
                         <label class="form-label"><strong>Hora:</strong></label>
                         <span id="consulta-hora"></span>
                     </div>






                     <div class="mb-3">
                         <label class="form-label"><strong>Estado:</strong></label>
                         <span id="consulta-status"></span>
                     </div>

                     <!-- </div> -->
                 </div>

             </div>

         </div>
     </div>
 </div>

 <!-- 
 <p>${consulta.especialidade} - <span style="font-weight: bold;">${consulta.status}</span></p>

 -->