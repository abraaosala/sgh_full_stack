    <style>
body {
    background: #f6f7fb;
}

.page-title {
    font-weight: 700;
    letter-spacing: .3px;
}

.toolbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #f6f7fb;
    padding-top: 1rem;
}

.table thead th {
    white-space: nowrap;
    position: sticky;
    top: 64px;
    background: #fff;
    z-index: 5;
}

.status-badge {
    text-transform: capitalize;
}

.table-responsive {
    max-height: 70vh;
}

.form-check-input {
    cursor: pointer;
}

.cursor-pointer {
    cursor: pointer;
}
    </style>
    </head>

    <div class="pc-container" id="medico_agenda">
        <div class="pc-content">

            <div class="container py-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="page-title h3 mb-0"><i class="bi bi-journal-medical me-2"></i> Minhas Consultas</h1>
                    <div class="d-flex gap-2">
                        <button id="btnExport" class="btn btn-outline-secondary"><i class="bi bi-download"></i> Exportar
                            CSV</button>
                        <button id="btnPrint" class="btn btn-primary"><i class="bi bi-printer"></i> Imprimir</button>
                    </div>
                </div>

                <!-- Toolbar de filtros -->
                <div class="toolbar">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <form id="filters" class="row g-3 align-items-end">
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="q">Buscar</label>
                                    <input type="search" id="q" class="form-control"
                                        placeholder="Médico, especialidade, clínica…" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label" for="status">Estado</label>
                                    <select id="status" class="form-select">
                                        <option value="">Todos</option>
                                        <option value="agendada">Agendada</option>
                                        <option value="concluida">Concluída</option>
                                        <option value="cancelada">Cancelada</option>
                                        <option value="faltou">Faltou</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-2">
                                    <label class="form-label" for="de">De</label>
                                    <input type="date" id="de" class="form-control" />
                                </div>
                                <div class="col-6 col-md-2">
                                    <label class="form-label" for="ate">Até</label>
                                    <input type="date" id="ate" class="form-control" />
                                </div>
                                <div class="col-6 col-md-1 d-grid">
                                    <button type="reset" class="btn btn-light border"><i class="bi bi-x-circle"></i>
                                        Limpar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Médico</th>
                                        <th>Especialidade</th>
                                        <th>Clínica</th>
                                        <th>Estado</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex flex-wrap gap-2 align-items-center justify-content-between">
                        <div class="small text-muted" id="countInfo">0 consultas</div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="small me-2" for="perPage">Por página</label>
                            <select id="perPage" class="form-select form-select-sm w-auto">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Detalhes -->
            <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detalhes da Consulta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="detailBody">
                            <!-- conteúdo via JS -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
// ====== MOCK: Substitua pelo fetch à sua API ======
const consultas = [{
        id: 101,
        data: '2025-09-01',
        hora: '09:00',
        medico: 'Dra. Sofia Almeida',
        especialidade: 'Pneumologia',
        clinica: 'Hospital Municipal do Soyo',
        estado: 'concluida',
        notas: 'Retorno em 3 meses.'
    },
    {
        id: 102,
        data: '2025-09-05',
        hora: '14:30',
        medico: 'Dr. João Silva',
        especialidade: 'Clínica Geral',
        clinica: 'Clínica Boa Saúde',
        estado: 'agendada',
        notas: 'Levar exames anteriores.'
    },
    {
        id: 103,
        data: '2025-08-28',
        hora: '11:00',
        medico: 'Dra. Helena Cruz',
        especialidade: 'Cardiologia',
        clinica: 'CUAM Soyo',
        estado: 'cancelada',
        notas: 'Cancelada pelo paciente.'
    },
    {
        id: 104,
        data: '2025-08-12',
        hora: '15:15',
        medico: 'Dr. Miguel Neto',
        especialidade: 'Ortopedia',
        clinica: 'Clínica Nova Vida',
        estado: 'concluida',
        notas: 'Reabilitação recomendada.'
    },
    {
        id: 105,
        data: '2025-09-07',
        hora: '10:45',
        medico: 'Dra. Carla Pires',
        especialidade: 'Dermatologia',
        clinica: 'Policlínica Central',
        estado: 'agendada',
        notas: 'Chegar 10 min antes.'
    },
    {
        id: 106,
        data: '2025-07-22',
        hora: '08:30',
        medico: 'Dr. Paulo Ramos',
        especialidade: 'Oftalmologia',
        clinica: 'Visão Plena',
        estado: 'concluida',
        notas: 'Troca de lentes.'
    },
    {
        id: 107,
        data: '2025-07-18',
        hora: '13:00',
        medico: 'Dra. Beatriz Luz',
        especialidade: 'Ginecologia',
        clinica: 'Saúde Mulher',
        estado: 'faltou',
        notas: 'Paciente não compareceu.'
    },
    {
        id: 108,
        data: '2025-09-03',
        hora: '16:00',
        medico: 'Dr. Luís Matias',
        especialidade: 'Neurologia',
        clinica: 'NeuroCare',
        estado: 'agendada',
        notas: 'Avaliar enxaquecas.'
    },
    {
        id: 109,
        data: '2025-08-05',
        hora: '09:30',
        medico: 'Dra. Rita Moura',
        especialidade: 'Endocrinologia',
        clinica: 'Endo+ Soyo',
        estado: 'concluida',
        notas: 'Revisão de medicação.'
    },
    {
        id: 110,
        data: '2025-06-30',
        hora: '12:00',
        medico: 'Dr. André Costa',
        especialidade: 'Urologia',
        clinica: 'Clínica Alfa',
        estado: 'concluida',
        notas: 'Solicitados exames.'
    },
    {
        id: 111,
        data: '2025-09-10',
        hora: '08:00',
        medico: 'Dra. Tânia Lopes',
        especialidade: 'Otorrinolaringologia',
        clinica: 'OtoSoluções',
        estado: 'agendada',
        notas: 'Primeira consulta.'
    },
    {
        id: 112,
        data: '2025-09-02',
        hora: '17:10',
        medico: 'Dr. Tiago Faria',
        especialidade: 'Fisiatria',
        clinica: 'Rehab+ Center',
        estado: 'concluida',
        notas: 'Alta concedida.'
    },
];

// ====== Estado da UI ======
const state = {
    page: 1,
    perPage: 10,
    q: '',
    status: '',
    de: '',
    ate: '',
};

const tbody = document.getElementById('tbody');
const pagination = document.getElementById('pagination');
const countInfo = document.getElementById('countInfo');

// ====== Helpers ======
const fmtDate = (iso) => new Date(iso + 'T00:00:00');
const dateFmt = new Intl.DateTimeFormat('pt-PT', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
});

function badgeFor(status) {
    const map = {
        agendada: 'info',
        concluida: 'success',
        cancelada: 'secondary',
        faltou: 'danger',
    };
    const cls = map[status] || 'light';
    const label = status.charAt(0).toUpperCase() + status.slice(1);
    return `<span class="badge bg-${cls} status-badge">${label}</span>`;
}

function applyFilters(data) {
    return data.filter(r => {
        const matchesQ = state.q ? [r.medico, r.especialidade, r.clinica].some(v => String(v)
                .toLowerCase().includes(state.q)) :
            true;
        const matchesStatus = state.status ? r.estado === state.status : true;
        const fromOk = state.de ? fmtDate(r.data) >= fmtDate(state.de) : true;
        const toOk = state.ate ? fmtDate(r.data) <= fmtDate(state.ate) : true;
        return matchesQ && matchesStatus && fromOk && toOk;
    }).sort((a, b) => a.data.localeCompare(b.data));
}

function paginate(data) {
    const start = (state.page - 1) * state.perPage;
    return data.slice(start, start + state.perPage);
}

function render() {
    const filtered = applyFilters(consultas);
    const pageItems = paginate(filtered);

    // corpo
    tbody.innerHTML = pageItems.map((r, idx) => {
        const dt = dateFmt.format(fmtDate(r.data));
        return `<tr>
          <td>${r.id}</td>
          <td>${dt}</td>
          <td>${r.hora}</td>
          <td>${r.medico}</td>
          <td>${r.especialidade}</td>
          <td>${r.clinica}</td>
          <td>${badgeFor(r.estado)}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-primary" data-id="${r.id}" data-action="detalhes">
              <i class="bi bi-eye"></i> Ver
            </button>
          </td>
        </tr>`
    }).join('');

    // contagem
    countInfo.textContent = `${filtered.length} consulta${filtered.length === 1 ? '' : 's'}`;

    // paginação
    const totalPages = Math.max(1, Math.ceil(filtered.length / state.perPage));
    state.page = Math.min(state.page, totalPages);
    pagination.innerHTML = '';

    const makeItem = (label, page, disabled = false, active = false) => `
        <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
          <a class="page-link" href="#" data-page="${page}">${label}</a>
        </li>`;

    pagination.insertAdjacentHTML('beforeend', makeItem('«', state.page - 1, state.page === 1));
    for (let p = 1; p <= totalPages; p++) {
        pagination.insertAdjacentHTML('beforeend', makeItem(String(p), p, false, p === state.page));
    }
    pagination.insertAdjacentHTML('beforeend', makeItem('»', state.page + 1, state.page === totalPages));
}

// ====== Eventos UI ======
document.getElementById('q').addEventListener('input', (e) => {
    state.q = e.target.value.trim().toLowerCase();
    state.page = 1;
    render();
});
document.getElementById('status').addEventListener('change', (e) => {
    state.status = e.target.value;
    state.page = 1;
    render();
});
document.getElementById('de').addEventListener('change', (e) => {
    state.de = e.target.value;
    state.page = 1;
    render();
});
document.getElementById('ate').addEventListener('change', (e) => {
    state.ate = e.target.value;
    state.page = 1;
    render();
});
document.getElementById('perPage').addEventListener('change', (e) => {
    state.perPage = Number(e.target.value);
    state.page = 1;
    render();
});

document.getElementById('filters').addEventListener('reset', () => {
    setTimeout(() => { // aguarda reset do form
        state.q = '';
        state.status = '';
        state.de = '';
        state.ate = '';
        state.page = 1;
        render();
    }, 0);
});

pagination.addEventListener('click', (e) => {
    const link = e.target.closest('a.page-link');
    if (!link) return;
    e.preventDefault();
    const p = Number(link.dataset.page);
    if (!Number.isFinite(p) || p < 1) return;
    state.page = p;
    render();
});

// Abrir detalhes
tbody.addEventListener('click', (e) => {
    const btn = e.target.closest('button[data-action="detalhes"]');
    if (!btn) return;
    const id = Number(btn.dataset.id);
    const item = consultas.find(c => c.id === id);
    if (!item) return;
    const dt = dateFmt.format(fmtDate(item.data));
    const html = `
        <dl class="row mb-0">
          <dt class="col-4">Identificador</dt><dd class="col-8">${item.id}</dd>
          <dt class="col-4">Data</dt><dd class="col-8">${dt}</dd>
          <dt class="col-4">Hora</dt><dd class="col-8">${item.hora}</dd>
          <dt class="col-4">Médico</dt><dd class="col-8">${item.medico}</dd>
          <dt class="col-4">Especialidade</dt><dd class="col-8">${item.especialidade}</dd>
          <dt class="col-4">Clínica</dt><dd class="col-8">${item.clinica}</dd>
          <dt class="col-4">Estado</dt><dd class="col-8">${item.estado}</dd>
          <dt class="col-4">Notas</dt><dd class="col-8">${item.notas || '-'}</dd>
        </dl>`;
    document.getElementById('detailBody').innerHTML = html;
    const modal = new bootstrap.Modal('#detailModal');
    modal.show();
});

// Exportar CSV (dados filtrados)
document.getElementById('btnExport').addEventListener('click', () => {
    const filtered = applyFilters(consultas);
    const rows = [
        ['ID', 'Data', 'Hora', 'Médico', 'Especialidade', 'Clínica', 'Estado', 'Notas'],
        ...filtered.map(r => [r.id, r.data, r.hora, r.medico, r.especialidade, r.clinica, r
            .estado,
            r
            .notas?.replace(/\n/g, ' ') || ''
        ])
    ];
    const csv = rows.map(cols => cols.map(v => `"${String(v).replaceAll('"','""')}"`).join(','))
        .join(
            '\n');
    const blob = new Blob([csv], {
        type: 'text/csv;charset=utf-8;'
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'consultas.csv';
    a.click();
    URL.revokeObjectURL(url);
});

// Imprimir
document.getElementById('btnPrint').addEventListener('click', () => window.print());

// ====== Integração com API (exemplo) ======
// Substitua o array "consultas" por um fetch ao seu endpoint:
// fetch('/api/paciente/consultas')
//   .then(r => r.json())
//   .then(data => { consultas.splice(0, consultas.length, ...data); render(); });

// Inicialização
render();
    </script>