 <div class="pc-container">
     <div class="pc-content">
         <div class="card text-center p-4">
             <h5 class="card-title mb-3">Pesquisar Paciente</h5>
             <form id="formPesquisa" class="d-flex justify-content-center">
                 <input type="text" id="pesquisa" class="form-control search-input" placeholder="Pesquisar Cliente..."
                     aria-label="Pesquisar Cliente">
                 <button class="btn btn-primary search-btn" type="submit">
                     <i class="cil-magnifying-glass"></i> Pesquisar
                 </button>
             </form>
         </div>

         <div class="table-container" id="resultadoContainer">
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title">Resultados</h5>
                     <table class="table table-striped table-hover align-middle">
                         <thead class="table-light">
                             <tr>
                                 <th>Nome</th>
                                 <th>Idade</th>
                                 <th>Contacto</th>
                                 <th>Endereço</th>
                                 <th>Acao</th>
                             </tr>
                         </thead>
                         <tbody id="tabelaResultados">
                             <!-- Dados carregados via fetch -->
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

     </div>
 </div>
 <script>
const input = document.querySelector('#pesquisa');
const form = document.querySelector('#formPesquisa');
const tabela = document.querySelector('#tabelaResultados');
const container = document.querySelector('#resultadoContainer');
let timeout = null;

// ====== Função para buscar pacientes na API REST ======
async function buscarPacientes(query) {
    try {
        const response = await fetch(`/api/recepcao/paciente/nome/${encodeURIComponent(query)}`);

        if (!response.ok) throw new Error("Erro ao consultar API");

        const data = await response.json();

        // console.log(data);
        renderResultados(data);
    } catch (err) {
        console.error(err);
        renderResultados([]);
    }
}

// ====== Renderização da Tabela ======
function renderResultados(resultados) {
    tabela.innerHTML = "";

    if (!resultados || resultados.length === 0) {
        tabela.innerHTML =
            `<tr><td colspan="5" class="text-center text-muted">Nenhum paciente encontrado</td></tr>`;
    } else {
        resultados.forEach(p => {
            tabela.innerHTML += `
            <tr>
              <td>${p.nome}</td>
              <td>${p.idade}</td>
              <td>${p.telefone}</td>
              <td>${p.endereco}</td>
              <td><td>
            </tr>
          `;
        });
    }

    container.style.display = "block";
}

// ====== Busca Automática (após 3 caracteres) ======
input.addEventListener('input', () => {
    clearTimeout(timeout);
    const valor = input.value.trim();

    if (valor.length >= 3) {
        timeout = setTimeout(() => {
            buscarPacientes(valor);
        }, 400);
    }
});

// ====== Busca Manual (botão) ======
form.addEventListener('submit', (e) => {
    e.preventDefault();
    const valor = input.value.trim();
    if (valor.length === 0) return;
    buscarPacientes(valor);
});
 </script>