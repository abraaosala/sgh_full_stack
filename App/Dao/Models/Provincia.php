<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-07 05:40:57


class Provincia extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'provincias'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);

    }

    /**
     * Métodos específicos para o modelo Provincia podem ser adicionados aqui.
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