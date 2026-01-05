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

/* .table thead th {
        white-space: nowrap;
        position: sticky;
        top: 64px;
        background: #fff;
        z-index: 5;
    } */

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
                    <button id="btnCadastrar" class="btn btn-primary"><i class=""></i>
                        Marcar</button>
                </div>
            </div>

            <!-- Toolbar de filtros -->
            <?php require components('topbar-filter') ?>

            <!-- Tabela -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <!-- <table class=""> -->
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Médico</th>
                                    <th>Especialidade</th>
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
                        <h5 class="modal-title" style="display: none;"><i class="bi bi-edit-circle me-2"></i>
                            Ediar a consulta
                            Consulta
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detailBody">
                        <!-- conteúdo via JS -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        <button class="btn btn-light-info" type="button" id="btnEmitirFicha">
                            Emitir a Ficha
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal do Marccar Consulta -->
    <div class="modal fade" id="cadConsultaModal" tabindex="-1" aria-labelledby="cadConsultaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadConsultaModalLabel" style="display: block;">
                        Nova Consulta
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Visualizar  -->
                    <div id="consulta-info">

                        <?php include iViewForm('p_consulta') ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
                </div>
            </div>
        </div>
    </div>
    <script>
    let consultas = []; // começa vazio

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
            const matchesQ = state.q ? [r.medico, r.especialidade, r.clinica].some(v =>
                    String(v).toLowerCase().includes(state.q)) :
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
        tbody.innerHTML = pageItems.map(r => {
            const dt = dateFmt.format(fmtDate(r.data));
            return `<tr>
                  <td>${r.idk}</td>
                  <td>${dt}</td>
                  <td>${r.hora}</td>
                  <td>${r.medico}</td>
                  <td>${r.especialidade}</td>
                  <td>${badgeFor(r.estado)}</td>
                  <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary" data-id="${r.id}" data-action="detalhes">
                      <i class="feather icon-eye"></i> 
                    </button>
                  </td>
                </tr>`;
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
        setTimeout(() => {
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
                  <dt class="col-4">Estado</dt><dd class="col-8">${item.estado}</dd>
                  <dt class="col-4">Notas</dt><dd class="col-8">${item.notas || '-'}</dd>
                </dl>`;
        document.getElementById('detailBody').innerHTML = html;

        // Set the consultation ID on the "Emitir Ficha" button
        document.getElementById('btnEmitirFicha').dataset.consultationId = item.id;



        const modal = new bootstrap.Modal('#detailModal');
        modal.show();
    });

    // Event listener for "Emitir a Ficha" button
    document.getElementById('btnEmitirFicha').addEventListener('click', async function() {
        const consultationId = this.dataset.consultationId;

        if (!consultationId) {
            console.error('ID da consulta não encontrado para emitir a ficha.');
            alert('Não foi possível identificar a consulta. Por favor, tente novamente.');
            return;
        }

        console.log('Emitir Ficha para a consulta ID:', consultationId);

        try {
            // Replace '/api/emitir-ficha' with your actual server endpoint
            // The server will access $_SESSION for the patient ID.
            const response = await fetch('/api/emitir-ficha', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Add any authentication tokens if required by your API
                },
                body: JSON.stringify({
                    consultationId: consultationId
                })
            });

            console.log(response);
            if (!response.ok) {
                const errorResponse = await response.json(); // Assuming error responses are JSON
                throw new Error(errorResponse.error ||
                    `Erro ao emitir ficha: ${response.status} ${response.statusText}`);
            }


            const result = await response.json(); // Assuming server returns JSON

            console.log('Resposta do servidor:', result);

            if (result.fileUrl) {
                window.open(result.fileUrl, '_blank'); // Open generated PDF in new tab
            } else {
                alert(result.message || 'Ficha emitida com sucesso!');
            }

            // Close the modal after successful action
            const detailModalElement = document.getElementById('detailModal');
            const detailModal = bootstrap.Modal.getInstance(detailModalElement);
            if (detailModal) {
                detailModal.hide();
            }

        } catch (error) {
            console.error('Erro na requisição para emitir ficha:', error);
            console.log(
                `Ocorreu um erro ao tentar emitir a ficha: ${error.message || 'Por favor, tente novamente.'}`
            );
        }
    });


    // Exportar CSV
    document.getElementById('btnExport').addEventListener('click', () => {
        const filtered = applyFilters(consultas);
        const rows = [
            ['ID', 'Data', 'Hora', 'Médico', 'Especialidade', 'Clínica', 'Estado', 'Notas'],
            ...filtered.map(r => [r.id, r.data, r.hora, r.medico, r.especialidade, r.clinica, r.estado,
                r
                .notas
                ?.replace(/\n/g, ' ') || ''
            ])
        ];
        const csv = rows.map(cols => cols.map(v => `"${String(v).replaceAll('"','""')}"`).join(',')).join(
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

    function normalizeStatus(raw) {
        const s = String(raw ?? '').toLowerCase().trim();
        const map = {
            'realizado': 'concluida',
            'confirmado': 'agendada',
            'confirmada': 'agendada',
            'agendado': 'agendada',
            'cancelado': 'cancelada',
            'cancelada': 'cancelada',
            'faltou': 'faltou'
        };
        return map[s] ?? s; // se não encontrar, retorna como veio
    }

    // ====== Integração com API (async/await) ======
    /* async function carregarConsultas() {
        try {
            const resp = await fetch('http://sgh.test/api/consulta/pac-listar');
            const data = await resp.json();
            consultas.splice(1, consultas.length, ...data);
            render();
        } catch (err) {
            console.error('Erro ao carregar consultas:', err);
        }
    } */

    async function carregarConsultas() {
        try {

            const resp = await fetch('/api/consulta/pac-listar');
            const data = await resp.json();

            // normaliza o estado
            const normalizadas = data.map(item => ({
                ...item,
                estado: normalizeStatus(item.estado)
            }));

            consultas.splice(0, consultas.length, ...normalizadas);
            render();
        } catch (err) {
            console.error('Erro ao carregar consultas:', err);
        }
    }

    // Inicialização
    carregarConsultas();
    const cadBtn = document.getElementById('btnCadastrar');
    cadBtn.addEventListener('click', function() {
        const cadModal = document.getElementById('cadConsultaModal');
        const modal = new bootstrap.Modal(cadModal);
        modal.show();
    });
    document.getElementById('btnAlterar').addEventListener('click', function() {



    });
    </script>