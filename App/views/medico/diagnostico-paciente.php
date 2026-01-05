<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --primary-color: #007A7A;
    --background-color: #F9FAFB;
    --card-bg: #FFFFFF;
    --text-primary: #1F2937;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);

    /* cores de Status para o Diagnóstico */
    --status-ativo: #EF4444;
    /* Vermelho para atenção */
    --status-em-tratamento: #3B82F6;
    /* Azul */
    --status-controlado: #10B981;
    /* Verde */
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
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}

.page-header h1 {
    margin: 0;
    font-size: 2rem;
}

.page-header .diagnosis-tag {
    font-size: 1.5rem;
    font-weight: 600;
    padding: 5px 15px;
    background-color: #e0f2f2;
    color: var(--primary-color);
    border-radius: 8px;
}

.back-button {
    background: none;
    border: 1px solid var(--border-color);
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

.back-button:hover {
    background-color: #f3f4f6;
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
}

/* Define explicit classes for status colors */
.status-tag.ativo {
    background-color: var(--status-ativo);
}

.status-tag.em-tratamento {
    background-color: var(--status-em-tratamento);
}

.status-tag.controlado {
    background-color: var(--status-controlado);
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

        <div class="page-container">
            <header class="page-header">
                <a href="<?=root()?>medico/diagnosticos" class="back-button" title="Voltar para Todos Dignosticos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1>Pacientes com</h1>
                <span class="diagnosis-tag" id="doencas"></span>
            </header>

            <div class="table-container">
                <div class="table-controls">
                    <div class="search-box">
                        <input type="search" id="search-input" placeholder="Buscar paciente nesta lista...">
                    </div>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Data do Diagnóstico</th>
                                <th>Status do Diagnóstico</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="patient-table-body">
                            <!-- Linhas da tabela serão inseridas aqui -->
                        </tbody>
                    </table>
                </div>
                <div id="no-results" class="no-results" style="display: none;">Nenhum paciente encontrado com este
                    diagnóstico.</div>
            </div>
        </div>

        <script>
        const tableBody = document.getElementById('patient-table-body');
        const searchInput = document.getElementById('search-input');
        const noResultsDiv = document.getElementById('no-results');

        let pacientesCache = []; // 🔹 Guardar pacientes para não chamar API toda hora

        function getStatusClass(status) {
            const normalizedStatus = status.toLowerCase().replace(/\s/g, '-');
            const validStatuses = ['ativo', 'em-tratamento', 'controlado'];
            return validStatuses.includes(normalizedStatus) ? normalizedStatus : '';
        }

        function getInitials(name) {
            const parts = name.split(' ');
            if (parts.length > 1) {
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            } else if (name.length > 0) {
                return name.substring(0, 2).toUpperCase();
            }
            return '';
        }

        // 🔹 Busca na API
        async function diagnosticosDoenca() {
            const params = new URLSearchParams(window.location.search);
            const id = params.get("id");

            try {
                const response = await fetch(`http://sgh.test/api/diagnostico/doenca/${id}`);
                if (!response.ok) throw new Error("Erro ao buscar API");
                return await response.json();
            } catch (error) {
                console.error("Erro:", error);
                return {
                    doenca: "Desconhecida",
                    pacientes: []
                };
            }
        }

        // 🔹 Renderiza pacientes
        function renderizarPacientes(pacientes) {
            tableBody.innerHTML = '';
            noResultsDiv.style.display = pacientes.length === 0 ? 'block' : 'none';

            for (const item of pacientes) {
                // *** REVERTED CHANGES - NOW USING item.dataDiagnostico and item.statusDiagnostico correctly ***
                const statusText = item.statusDiagnostico; // This is 'Controlado', 'Ativo', etc.
                const statusClass = getStatusClass(statusText); // For CSS class (e.g., 'controlado')

                // Correctly format the date from item.dataDiagnostico
                const dataFormatada = new Date(item.dataDiagnostico + 'T00:00:00').toLocaleDateString('pt-BR');
                // *** END REVERTED CHANGES ***

                const row = document.createElement('tr');
                row.innerHTML = `
                        <td>
                            <div class="patient-cell">
                                <div class="patient-avatar">${getInitials(item.pacienteNome)}</div>
                                <div>
                                    <div class="patient-name">${item.pacienteNome}</div>
                                    <div class="patient-id">ID: ${item.pacienteId}</div>
                                </div>
                            </div>
                        </td>
                        <td>${dataFormatada}</td>
                        <td>
                            <span class="status-tag ${statusClass}">
                                ${statusText}
                            </span>
                        </td>
                        <td class="action-cell">
                            <button class="btn">Ver Prontuário</button>
                        </td>
                    `;
                tableBody.appendChild(row);
            }
        }

        // 🔹 Filtra pacientes no cache
        function atualizarVisualizacao() {
            const termoBusca = searchInput.value.toLowerCase();
            const listaFiltrada = termoBusca ?
                pacientesCache.filter(p => p.pacienteNome.toLowerCase().includes(termoBusca) || p.pacienteId
                    .toLowerCase().includes(termoBusca)) :
                pacientesCache;

            renderizarPacientes(listaFiltrada);
        }

        // 🔹 Inicialização
        (async () => {
            const lista = await diagnosticosDoenca();

            document.getElementById("doencas").textContent = lista.doenca || "Doença não informada";

            pacientesCache = lista.pacientes || [];

            renderizarPacientes(pacientesCache);
        })();

        // 🔹 Busca em tempo real
        searchInput.addEventListener('input', atualizarVisualizacao);
        </script>
    </div>
</div>