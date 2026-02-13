<?php

/** @var array $pacientes */
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
    </style>
</head>

<body>
    <div class="header">
        <div class="hospital-name"><?= $hospital['name'] ?></div>
        <div class="report-title"><?= $title ?></div>
        <div class="meta">
            Data de Emissão: <?= $date ?> às <?= $hour ?> |
            Total de Pacientes: <?= count($pacientes) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome Completo</th>
                <th>Gênero</th>
                <th>Nascimento</th>
                <th>Telefone</th>
                <th>Província</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p->code) ?></strong></td>
                    <td><?= htmlspecialchars($p->usuario->nome) ?></td>
                    <td><?= genero($p->usuario->genero) ?></td>
                    <td><?= date('d/m/Y', strtotime($p->usuario->data_nascimento)) ?></td>
                    <td><?= htmlspecialchars($p->telefone) ?></td>
                    <td><?= htmlspecialchars($p->provincia->nome ?? 'N/A') ?></td>
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