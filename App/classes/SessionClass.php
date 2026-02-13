<?php

namespace App\classes;

class SessionClass
{
    public function __construct(public string $sessionKey = 'user_logged') {}

    public function sets(array $data)
    {
        $_SESSION[$this->sessionKey] = $data;
    }

    /**
     * Remove os dados da sessão (logout)
     */
    public function logout(): void
    {
        unset($_SESSION[$this->sessionKey]);
    }

    public function get(string $get): mixed
    {
        return $this->session()[$get] ?? null;
    }

    public function has(?string $key = null): bool
    {
        return isset($_SESSION[$this->sessionKey]);
    }

    public function set(string $key, mixed $value): self
    {
        if (!isset($_SESSION[$this->sessionKey]) || !is_array($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }

        $_SESSION[$this->sessionKey][$key] = $value;
        return $this;
    }

    public function forget(string $key): void
    {
        if (isset($_SESSION[$this->sessionKey][$key])) {
            unset($_SESSION[$this->sessionKey][$key]);
        }
    }

    private function session()
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function dump()
    {
        dd($this->session());
    }
}
