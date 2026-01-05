<?php

namespace App\Dao\Models;

// Arquivo gerado automaticamente em: 2025-08-24 07:18:53


class Diagnostico extends Model
{
    /**
     * O nome da tabela associada a este modelo.
     */
    protected string $table = 'diagnosticos'; 

    /**
     * O construtor da classe.
     * Define a tabela e chama o construtor da classe pai.
     */
    public function __construct(?string $entity = null) {

        parent::__construct($entity);

    }

    /**
     * Métodos específicos para o modelo Diagnostico podem ser adicionados aqui.
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