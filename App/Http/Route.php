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

    public static function get(string $path, string|callable|array $action): self
    {
        self::addRoute($path, $action, 'GET');
        return new self();
    }

    public static function post(string $path, string|callable|array $action): self
    {
        self::addRoute($path, $action, 'POST');
        return new self();
    }

    public static function put(string $path, string|callable|array $action): self
    {
        self::addRoute($path, $action, 'PUT');
        return new self();
    }

    public static function delete(string $path, string|callable|array $action): self
    {
        self::addRoute($path, $action, 'DELETE');
        return new self();
    }

    // ... (o método middleware continua igual)
    public function middleware(string|array $middleware): self
    {
        if (self::$lastRouteKey !== null) {
            $middlewares = is_array($middleware) ? $middleware : [$middleware];
            self::$routes[self::$lastRouteKey]['middleware'] = array_merge(
                self::$routes[self::$lastRouteKey]['middleware'],
                $middlewares
            );
        }

        return $this;
    }

    // ... (o método group continua igual)
    public static function group(array $attributes, Closure $callback): void
    {
        self::$groupStack[] = $attributes;
        call_user_func($callback);
        array_pop(self::$groupStack);
    }


    // ✅ PASSO 2: Atualize também a assinatura do método addRoute
    private static function addRoute(string $path, string|callable|array $action, string $method): void
    {
        $groupAttributes = self::$groupStack === [] ? [] : end(self::$groupStack);

        $prefix = $groupAttributes['prefix'] ?? '';
        $fullPath = rtrim((string) $prefix, '/') . '/' . ltrim($path, '/');
        $fullPath = ($fullPath !== '/') ? rtrim($fullPath, '/') : '/';
        if ($fullPath === '' || $fullPath === '0') {
            $fullPath = '/';
        }

        $groupMiddleware = $groupAttributes['middleware'] ?? [];
        $middlewares = is_array($groupMiddleware) ? $groupMiddleware : [$groupMiddleware];

        self::$routes[] = [
            'path'       => $fullPath,
            'action'     => $action, // Agora pode ser string, Closure ou array
            'method'     => strtoupper($method),
            'middleware' => $middlewares,
        ];

        self::$lastRouteKey = array_key_last(self::$routes);
    }

    public static function getAllRoutes(): array
    {
        self::$lastRouteKey = null;
        return self::$routes;
    }
}
