 <style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

:root {
    --primary-color: #007A7A;
    --background-color: #F8F9FA;
    --card-bg: #FFFFFF;
    --text-primary: #1F2937;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    margin: 0;
    font-size: 2.25rem;
}

.page-header p {
    margin: 8px 0 0 0;
    color: var(--text-secondary);
    font-size: 1.1rem;
}

.diagnosis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.diagnosis-card {
    background-color: var(--card-bg);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    padding: 25px;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}

.diagnosis-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e0f2f2;
    /* Cor de fundo do ícone */
    margin-bottom: 20px;
}

.card-icon svg {
    width: 28px;
    height: 28px;
    color: var(--primary-color);
}

.card-content h3 {
    margin: 0;
    font-size: 1.25rem;
}

.card-content p {
    margin: 8px 0 0 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

.card-footer {
    margin-top: auto;
    /* Empurra para o final */
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-stats {
    font-size: 1.1rem;
    font-weight: 600;
}

.card-stats span {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.card-footer a {
    background-color: var(--primary-color);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: background-color 0.2s;
}

.card-footer a:hover {
    background-color: #005A5A;
}
 </style>
 <div class="pc-container">
     <div class="pc-content">

         <div class="page-container">


             <div class="diagnosis-grid" id="diagnosis-grid">
                 <!-- Cards serão inseridos aqui pelo JavaScript -->
             </div>
         </div>

         <script>
         // const root= <?php json_encode(root())?>;
         const root = '/';
         async function renderizarDiagnosticos() {
             // Espera os dados da API serem carregados
             const diagnosticos = await Diagnosticos();

             // Acha o container para adicionar os cards
             const gridContainer = document.getElementById('diagnosis-grid');
             gridContainer.innerHTML = ''; // Limpa o conteúdo anterior

             // Cria os cards com base nos dados carregados
             for (const diagnostico of diagnosticos) {
                 const card = document.createElement('div');
                 card.className = 'diagnosis-card';
                 card.innerHTML = `
        <div class="card-icon">
            <i data-feather="${diagnostico.icon}"></i>
        </div>
        <div class="card-content">
            <h3>${diagnostico.nome}</h3>
            <p>${diagnostico.descricao}</p>
        </div>
        <div class="card-footer">
            <div class="card-stats">
                ${diagnostico.pacientesAtivos}
                <span>pacientes</span>
            </div>
            <a href="${root}medico/diagnostico?id=${diagnostico.id}">Ver Pacientes</a>
        </div>
    `;
                 gridContainer.appendChild(card);
             }

             // Inicializa os ícones Feather
             feather.replace();


         }

         // Função para carregar os dados da API
         async function Diagnosticos() {
             const response = await fetch('http://sgh.test/api/diagnostico');
             const result = await response.json();
             return result; // Retorna os dados obtidos
         }

         // Chama a função de renderização
         renderizarDiagnosticos();
         </script>
     </div>
 </div>''