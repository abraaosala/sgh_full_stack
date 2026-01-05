<?php

namespace App\Http;

use App\trait\TemplateView as View;

abstract class BaseController
{
    use View;

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
