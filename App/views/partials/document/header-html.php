<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$title??''?>
    </title>
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