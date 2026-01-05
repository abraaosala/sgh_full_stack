<?php

namespace App\Http;

use Closure;

class Route
{
    private static array $routes = [];

    private static int|string|null $lastRouteKey = null;

    /**
     * @var array Mantém a pilha de atributos de grupo (prefixo, middleware).
     */
    private static array $groupStack = [];

    public static function get(string $path, string $action): self
    {
        self::addRoute($path, $action, 'GET');
        return new self();
    }

    public static function post(string $path, string $action): self
    {
        self::addRoute($path, $action, 'POST');
        return new self();
    }

    public static function put(string $path, string $action): self
    {
        self::addRoute($path, $action, 'PUT');
        return new self();
    }

    public static function delete(string $path, string $action): self
    {
        self::addRoute($path, $action, 'DELETE');
        return new self();
    }

    /**
     * Adiciona um ou mais middlewares à última rota registrada.
     *
     * @param string|array $middleware O nome da classe do middleware ou um array de nomes.
     */
    public function middleware(string|array $middleware): self
    {
        if (self::$lastRouteKey !== null) {
            $middlewares = is_array($middleware) ? $middleware : [$middleware];
            // Adiciona os novos middlewares aos já existentes (vindos do grupo, por exemplo)
            self::$routes[self::$lastRouteKey]['middleware'] = array_merge(
                self::$routes[self::$lastRouteKey]['middleware'],
                $middlewares
            );
        }

        return $this;
    }

    /**
     * Cria um grupo de rotas com atributos compartilhados.
     *
     * @param array $attributes Atributos como ['middleware' => '...', 'prefix' => '...']
     * @param Closure $callback A função que define as rotas dentro do grupo.
     */
    public static function group(array $attributes, Closure $callback): void
    {
        // Adiciona os atributos do grupo atual à pilha
        self::$groupStack[] = $attributes;

        // Executa o callback que define as rotas
        call_user_func($callback);

        // Remove os atributos do grupo da pilha para não afetar as próximas rotas
        array_pop(self::$groupStack);
    }

    private static function addRoute(string $path, string $action, string $method): void
    {
        $groupAttributes = self::$groupStack === [] ? [] : end(self::$groupStack);

        $prefix = $groupAttributes['prefix'] ?? '';
        $fullPath = rtrim((string) $prefix, '/') . '/' . ltrim($path, '/');
        // Corrige barras duplas e garante que a raiz "/" funcione
        $fullPath = ($fullPath !== '/') ? rtrim($fullPath, '/') : '/';
        if ($fullPath === '' || $fullPath === '0') {
            $fullPath = '/';
        }

        $groupMiddleware = $groupAttributes['middleware'] ?? [];
        $middlewares = is_array($groupMiddleware) ? $groupMiddleware : [$groupMiddleware];

        self::$routes[] = [
            'path'       => $fullPath,
            'action'     => $action,
            'method'     => strtoupper($method),
            'middleware' => $middlewares, // Middleware inicial vem do grupo
        ];

        self::$lastRouteKey = array_key_last(self::$routes);
    }

    public static function getAllRoutes(): array
    {
        self::$lastRouteKey = null;
        return self::$routes;
    }
}
