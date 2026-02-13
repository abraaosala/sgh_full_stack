<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPUnit\Framework\MockObject\Stub\Exception as StubException;

class MailService
{
    private $mail;

    public function __construct()
    {
        // A inicialização agora ocorre sob demanda no método sendCredentials
    }

    /**
     * Envia as credenciais de acesso para o novo usuário.
     *
     * @param string $to Email do destinatário
     * @param string $name Nome do destinatário
     * @param string $password Senha gerada
     * @return bool
     */
    public function sendCredentials(string $to, string $name, string $password): bool
    {
        $enabled = env('MAIL_ENABLED');
        $username = env('EMAIL_USERNAME');

        if ($enabled !== 'true' || empty($username)) {
            return true; // Ignora se estiver desativado ou sem configuração
        }

        try {
            $this->mail = new PHPMailer(true);

            // Configurações do Servidor
            $this->mail->isSMTP();
            $this->mail->Host       = env('EMAIL_HOST');
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = $username;
            $this->mail->Password   = env('EMAIL_PASSWORD');
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = env('EMAIL_PORT', 587);
            $this->mail->CharSet    = 'UTF-8';

            // Remetente Padrão
            $this->mail->setFrom($username, env('APP_NAME', 'SGH'));

            $this->mail->addAddress($to, $name);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Suas credenciais de acesso ao SGH';

            $body = "<h2>Olá, {$name}!</h2>";
            $body .= "<p>Sua conta no <strong>Sistema de Gerenciamento Hospitalar (SGH)</strong> foi criada com sucesso.</p>";
            $body .= "<p>Abaixo estão suas credenciais de acesso:</p>";
            $body .= "<ul>";
            $body .= "<li><strong>E-mail:</strong> {$to}</li>";
            $body .= "<li><strong>Senha Temporária:</strong> <span style='background: #f4f4f4; padding: 2px 5px; font-family: monospace;'>{$password}</span></li>";
            $body .= "</ul>";
            $body .= "<p>Recomendamos que você altere sua senha após o primeiro acesso.</p>";
            $body .= "<br><p>Atenciosamente,<br>Equipe SGH</p>";

            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }
}
