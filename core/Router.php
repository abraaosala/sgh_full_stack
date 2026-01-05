<?php

namespace core;

use App\Http\Request;
use App\Http\Route;
use core\Controller;
use App\controllers\ErrorPage;

class Router extends Controller
{
    // Armazena todas as rotas registradas
    private ?array $routes = [];
    
    // Armazena a URI da requisição atual
    private readonly string $uri;

    // Construtor: inicializa as rotas e a URI da requisição
    public function __construct()
    {
        $this->routes = Route::getAllRoutes();
        $this->uri = $_SERVER['REQUEST_URI']; # Ou Request::method()
    }

    /**
     * Monta uma coleção de rotas a partir do array de rotas fornecido.
     * @param array $routes Lista de rotas
     * @param bool $withSlash Adiciona barra no início do path
     * @return array Coleção de rotas formatadas
     */
    private function buildRouteCollection(array $routes, bool $withSlash = true): array
    {
        $collection = [];
        foreach ($routes as $route) {
            $path = $route['path'];
            $action = $route['action'];
            $method = $route['method'];
            if ($withSlash) {
                $collection['/' . $path] = [$action, $method];
            }
            
            $collection[$path] = [$action, $method];
        }
        
        return $collection;
    }

    public function  getUri()
    {
        return $this->uri;
    }
    

    /**
     * Tenta encontrar uma rota que corresponda exatamente à URI fornecida.
     * @param string $uri URI da requisição
     * @param array $routes Coleção de rotas
     * @return array Rota correspondente ou array vazio
     */
    private function matchExactRoute(string $uri, array $routes): array
    {
        $uri = trim($uri);
        if (array_key_exists($uri, $routes)) {
            return [$uri => $routes[$uri]];
        }
        
        return [];
    }

    /**
     * Tenta encontrar rotas que correspondam à URI usando regex.
     * @param string $uri URI da requisição
     * @param array $routes Coleção de rotas
     * @return array Rotas correspondentes
     */
    private function matchRegexRoute(string $uri, array $routes): array
    {
        $uri = trim($uri, '/');
        return array_filter($routes, function ($key) use ($uri) {
            $pattern = str_replace('/', '\/', ltrim($key, '/'));
            return preg_match(sprintf('/^%s$/', $pattern), $uri);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Extrai parâmetros da URI comparando com a rota correspondente.
     * @param array $uriParts Partes da URI
     * @param array $matched Rota correspondente
     * @return array Parâmetros extraídos
     */
    private function params(array $uri, array $matched): array
    {
        if ($matched !== []) {
            $matchedToGetParams = array_keys($matched)[0];
            return array_diff(
                $uri,
                explode('/', (string) $matchedToGetParams)
            );
        }
        
        return [];
    }

    /**
     * Formata os parâmetros extraídos em um array associativo.
     * @param array $uriParts Partes da URI
     * @param array $params Parâmetros extraídos
     * @return array Parâmetros formatados
     */
    private function paramsFormat($uri, $params): array
    {
        $paramsData = [];
        foreach ($params as $index => $param) {
            $paramsData[$uri[$index - 1]] = $param;
        }

        return $paramsData;
    }

    /**
     * Método principal do roteador: resolve a rota e despacha para o controlador.
     */
    public function router()
    {
        // Monta a coleção de rotas
        $routes = $this->buildRouteCollection($this->routes, false);

        $uri = strtok($this->uri, '?');

        // 1. Tenta encontrar rota exata
        $matched = $this->matchExactRoute($uri, $routes);

        $params = [];
        if ($matched === []) {
            // 2. Tenta por regex
            $matched = $this->matchRegexRoute($uri, $routes);
            $uriParts = explode("/", $uri);
            $params = $this->params($uriParts, $matched);
            $params = $this->paramsFormat($uriParts, $params);
        }

        $matchedKey = array_key_first($matched);
        $matchedData = $matched[$matchedKey] ?? [];
        $method = $matchedData[1] ?? '';

        // Verifica se o método HTTP corresponde
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $matchedData = [];
        }

        if (!empty($matchedData)) {
            // 🔥 Aqui executamos o middleware
            $routeData = $this->findRouteData($matchedKey, $method);
            $this->runMiddlewares($routeData['middleware'] ?? []);

            // Despacha para o controlador
            self::dispatch($matchedData[0], $params, $uri);
            return;
        }

        // Rota não encontrada
        throw new \Exception(sprintf("Algo deu errado: Rota '%s' não encontrada ou método '%s' incorreto.", $this->uri, $method));
    }
    
    /**
     * Retorna os dados completos da rota correspondente a path + method.
     */
    private function findRouteData(string $path, string $method): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                return $route;
            }
        }
        
        return null;
    }

 
    /**
     * Executa os middlewares fornecidos, com suporte para condições 'OU' em arrays aninhados.
     */
    private function runMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            // Se o item for um array, trata como uma condição 'OU'
            if (is_array($middleware)) {
                // Se for um array, significa que é um "OU" (grupo de middlewares alternativos)
                $oneOfThesePassed = false;
                foreach ($middleware as $orMiddlewareClass) {
                    try {
                        // Tenta executar o middleware
                        $instance = new $orMiddlewareClass();
                        $instance->handle();

                        // Se o handle() não lançar exceção ou redirecionar, significa que passou.
                        $oneOfThesePassed = true;
                        break; // Sai do loop 'OU' assim que o primeiro passar
                    } catch (\Exception) {
                        // Ignora a falha de um middleware 'OU' e tenta o próximo.
                        // Você pode querer logar o erro aqui se for necessário.
                    }
                }

                // Se nenhum dos middlewares na condição 'OU' passou, então falha geral.
                if (!$oneOfThesePassed) {
                    throw new \Exception("Acesso negado. Nenhuma das permissões necessárias foi atendida.");
                }
            }
            // Se não for um array, trata como uma condição 'E' (padrão)
            else {
                $middlewareClass = $middleware;

                if (!class_exists($middlewareClass)) {
                    throw new \Exception(sprintf('Middleware %s não encontrado.', $middlewareClass));
                }

                $instance = new $middlewareClass();

                if (!method_exists($instance, 'handle')) {
                    throw new \Exception(sprintf('Middleware %s precisa ter um método handle().', $middlewareClass));
                }

                // Executa o middleware 'E'
                $instance->handle();
            }
        }
    }
}