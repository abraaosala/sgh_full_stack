<?php

namespace App\classes;

class Logged
{
    /**
     * Construtor define a chave da sessão (padrão: "auth_user")
     */
    public function __construct(/**
     * Nome da chave usada na sessão
     */
    private readonly string $sessionKey = 'auth_user')
    {
        return $this->start();
    }

    /**
     * Inicia a sessão se ainda não estiver ativa
     */
    private function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Define os dados de login na sessão
     *
     * @return $this
     */
    public function set(array $data): self
    {
        $_SESSION[$this->sessionKey] = $data;
        return $this;
    }

    /**
     * Obtém os dados armazenados na sessão
     */
    public function get(): ?array
    {
        return $_SESSION[$this->sessionKey] ?? null;
    }

    /**
     * Verifica se há dados de sessão
     */
    public function check(): bool
    {
        return isset($_SESSION[$this->sessionKey]);
    }

    /**
     * Atualiza os dados da sessão
     *
     * @return $this
     */
    public function update(array $newData): self
    {
        $_SESSION[$this->sessionKey] = $newData;
        return $this;
    }

    /**
     * Remove os dados da sessão (logout)
     */
    public function logout(): void
    {
        unset($_SESSION[$this->sessionKey]);
    }

    /**
     * Destrói toda a sessão (cuidado ao usar!)
     */
    public function destroy(): void
    {
        session_destroy();
    }
}
