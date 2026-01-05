<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        line-height: 1.6;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        color: #0056b3;
    }

    .section {
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .section h2 {
        font-size: 18px;
        color: #333;
        margin-bottom: 10px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .data-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        width: 30%;
    }

    .notes {
        border: 1px solid #ddd;
        padding: 10px;
        background-color: #f9f9f9;
        min-height: 80px;
    }

    .footer {
        text-align: center;
        margin-top: 30px;
        font-size: 10px;
        color: #777;
    }
    </style>
</head>

<body>

    <div class="header">
        <h1>Ficha de Consulta</h1>
        <p>Sistema de Gestão Hospitalar</p>
    </div>

    <div class="section">
        <h2>Dados do Paciente</h2>
        <table class="data-table">
            <tr>
                <th>Nome</th>
                <td><?= htmlspecialchars((string) $consulta['paciente_nome']) ?></td>
            </tr>
            <!--   <tr>
            <th>NIF</th>
            <td><?= htmlspecialchars((string) $consulta['paciente_nif']) ?></td>
        </tr> -->
            <tr>
                <th>Data de Nascimento</th>
                <td><?= htmlspecialchars((string) $patientBirthDate) ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Dados da Consulta</h2>
        <table class="data-table">
            <tr>
                <th>ID da Consulta</th>
                <td><?= htmlspecialchars((string) $consulta['id']) ?></td>
            </tr>
            <tr>
                <th>Data</th>
                <td><?= htmlspecialchars((string) $consultationDate) ?></td>
            </tr>
            <tr>
                <th>Hora</th>
                <td><?= htmlspecialchars((string) $consulta['hora']) ?></td>
            </tr>
            <tr>
                <th>Médico</th>
                <td><?= htmlspecialchars((string) $consulta['medico_nome']) ?></td>
            </tr>
            <tr>
                <th>Especialidade</th>
                <td><?= htmlspecialchars((string) $consulta['medico_especialidade']) ?></td>
            </tr>
            <!-- <tr>
            <th>Clínica</th>
            <td><?= htmlspecialchars((string) $consulta['clinica']) ?></td>
        </tr> -->
            <tr>
                <th>Estado</th>
                <td><?= htmlspecialchars((string) $consulta['estado_formatado']) ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Notas da Consulta</h2>
        <div class="notes"><?= nl2br(htmlspecialchars($consulta['notas'] ?? 'N/A')) ?></div>
    </div>

    <div class="footer">
        Gerado em <?= date('d/m/Y H:i:s') ?>
    </div>
</body>


</html>