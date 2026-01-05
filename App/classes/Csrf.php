<?php

declare(strict_types=1);

namespace App\classes;

class Csrf
{
    private const string SESSION_KEY = 'csrf_token';

    private const string FORM_INPUT_NAME = 'csrf_token';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Gera e retorna o token CSRF.
     * @return string O token.
     */
    public function getToken(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Gera o campo de formulário HTML oculto.
     * @return string O HTML do campo.
     */
    public function field(): string
    {
        $token = $this->getToken();
        return '<input type="hidden" name="' . self::FORM_INPUT_NAME . '" value="' . $token . '">';
    }

    /**
     * Valida um token recebido contra o da sessão.
     * @param string|null $token O token recebido (geralmente de $_POST).
     * @return bool True se for válido, false caso contrário.
     */
    public function isValid(?string $token): bool
    {
        if (!$token || !isset($_SESSION[self::SESSION_KEY])) {
            return false;
        }

        return hash_equals($_SESSION[self::SESSION_KEY], $token);
    }
}