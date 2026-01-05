<?php

declare(strict_types=1);

namespace App\Http;


class Response
{
    private int $status = 200;
    private string $message = '';
    private $data = null;
    private array $errors = [];
    private array $headers = [];

    /**
     * Define o código de status HTTP
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Define a mensagem
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Define os dados de resposta
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Define erros
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Adiciona um header personalizado
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Monta a resposta final
     */
    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json; charset=utf-8');

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo json_encode([
            'status'  => $this->status,
            'success' => $this->status >= 200 && $this->status < 300,
            'message' => $this->message,
            'data'    => $this->data,
            'errors'  => $this->errors
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        exit; // garante que nada mais será executado
    }
}