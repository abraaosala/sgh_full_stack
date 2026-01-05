<?php

namespace App\classes;

class SessionClass
{
    public function __construct(public string $sessionKey = 'user_logged')
    {
    }

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

    public function get(string $get): int|string
    {
        return $this->session()[$get];
    }

    public function has(?string $key = null): bool
    {

        return isset($_SESSION[$this->sessionKey]);
    }

    public function set(string $key, string $value): self
    {
        $this->session()[$key] = $value;
        return $this;
    }




    private function session()
    {
        return $_SESSION[$this->sessionKey];
    }

    public function dump()
    {
        dd($this->session());
    }


}
