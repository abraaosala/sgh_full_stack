<?php

/** @var array $stats */
/** @var array $filters */
/** @var array $consultas_por_status */
/** @var array $top_medicos */
/** @var string $date */
/** @var array $hospital */
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório Gerencial - <?= $hospital['name'] ?></title>
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

        .stats-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .stats-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            text-align: center;
        }

        .stats-value {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            display: block;
        }

        .stats-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }

        h3 {
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-top: 30px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #0d6efd;
            color: white;
            text-align: left;
            padding: 8px;
            font-size: 12px;
        }

        td {
            border-bottom: 1px solid #dee2e6;
            padding: 8px;
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
        <div class="report-title">Relatório Gerencial de Desempenho</div>
        <div class="meta">
            Período: <?= $filters['month'] ? $filters['month'] . '/' . $filters['year'] : $filters['year'] ?> |
            Gerado em: <?= $date ?>
        </div>
    </div>

    <table class="stats-grid">
        <tr>
            <td class="stats-card">
                <span class="stats-value"><?= $stats['total_pacientes'] ?></span>
                <span class="stats-label">Pacientes</span>
            </td>
            <td class="stats-card">
                <span class="stats-value"><?= $stats['total_medicos'] ?></span>
                <span class="stats-label">Médicos</span>
            </td>
            <td class="stats-card">
                <span class="stats-value"><?= $stats['total_consultas'] ?></span>
                <span class="stats-label">Consultas</span>
            </td>
            <td class="stats-card">
                <span class="stats-value"><?= $stats['leitos_ocupados'] ?>/<?= $stats['leitos_total'] ?></span>
                <span class="stats-label">Ocupação Leitos</span>
            </td>
        </tr>
    </table>

    <div style="width: 100%;">
        <div style="width: 48%; display: inline-block; vertical-align: top;">
            <h3>Crescimento de Pacientes (Anual)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Novos Pacientes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $meses = [
                        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 
                        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 
                        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
                    ];
                    $dataPacientes = array_fill(1, 12, 0);
                    foreach ($pacientes_por_mes as $item) {
                        if (isset($item->mes) && $item->mes >= 1 && $item->mes <= 12) {
                            $dataPacientes[(int)$item->mes] = $item->total;
                        }
                    }
                    foreach ($meses as $num => $nome): ?>
                        <tr>
                            <td><?= $nome ?></td>
                            <td><?= $dataPacientes[$num] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="width: 48%; display: inline-block; vertical-align: top; margin-left: 3%;">
            <h3>Consultas por Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas_por_status as $s): ?>
                        <tr>
                            <td><?= $s->status ?></td>
                            <td><?= $s->total ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Perfil de Gênero</h3>
            <table>
                <thead>
                    <tr>
                        <th>Gênero</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($genero_distribuicao as $g): ?>
                        <tr>
                            <td><?= $g->genero ?: 'Não informado' ?></td>
                            <td><?= $g->total ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="page-break-before: always;"></div>

    <h3>Demanda por Especialidade (Top procuradas)</h3>
    <table>
        <thead>
            <tr>
                <th>Especialidade</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas_por_especialidade as $esp): ?>
                <tr>
                    <td><?= $esp->nome ?></td>
                    <td><?= $esp->total ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Top Médicos (Produtividade)</h3>
    <table>
        <thead>
            <tr>
                <th>Médico</th>
                <th>Total de Consultas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($top_medicos as $m): ?>
                <tr>
                    <td><?= $m->nome ?></td>
                    <td><?= $m->total ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Este documento é um relatório gerencial oficial do <?= $hospital['name'] ?>.
        Gerado em: <?= $date ?>
    </div>
</body>

</html>