<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-06 21:16:20


class Especialidade extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'especialidades'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);

    }

    /**
     * Métodos específicos para o modelo Especialidade podem ser adicionados aqui.
     *
     * Exemplo:
     *
     * public function findbyEmail($emailId)
     * {
     *       return $this->select($fields)
     *     ->where('email', '=', $emailId)
     *     ->first();
     * }
     */
}