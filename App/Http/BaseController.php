<?php

namespace App\Http;

use App\library\View;

abstract class BaseController
{
    public function view(array $data, string $view = 'dashboard')
    {
        View::render($view, $data);
    }

    // Métodos padrão de controllers RESTful
    // Listar recursos
    abstract public function index();

    // Exibir recurso específic
    abstract public function show($params);

    // criar novo recurso
    abstract   public function create();

    abstract public function store();

    // Salvar novo recurso

    // Editar recurso existente
    abstract public function edit($params);

    // Atualizar recurso existente
    abstract public function update($params);

    // Apagar  recurso existente
    abstract public function delete($params);
}
