 <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    /* --primary-color: #007A7A; */
    --primary-color: #2d007aff;
    --background-color: #F9FAFB;
    --card-bg: #FFFFFF;
    --text-primary: #1F2937;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);

    /* cores de Status */
    --status-acompanhamento: #3B82F6;
    --status-estavel: #10B981;
    --status-alta: #6B7280;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--background-color);
    margin: 0;
    color: var(--text-primary);
}

.page-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    margin: 0;
    font-size: 2rem;
}

.page-header p {
    margin: 4px 0 0 0;
    color: var(--text-secondary);
}

.page-header .btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.page-header .btn:hover {
    background-color: #005A5A;
}

.table-container {
    background-color: var(--card-bg);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 20px;
}

.table-controls {
    padding: 0 10px 20px 10px;
}

.search-box input {
    width: 100%;
    max-width: 400px;
    padding: 12px 15px;
    font-size: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-sizing: border-box;
}

.table-wrapper {
    overflow-x: auto;
}

/* Para responsividade */
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

thead th {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-secondary);
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:hover {
    background-color: #F9FAFB;
}

.patient-cell {
    display: flex;
    align-items: center;
    gap: 15px;
}

.patient-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #D1D5DB;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    flex-shrink: 0;
}

.patient-name {
    font-weight: 600;
}

.patient-id {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.status-tag {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
    background-color: var(--status-color);
}

.action-cell .btn {
    background-color: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.action-cell .btn:hover {
    background-color: var(--primary-color);
    color: white;
}

.no-results {
    text-align: center;
    padding: 60px;
    font-size: 1.2em;
    color: var(--text-secondary);
}
 </style>
 <div class="pc-container">
     <div class="pc-content">
         <!-- Breadcrumb -->
         <div class="page-header mb-3">
             <div class="page-block">
                 <div class="row align-items-center">
                     <div class="col-md-12">
                         <nav aria-label="breadcrumb">
                             <ol class="breadcrumb bg-transparent p-0 mb-2">
                                 <li class="breadcrumb-item">
                                     <a href="<?php echo root(); ?>medico/home"><i class="feather icon-home"></i> Painel
                                         Hospitalar</a>
                                 </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                     <i class="feather icon-users"></i> Gerenciar Pacientes
                                 </li>
                             </ol>
                         </nav>

                     </div>
                 </div>
             </div>
         </div>
         <!-- Tabela de Pacientes -->
         <div class="page-container">
             <header class="page-header">
                 <div>
                     <h1>Meus Pacientes</h1>
                     <p>Painel de <?= DoctorTitle($auth->genero) . " " . $auth->nome ?></p>
                 </div>
                 <button class="btn" id="btnPrint">
                     Imprimir
                 </button>
             </header>

             <div class="table-container">
                 <div class="table-controls">
                     <div class="search-box">
                         <input type="search" id="search-input" placeholder="Buscar por nome ou diagnóstico...">
                     </div>
                 </div>
                 <div class="table-wrapper">
                     <table>
                         <thead>
                             <tr>
                                 <th>Paciente</th>
                                 <th>Última Consulta</th>
                                 <th>Diagnóstico Principal</th>
                                 <th>Status</th>
                                 <th>Ações</th>
                             </tr>
                         </thead>
                         <tbody id="patient-table-body">
                             <!-- Linhas da tabela serão inseridas aqui -->
                         </tbody>
                     </table>
                 </div>
                 <div id="no-results" class="no-results" style="display: none;">Nenhum paciente encontrado.</div>
             </div>
         </div>

     </div>
 </div>

 <!--  -->
 <!--  -->
 <div class="modal fade" id="CadastraModal" tabindex="-1" aria-labelledby="CadastraModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="CadastraModalLabel" style="display: block;"> <i
                         class="feather icon-user-plus me-2"></i> Cadastro de Novo Paciente
                 </h1>
                 <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Form de Create -->
                 <!-- <div class="card shadow-lg border-0 col-sm-12 col-md-8 offset-md-2 mt-5 rounded-2"> -->
                 <form id="paciente-store" method="post" autocomplete="off">
                     <!-- class="needs-validation" novalidate -->
                     <div class="card-body px-4 py-4">
                         <div id="msg"></div>

                         <div class="mb-4">
                             <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
                             <hr>
                             <?php include iViewForm('paciente-medico') ?>
                         </div>
                         <input type="hidden" name="medico_id" value="<?= $userPerfil->id ?>">

                         <div class="card-footer text-center bg-light ">
                             <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
                                 <i class="feather icon-save me-2"></i>Salvar Cadastro
                             </button>
                         </div>
                 </form>
             </div>
             <!-- Form de Create END-->
         </div>
         <div class="modal-footer">
             <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
         </div>
     </div>
 </div>
 </div>
 <script>
let pacientes = [];

const tableBody = document.getElementById('patient-table-body');
const searchInput = document.getElementById('search-input');
const noResultsDiv = document.getElementById('no-results');

function getStatusClass(status) {
    return status.toLowerCase().replace(' ', '-');
}

function getInitials(name) {
    const parts = name.split(' ');
    return parts.length > 1 ? parts[0][0] + parts[parts.length - 1][0] : name.substring(0, 2);
}

function renderizarPacientes(lista) {
    tableBody.innerHTML = '';
    noResultsDiv.style.display = lista.length === 0 ? 'block' : 'none';

    for (const paciente of lista) {
        const statusClass = getStatusClass(paciente.status);
        const statusColorVar = `var(--status-${statusClass})`;
        const dataFormatada = new Date(paciente.ultimaConsulta + 'T00:00:00').toLocaleDateString('pt-BR');

        const row = document.createElement('tr');
        row.innerHTML = `
                <td>
                    <div class="patient-cell">
                        <div class="patient-avatar">${getInitials(paciente.nome)}</div>
                        <div>
                            <div class="patient-name">${paciente.nome}</div>
                            <div class="patient-id">ID: ${paciente.id} <br> <small>${paciente.email}</small></div>

                        </div>
                    </div>
                </td>
                <td>${dataFormatada}</td>
                <td>${paciente.diagnostico}</td>
                <td>
                    <span class="status-tag" style="--status-color: ${statusColorVar};">
                        ${paciente.status}
                    </span>
                </td>
                <td class="action-cell">
                    <button class="btn">Ver Prontuário</button>
                </td>
            `;
        tableBody.appendChild(row);
    }
}

function atualizarVisualizacao() {
    const termoBusca = searchInput.value.toLowerCase();
    const listaFiltrada = pacientes.filter(p =>
        p.nome.toLowerCase().includes(termoBusca) ||
        (p.diagnostico || '').toLowerCase().includes(termoBusca)
    );
    renderizarPacientes(listaFiltrada);
}

searchInput.addEventListener('input', atualizarVisualizacao);

async function carregarPacientes() {
    try {
        const resposta = await fetch('/medico/api/paciente');
        if (!resposta.ok) throw new Error('Erro ao buscar pacientes');

        pacientes = await resposta.json();
        renderizarPacientes(pacientes);
    } catch (erro) {
        console.error('Erro ao carregar pacientes:', erro);
        noResultsDiv.innerText = 'Erro ao carregar dados.';
        noResultsDiv.style.display = 'block';
    }
}

carregarPacientes();
 </script>