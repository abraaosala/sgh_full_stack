<?php

/** @var string $nome */
/** @var string $email */
/** @var string $senha */
/** @var array $hospital */
/** @var string $date */
/** @var string $hour */
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Protocolo de Acesso - <?= $hospital['name'] ?></title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .content {
            margin-bottom: 40px;
        }

        .welcome {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .credentials-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .credential-item {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #495057;
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .value {
            font-size: 18px;
            color: #212529;
            font-family: 'Courier New', Courier, monospace;
            background: #fff;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            display: inline-block;
            border-radius: 4px;
        }

        .alert-box {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
        }

        .footer {
            position: fixed;
            bottom: 40px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .signature {
            margin-top: 60px;
            text-align: center;
        }

        .line {
            width: 250px;
            border-top: 1px solid #333;
            margin: 0 auto 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="hospital-name"><?= $hospital['name'] ?></div>
        <div class="report-title">Protocolo de Credenciais de Acesso</div>
    </div>

    <div class="content">
        <p class="welcome">Olá, <strong><?= htmlspecialchars($nome) ?></strong>,</p>
        <p>Sua conta no sistema do <?= $hospital['name'] ?> foi criada com sucesso. Abaixo estão as suas credenciais para o primeiro acesso:</p>

        <div class="credentials-box">
            <div class="credential-item">
                <span class="label">Endereço de E-mail:</span>
                <span class="value"><?= htmlspecialchars($email) ?></span>
            </div>
            <div class="credential-item">
                <span class="label">Senha Temporária:</span>
                <span class="value"><?= htmlspecialchars($senha) ?></span>
            </div>
        </div>

        <div class="alert-box">
            <strong>IMPORTANTE:</strong> Por motivos de segurança, você será solicitado a alterar esta senha temporária no seu primeiro login. Escolha uma senha segura e não a compartilhe com ninguém.
        </div>

        <p style="margin-top: 30px;">
            Para acessar o sistema, utilize o endereço: <br>
            <strong><?= root() ?></strong>
        </p>
    </div>

    <div class="signature">
        <div class="line"></div>
        <span>Assinatura do Responsável / Carimbo</span>
        <br>
        <small><?= $date ?> às <?= $hour ?></small>
    </div>

    <div class="footer">
        <?= $hospital['name'] ?> | <?= $hospital['street'] ?> <br>
        Este é um documento de protocolo gerado pelo sistema SGH.
    </div>
</body>

</html>