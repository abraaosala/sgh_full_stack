 <div class="pc-container" >
   <div class="pc-content">
    <!-- CSS Incorporado -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #007A7A; /* Um verde-azulado sóbrio, bom para saúde */
            --background-color: #F8F9FA;
            --card-bg: #FFFFFF;
            --text-primary: #1A202C;
            --text-secondary: #718096;
            --border-color: #E2E8F0;
            --shadow-color: rgba(0, 0, 0, 0.05);

            /* cores de Status */
            --status-disponivel: #10B981; /* Verde esmeralda */
            --status-pendente: #F59E0B;   /* Ambar */
            --status-visualizado: #6366F1; /* Indigo */
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

        .content-header { text-align: center; margin-bottom: 30px; }
        .content-header h1 { margin: 0; font-size: 2.25rem; }
        .content-header p { margin: 8px 0 0 0; color: var(--text-secondary); font-size: 1.1rem; }

        /* --- Controles de Filtro e Pesquisa --- */
        .controls-container {
            display: flex;
            flex-wrap: wrap; /* Garante responsividade */
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 15px;
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .search-box { flex: 1; min-width: 250px; }
        .search-box input {
            width: 100%; padding: 12px 15px; font-size: 1rem;
            border: 1px solid var(--border-color); border-radius: 8px;
            box-sizing: border-box; transition: all 0.2s;
        }
        .search-box input:focus {
            outline: none; border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 122, 122, 0.2);
        }

        .filter-controls { display: flex; background-color: #f0f2f5; border-radius: 8px; padding: 4px; }
        .filter-controls input[type="radio"] { display: none; }
        .filter-controls label {
            padding: 8px 18px; font-size: 0.9rem; font-weight: 500;
            color: var(--text-secondary); cursor: pointer; border-radius: 6px;
            transition: all 0.25s ease-out;
        }
        .filter-controls input:checked + label {
            background-color: var(--card-bg); color: var(--primary-color); font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        }

        /* --- Grid de Resultados --- */
        #exam-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .exam-card {
            background-color: var(--card-bg); border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px var(--shadow-color);
            border-top: 5px solid var(--status-color, var(--border-color));
            padding: 20px; display: flex; flex-direction: column;
            justify-content: space-between; transition: transform 0.2s, box-shadow 0.2s;
        }
        .exam-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px var(--shadow-color); }
        
        .card-header { display: flex; gap: 15px; align-items: flex-start; }
        .card-icon {
            flex-shrink: 0; width: 40px; height: 40px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background-color: var(--status-color, var(--border-color));
        }
        .card-icon svg { width: 24px; height: 24px; color: white; }
        .card-title h3 { margin: 0; font-size: 1.1rem; }
        .card-title p { margin: 4px 0 0 0; font-size: 0.9rem; color: var(--text-secondary); }

        .card-footer { margin-top: 20px; text-align: right; }
        .card-footer .btn {
            background-color: var(--primary-color); color: white; border: none;
            border-radius: 8px; padding: 10px 20px; font-weight: 600;
            cursor: pointer; transition: background-color 0.2s;
        }
        .card-footer .btn:disabled { background-color: #D1D5DB; color: #6B7280; cursor: not-allowed; }
        .no-results { text-align: center; padding: 60px; font-size: 1.2em; color: var(--text-secondary); grid-column: 1 / -1; }
    </style>


    <div class="page-container">
        <header class="content-header">
            <h1>Painel de Exames Respiratórios</h1>
            <p id="results-counter">Acesse o histórico e o status dos seus exames.</p>
        </header>

        <div class="controls-container">
            <div class="search-box">
                <input type="search" id="search-input" placeholder="Pesquisar exames...">
            </div>
            <div class="filter-controls">
                <input type="radio" id="filter-todos" name="status-filter" value="Todos" checked>
                <label for="filter-todos">Todos</label>

                <input type="radio" id="filter-disponivel" name="status-filter" value="Disponível">
                <label for="filter-disponivel">Disponíveis</label>

                <input type="radio" id="filter-pendente" name="status-filter" value="Pendente">
                <label for="filter-pendente">Pendentes</label>
                
                <input type="radio" id="filter-visualizado" name="status-filter" value="Visualizado">
                <label for="filter-visualizado">Visualizados</label>
            </div>
        </div>

        <div id="exam-grid"></div>
        <div id="no-results" class="no-results" style="display: none;">Nenhum exame encontrado.</div>
    </div>

    <script>
        const exames = [
            { id: 1, dataColeta: "2025-08-22", tipoExame: "PCR para COVID-19 e Influenza", status: "Disponível" },
            { id: 2, dataColeta: "2025-08-22", tipoExame: "Raio-X do Tórax", status: "Pendente" },
            { id: 3, dataColeta: "2025-08-19", tipoExame: "Espirometria (Prova de Função)", status: "Visualizado" },
            { id: 4, dataColeta: "2025-08-19", tipoExame: "Tomografia Computadorizada", status: "Visualizado" },
            { id: 5, dataColeta: "2025-08-23", tipoExame: "Gasometria Arterial", status: "Pendente" },
            { id: 6, dataColeta: "2025-07-30", tipoExame: "Cultura de Escarro", status: "Visualizado" },
            { id: 7, dataColeta: "2025-08-24", tipoExame: "Teste de Alergia (IgE Específico)", status: "Disponível" }
        ];
        
        const gridContainer = document.getElementById('exam-grid');
        const noResultsDiv = document.getElementById('no-results');
        const filterControls = document.querySelector('.filter-controls');
        const searchInput = document.getElementById('search-input');
        const resultsCounter = document.getElementById('results-counter');

        const icons = {
            disponível: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            pendente: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            visualizado: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`
        };

        function renderizarExames(listaExames) {
            noResultsDiv.style.display = listaExames.length === 0 ? 'block' : 'none';
            gridContainer.innerHTML = '';

            resultsCounter.textContent = `${listaExames.length} resultado(s) encontrado(s).`;

            const examesOrdenados = listaExames.sort((a,b) => new Date(b.dataColeta) - new Date(a.dataColeta));
            
            for (const exame of examesOrdenados) {
                const statusClass = exame.status.toLowerCase();
                const isPendente = statusClass === 'pendente';
                const dataFormatada = new Date(exame.dataColeta + 'T00:00:00').toLocaleDateString('pt-BR', {day: '2-digit', month: '2-digit', year: 'numeric'});

                const card = document.createElement('div');
                card.className = 'exam-card';
                card.style.setProperty('--status-color', `var(--status-${statusClass})`);
                
                card.innerHTML = `
                    <div class="card-header">
                        <div class="card-icon">${icons[statusClass] || ''}</div>
                        <div class="card-title">
                            <h3>${exame.tipoExame}</h3>
                            <p>Coleta em: ${dataFormatada}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn" ${isPendente ? 'disabled' : ''}>
                            ${isPendente ? 'Pendente' : 'Ver Resultado'}
                        </button>
                    </div>
                `;
                gridContainer.appendChild(card);
            }
        }
        
        function atualizarVisualizacao() {
            const filtroStatus = document.querySelector('input[name="status-filter"]:checked').value;
            const termoBusca = searchInput.value.toLowerCase();
            let listaFiltrada = exames;

            if (filtroStatus !== 'Todos') {
                listaFiltrada = listaFiltrada.filter(e => e.status === filtroStatus);
            }
            if (termoBusca) {
                listaFiltrada = listaFiltrada.filter(e => e.tipoExame.toLowerCase().includes(termoBusca));
            }
            renderizarExames(listaFiltrada);
        }

        filterControls.addEventListener('change', atualizarVisualizacao);
        searchInput.addEventListener('input', atualizarVisualizacao);

        atualizarVisualizacao();
    </script>

   </div>
 </div>