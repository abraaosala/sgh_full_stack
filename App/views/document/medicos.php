<?php

/** @var array $medicos */
/** @var string $title */
/** @var string $date */
/** @var string $hour */
/** @var array $hospital */
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?> - <?= $hospital['name'] ?></title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .hospital-name {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
        }

        .report-title {
            font-size: 18px;
            margin: 10px 0;
        }

        .meta {
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #0d6efd;
            color: white;
            text-align: left;
            padding: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            border-bottom: 1px solid #dee2e6;
            padding: 10px;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .bg-primary {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="hospital-name"><?= $hospital['name'] ?></div>
        <div class="report-title"><?= $title ?></div>
        <div class="meta">
            Data de Emissão: <?= $date ?> às <?= $hour ?> |
            Total de Registros: <?= count($medicos) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nº Ordem</th>
                <th>Nome do Médico</th>
                <th>Especialidade</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Província</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $m): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($m->numero_ordem) ?></strong></td>
                    <td><?= htmlspecialchars($m->usuario->nome) ?></td>
                    <td><?= htmlspecialchars($m->especialidade->nome ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($m->telefone) ?></td>
                    <td><?= htmlspecialchars($m->usuario->email) ?></td>
                    <td><?= htmlspecialchars($m->provincia->nome ?? 'N/A') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Documento gerado eletronicamente pelo Sistema de Gerenciamento Hospitalar - <?= $hospital['name'] ?>.
        Página 1 de 1
    </div>
</body>

</html>