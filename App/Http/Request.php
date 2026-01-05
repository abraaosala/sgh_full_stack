<?php

namespace App\Http;

class Request
{
    private readonly string $method;

    private readonly string $uri;

    private array $headers;

    private array $body;

    private array $query;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->headers = getallheaders();
        $this->body = $this->parseBody();
        $this->query = $_GET;
    }


    private function parseBody(): array
    {
        if ($this->method === 'POST' || $this->method === 'PUT') {
            $contentType = $this->headers['Content-Type'] ?? '';
            if (str_contains($contentType, 'application/json')) {
                $rawBody = file_get_contents('php://input');
                return json_decode($rawBody, true) ?? [];
            }
        }

        return $_POST ?? [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHeader(string $key, $default = null): ?string
    {
        return $this->headers[$key] ?? $default;
    }

    public function getBody(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->body;
        }

        return $this->body[$key] ?? $default;
    }

    public function getQuery(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->query;
        }

        return $this->query[$key] ?? $default;
    }

    public static function method(?string $uri = 'url')
    {
        return isset($_GET[$uri]) ? "/" . $_GET[$uri] : '/';
    }
}