<?php

namespace core;

use App\Http\Request;
use Exception;

abstract class Controller
{
    public static function dispatch($action, $params, $uri)
    {
        $callable = null;
        $controllerName = null;
        $method = null;

        // 1. Ação é uma Closure?
        if ($action instanceof \Closure) {
            $callable = $action;
        }
        // 2. É um array [Controller::class, 'method']?
        elseif (is_array($action) && count($action) === 2) {
            [$controllerName, $method] = $action;
        }
        // 3. É uma string?
        elseif (is_string($action)) {
            // 3a. É 'Controller@method' ou 'Controller::method'?
            if (str_contains($action, '::')) {
                [$controllerName, $method] = explode('::', $action, 2);
            } elseif (str_contains($action, '@')) {
                [$controllerName, $method] = explode('@', $action, 2);
            }
            // ✅ PASSO ADICIONADO AQUI
            // 3b. Se não, assume que é um Invokable Controller
            else {
                $controllerName = $action;
                $method = '__invoke'; // O método padrão para invokables
            }
        }

        // Se após as verificações, não tivermos uma ação válida, a rota é inválida.
        if (!$callable && !$controllerName) {
            throw new Exception("Definição de rota inválida.", 500);
        }

        // Se não for uma Closure, precisamos instanciar o controller
        if ($controllerName) {
            // Lógica para resolver o nome completo da classe
            if (!class_exists($controllerName)) {
                // Tenta resolver com o namespace padrão de controllers
                $resolvedName = NAMESPACE_CONTROLLER . str_replace('Controller', '', $controllerName) . 'Controller';
                // Para invokables, o nome pode não terminar em "Controller", então verificamos o nome original também
                if (class_exists(NAMESPACE_CONTROLLER . $controllerName)) {
                    $resolvedName = NAMESPACE_CONTROLLER . $controllerName;
                }

                if (!class_exists($resolvedName)) {
                    throw new Exception(sprintf('Controller %s não encontrado.', $controllerName), 500);
                }

                $controllerName = $resolvedName;
            }

            $controllerInstance = new $controllerName();

            if (!method_exists($controllerInstance, $method)) {
                throw new Exception(sprintf('O método %s não existe no controller %s.', $method, $controllerName), 500);
            }

            // Cria o callable final
            $callable = [$controllerInstance, $method];
        }

        // Executa o callable
        $result = call_user_func($callable, $params, $uri);

        // if (Request::method() === 'POST') {
        //     die();
        // }

        return $result;
    }
}
