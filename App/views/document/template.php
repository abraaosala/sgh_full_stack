<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pacientes</title>
    <style>
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        margin: 20px;
        color: #333;
    }

    /* Estilos do Cabeçalho do Hospital */
    .hospital-header {
        margin-bottom: 30px;
        border-bottom: 1px solid #eee;
        /* Linha divisória sutil */
        padding-bottom: 90px;
        overflow: hidden;
        /* Para conter os floats */
        font-size: 11px;
        /* Letras pequenas para as informações gerais */
        color: #555;
    }

    .hospital-logo {
        float: left;
        margin-right: 15px;
        max-width: 80px;
        /* Tamanho da logo */
        height: auto;
    }

    .hospital-info {
        float: left;
        line-height: 1.4;
        /* Espaçamento entre linhas */
    }

    .hospital-info strong {
        font-size: 13px;
        /* Nome do hospital um pouco maior */
        color: #0056b3;
        display: block;
        /* Para o nome ficar em sua própria linha */
        margin-bottom: 3px;
    }

    .report-meta {
        float: right;
        text-align: right;
        line-height: 1.4;
        color: #777;
    }

    .report-meta .report-title-small {
        font-weight: bold;
        color: #333;
        font-size: 13px;
    }


    h1 {
        text-align: center;
        color: #0056b3;
        margin-top: 20px;
        /* Espaço após o cabeçalho do hospital */
        margin-bottom: 30px;
        font-size: 26px;
        /* Ajustado um pouco, o título principal ainda se destaca */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-size: 13px;
        /* Tamanho da fonte das células da tabela */
    }

    th {
        background-color: #e9ecef;
        color: #495057;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 11px;
        /* Rodapé também pequeno */
        color: #777;
    }
    </style>
</head>

<body>
    <div class="hospital-header">
        <img src="https://via.placeholder.com/80x80?text=Logo" alt="Logo do Hospital" class="hospital-logo">
        <div class="hospital-info">
            <strong>Hospital Exemplo de Saúde Ltda.</strong>
            Rua da Amostra, 123 - Centro<br>
            Cidade, UF - CEP 12345-678<br>
            Telefone: (XX) XXXX-XXXX | CNPJ: XX.XXX.XXX/XXXX-XX<br>
            E-mail: contato@hospitalexemplo.com.br
        </div>
        <div class="report-meta">
            <span class="report-title-small">Relatório de Pacientes</span><br>
            Data de Emissão: 26/10/2023<br>
            Hora de Emissão: 10:30<br>
            Período: 01/01/2023 a 26/10/2023<br>
            Página: 1 de 1
        </div>
    </div>

    <h1>Lista de Pacientes Ativos</h1> <!-- Título principal do relatório -->

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Data de Nascimento</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>Maria Silva</td>
                <td>15/03/1980</td>
                <td>123.456.789-00</td>
                <td>(11) 98765-4321</td>
                <td>maria.silva@email.com</td>
            </tr>
            <tr>
                <td>002</td>
                <td>João Santos</td>
                <td>22/07/1992</td>
                <td>098.765.432-10</td>
                <td>(21) 99876-5432</td>
                <td>joao.santos@email.com</td>
            </tr>
            <tr>
                <td>003</td>
                <td>Ana Oliveira</td>
                <td>01/11/1975</td>
                <td>111.222.333-44</td>
                <td>(31) 97777-1111</td>
                <td>ana.o@email.com</td>
            </tr>
            <tr>
                <td>004</td>
                <td>Pedro Souza</td>
                <td>05/09/2001</td>
                <td>444.555.666-77</td>
                <td>(41) 96666-2222</td>
                <td>pedro.s@email.com</td>
            </tr>
            <tr>
                <td>005</td>
                <td>Carla Lima</td>
                <td>18/02/1988</td>
                <td>777.888.999-00</td>
                <td>(51) 95555-3333</td>
                <td>carla.l@email.com</td>
            </tr>
            <tr>
                <td>006</td>
                <td>Rafael Costa</td>
                <td>29/11/1985</td>
                <td>222.333.444-55</td>
                <td>(61) 94444-5555</td>
                <td>rafael.c@email.com</td>
            </tr>
            <tr>
                <td>007</td>
                <td>Fernanda Rocha</td>
                <td>03/06/1995</td>
                <td>555.666.777-88</td>
                <td>(71) 93333-6666</td>
                <td>fernanda.r@email.com</td>
            </tr>
            <tr>
                <td>008</td>
                <td>Guilherme Mello</td>
                <td>10/01/1970</td>
                <td>888.999.000-11</td>
                <td>(81) 92222-7777</td>
                <td>guilherme.m@email.com</td>
            </tr>
            <!-- Adicione mais linhas <tr> com dados de pacientes aqui -->
        </tbody>
    </table>

    <div class="footer">
        Gerado por Sistema de Gerenciamento de Clínicas - Página 1 de 1
    </div>
</body>

</html>