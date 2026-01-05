<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico Médico - Problemas Respiratórios</title>

    <style>
    /* ------------------------------------------------------------------- */
    /* 1. ESTILOS GERAIS */
    /* ------------------------------------------------------------------- */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7f9;
        color: #333;
        margin: 0;
        padding: 20px;
    }

    .container-diagnostico {
        max-width: 900px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* ------------------------------------------------------------------- */
    /* 2. CABEÇALHO E SEÇÕES */
    /* ------------------------------------------------------------------- */
    .cabecalho {
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .cabecalho h1 {
        color: #007bff;
        font-size: 1.8em;
        margin: 0;
    }

    .cabecalho p {
        color: #666;
        font-size: 0.9em;
    }

    .secao {
        margin-bottom: 25px;
        padding: 15px 0;
    }

    .secao h2 {
        color: #0056b3;
        font-size: 1.4em;
        margin-bottom: 15px;
        border-left: 4px solid #007bff;
        padding-left: 10px;
    }

    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 20px 0;
    }

    /* ------------------------------------------------------------------- */
    /* 3. ESTILOS DE FORMULÁRIO (INPUTS E TEXTAREAS) */
    /* ------------------------------------------------------------------- */
    .campo-grupo {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #444;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 1em;
        transition: border-color 0.3s;
    }

    input:focus,
    textarea:focus {
        border-color: #007bff;
        outline: none;
    }

    textarea {
        resize: vertical;
    }

    /* Estilo para Checkboxes (Fatores de Risco) */
    .campo-grupo input[type="checkbox"] {
        margin-right: 5px;
    }

    .campo-grupo label[for] {
        font-weight: normal;
        display: inline-block;
        margin-right: 15px;
    }

    /* ------------------------------------------------------------------- */
    /* 4. LAYOUT DE COLUNAS (PARA SINAIS VITAIS) */
    /* ------------------------------------------------------------------- */
    .campo-linha {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .campo-pequeno {
        flex: 1;
    }

    /* ------------------------------------------------------------------- */
    /* 5. RODAPÉ E BOTÕES */
    /* ------------------------------------------------------------------- */
    .rodape-acoes {
        padding-top: 20px;
        border-top: 1px solid #eee;
        text-align: right;
    }

    .rodape-acoes button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 10px;
        transition: background-color 0.3s;
    }

    .botao-salvar {
        background-color: #28a745;
        color: white;
    }

    .botao-salvar:hover {
        background-color: #218838;
    }

    .botao-exames {
        background-color: #6c757d;
        color: white;
    }

    .botao-exames:hover {
        background-color: #5a6268;
    }
    </style>
</head>

<body>

    <header class="cabecalho">
        <h1>Diagnóstico do Paciente</h1>
        <p>Paciente: [Nome do Paciente] | ID: [00000] | Data: [DD/MM/AAAA]</p>
    </header>

    <main class="container-diagnostico">

        <section class="secao historico">
            <h2>1. Anamnese e Histórico</h2>

            <div class="campo-grupo">
                <label for="queixa-principal">Queixa Principal:</label>
                <textarea id="queixa-principal" rows="3"
                    placeholder="Ex: Dispneia (falta de ar) progressiva há 3 dias, tosse produtiva."></textarea>
            </div>

            <div class="campo-grupo">
                <label for="historico-medico">Histórico Médico (Comorbidades):</label>
                <textarea id="historico-medico" rows="2"
                    placeholder="Ex: DPOC, Asma infantil, Tabagismo (20 anos/maço)."></textarea>
            </div>

            <div class="campo-grupo">
                <label>Fatores de Risco Respiratório:</label><br>
                <input type="checkbox" id="tabagismo" name="risco" value="tabagismo"><label
                    for="tabagismo">Tabagismo</label>
                <input type="checkbox" id="exposicao" name="risco" value="exposicao"><label for="exposicao">Exposição
                    Ocupacional</label>
            </div>
        </section>

        <hr>

        <section class="secao exame-fisico">
            <h2>2. Exame Físico e Sinais Vitais</h2>

            <div class="campo-linha">
                <div class="campo-pequeno">
                    <label for="saturacao">Saturação O2 (%):</label>
                    <input type="number" id="saturacao" min="0" max="100">
                </div>
                <div class="campo-pequeno">
                    <label for="frequencia-resp">FR (irpm):</label>
                    <input type="number" id="frequencia-resp" min="0">
                </div>
                <div class="campo-pequeno">
                    <label for="temperatura">Temperatura (°C):</label>
                    <input type="number" id="temperatura" step="0.1">
                </div>
            </div>

            <div class="campo-grupo">
                <label for="ausculta">Ausculta Pulmonar:</label>
                <textarea id="ausculta" rows="3"
                    placeholder="Ex: Murmúrio vesicular presente bilateralmente, creptações em base direita."></textarea>
            </div>
        </section>

        <hr>

        <section class="secao diagnostico-final">
            <h2>3. Diagnóstico e Conduta</h2>

            <div class="campo-grupo">
                <label for="cid">CID-10 (Código da Doença):</label>
                <input type="text" id="cid" placeholder="Ex: J44.9 (DPOC), J18.9 (Pneumonia)">
            </div>

            <div class="campo-grupo">
                <label for="diagnostico-principal">Diagnóstico Principal:</label>
                <input type="text" id="diagnostico-principal" required
                    placeholder="Digite o diagnóstico principal aqui.">
            </div>

            <div class="campo-grupo">
                <label for="diagnostico-diferencial">Diagnósticos Diferenciais:</label>
                <textarea id="diagnostico-diferencial" rows="2" placeholder="O que mais foi considerado?"></textarea>
            </div>

            <div class="campo-grupo">
                <label for="plano-conduta">Plano de Conduta/Próximos Passos:</label>
                <textarea id="plano-conduta" rows="4"
                    placeholder="Ex: Solicitar RX de tórax, iniciar antibiótico X, solicitar gasometria."></textarea>
            </div>

        </section>

    </main>

    <footer class="rodape-acoes">
        <button type="submit" class="botao-salvar">Salvar Diagnóstico</button>
        <button type="button" class="botao-exames">Ver/Solicitar Exames</button>
    </footer>

</body>

</html>